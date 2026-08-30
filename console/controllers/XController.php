<?php

namespace console\controllers;

use backend\models\competitors\CompetitorPrice;
use backend\models\IpBot;
use backend\models\ReportItem;
use common\models\ActivePages;
use common\models\Categories\CategoriesProperties;
use common\models\Categories\Category;
use common\models\shop\Product;
use common\models\shop\ProductProperties;
use common\models\shop\ProductPropertiesTranslate;
use common\models\shop\ProductTag;
use common\models\shop\PropertiesNameTranslate;
use DOMDocument;
use DOMXPath;
use Yii;
use yii\console\Controller;
use yii\db\Expression;
use yii\helpers\Console;

class XController extends Controller
{

    /**
     *  Найти похожие IP и заменить их всем диапазоном
     */
    public function actionFindCloneIp()
    {
        $ips = IpBot::find()->select('ip')->column();

        foreach ($ips as $key => $ip) {
            $parts = explode('.', $ip);
            array_pop($parts);
            $ips[$key] = implode('.', $parts) . '.';
        }

        $ips = array_unique($ips);
        $i = 1;

        foreach ($ips as $ip) {
            $ipStatistic = IpBot::find()
                ->where(['like', 'ip', $ip])
                ->count();

            if ($ipStatistic >= 3) {

                $isp = IpBot::find()
                    ->select('isp')
                    ->where(['like', 'ip', $ip])
                    ->scalar();

                if ($isp) {
                    $model = new IpBot();
                    $model->ip = $ip;
                    $model->isp = $isp;
                    $model->blocking = 1;
                    $model->comment = 'Весь диапазон IP';

                    if ($model->save()) {
                        IpBot::deleteAll([
                            'and',
                            ['like', 'ip', $ip],
                            ['!=', 'id', $model->id],
                        ]);
                        echo "$i \t  У \t $ip \t совпадений \t $ipStatistic \n";
                        $i++;
                    } else {
                        dd($model->errors);
                    }
                } else {
                    echo "ISP не существует \n";
                }
            }
        }
    }

    /**
     *  Добавление Тегов продуктам по категориям
     */
    public function actionTagProducts()
    {
        $categoryId = 5;
        $tagId = 86;

        $productsId = Product::find()
            ->select('id')
            ->where(['category_id' => $categoryId])
            ->andWhere(['not in', 'id', ProductTag::find()->select('product_id')->where(['tag_id' => $tagId])])
            ->column();
        if ($productsId) {
            $i = 1;
            foreach ($productsId as $item) {
                $model = new ProductTag();
                $model->product_id = $item;
                $model->tag_id = $tagId;
                if ($model->save()) {
                    echo "$i \t  Сохранено  \n";
                } else {
                    dd($model->errors);
                }
                $i++;
            }
        } else {
            echo "\n\t  Нет результатов для \tКатегории $categoryId \tи \tТега $tagId \n";
        }
    }


    //======================================================

    /**
     *  Исправление свойств ID в переводах продуктов
     */
    public function actionAuditProductProperties()
    {
        $languages = ['ru', 'en'];

        // Загружаем все ProductProperties
        $productsP = ProductProperties::find()
            ->select([
                'id AS pp_id',
                'product_id',
                'property_id AS property_id_uk',
            ])
            ->asArray()
            ->all();

        // Массив для кеширования переведённых свойств
        $propertyTranslations = [];

        // Заполняем переводы для всех продуктов одним запросом
        foreach ($languages as $lang) {
            $propertyTranslations[$lang] = PropertiesNameTranslate::find()
                ->select(['id', 'name_id'])
                ->where(['language' => $lang])
                ->indexBy('name_id') // Индексируем по name_id для быстрого поиска
                ->asArray()
                ->column();
        }

        // Добавляем переводы в productsP
        foreach ($productsP as $index => $productP) {
            foreach ($languages as $lang) {
                $key = 'property_id_' . $lang;
                $productsP[$index][$key] = $propertyTranslations[$lang][$productP['property_id_uk']] ?? null;
            }
        }

        $i = 1;

        // Загружаем все ProductPropertiesTranslate одним запросом
        $productsPT = ProductPropertiesTranslate::find()
            ->select(['id', 'propertyName_id', 'product_id', 'product_properties_id', 'language'])
            ->where(['language' => $languages])
            ->asArray()
            ->all();

        // Индексируем по product_id для быстрого доступа
        $productsPTGrouped = [];
        foreach ($productsPT as $productPT) {
            $productsPTGrouped[$productPT['product_id']][] = $productPT;
        }

        foreach ($productsP as $productP) {
            if (!isset($productsPTGrouped[$productP['product_id']])) {
                echo "$i\tНе существует\n";
                $i++;
                continue;
            }

            foreach ($productsPTGrouped[$productP['product_id']] as $productPT) {
                $lang = $productPT['language'];
                $key = 'property_id_' . $lang;

                if ($productP['pp_id'] !== $productPT['product_properties_id'] && $productP[$key] == $productPT['propertyName_id']) {
                    $model = ProductPropertiesTranslate::findOne(['id' => $productPT['id'], 'language' => $lang]);

                    if ($model) {
                        $model->product_properties_id = $productP['pp_id'];
//                         $model->save(); // Раскомментировать для сохранения

                        echo "$i\t{$productP['product_id']}\t{$productP['pp_id']} \t + \t Перезаписано! \t PP_{$lang} {$productP[$key]}\t PPT_{$lang} {$productPT['propertyName_id']}\t ID {$productPT['product_properties_id']}\n";
                    }
                } else {
                    echo "$i\t{$productP['product_id']}\t{$productP['pp_id']} \t - \t Не Записано! \t PP_{$lang} {$productP[$key]}\t PPT_{$lang} {$productPT['propertyName_id']}\t ID {$productPT['product_properties_id']}\n";
                }

                $i++;
            }
        }
    }

    /**
     *  Имена продуктов в Report
     */
    public function actionReportProductsName()
    {

//        $productsName = Product::find()
//            ->select(['name'])
//            ->asArray()
//            ->column();

        $products = ReportItem::find()
            ->select(['product_name', 'COUNT(*) AS count'])
            ->groupBy('product_name')
            ->orderBy(['product_name' => SORT_ASC])
            ->asArray()
            ->all();

        usort($products, function ($a, $b) {
            return strcmp($a['product_name'], $b['product_name']);
        });

        $i = 1;
        foreach ($products as $product) {

            echo "\t $i \t" . $product['count'] . "\t " . $product['product_name'] . "\n";
            $i++;

        }

    }

    /**
     *  Удалить Белый фон
     */
    public function actionClearWebp()
    {

        $path = Yii::getAlias('@frontend') . '/web/product/113';

//                dd($path);

        $files = glob($path . '/*.webp');

        foreach ($files as $file) {
            // удаляем фон + перезаписываем файл
            $cmd = "magick convert \"$file\" -fuzz 10% -transparent white \"$file\"";
            exec($cmd);
        }

        return "Готово. Обработано файлов: " . count($files);
    }


    //======================================================

    /**
     *  Добввить товарам недостающие свойства из категории
     */
    public function actionAddPropertiesProducts()
    {

        $categoriesId = Category::find()->select('id')->where(['visibility' => true])->column();

        foreach ($categoriesId as $categoryId) {

            $categoryPropertiesId = CategoriesProperties::find()
                ->select('property_id')
                ->where(['category_id' => $categoryId])
                ->column();

            $productsId = Product::find()
                ->select('id')
                ->where(['category_id' => $categoryId])
                ->column();

            foreach ($productsId as $productId) {
                foreach ($categoryPropertiesId as $propertyId) {
                    $productProperties = ProductProperties::find()
                        ->where(['product_id' => $productId])
                        ->andWhere(['property_id' => $propertyId])
                        ->asArray()
                        ->all();

                    if (!$productProperties) {

                        $property = new ProductProperties();
                        $property->product_id = $productId;
                        $property->property_id = $propertyId;
                        $property->category_id = $categoryId;

                        if ($property->save()) {

                            echo "\t Сохранено свойство \n";

                            $propertyIdTranslate = PropertiesNameTranslate::find()
                                ->select('id')
                                ->where(['name_id' => $propertyId])
                                ->andWhere(['language' => 'ru'])
                                ->one();

                            $propertyTranslate = new ProductPropertiesTranslate();
                            $propertyTranslate->product_properties_id = $property->id;
                            $propertyTranslate->language = 'ru';
                            $propertyTranslate->propertyName_id = $propertyIdTranslate->id;
                            $propertyTranslate->product_id = $productId;

                            if ($propertyTranslate->save()) {

                                echo "\t Сохранено свойство перевод \n";

                            } else {
                                dd($propertyTranslate->errors);
                            }
                        } else {
                            dd($property->errors);
                        }
                    }
                }
            }
        }

    }


    /**
     * ****************************
     */
    public function actionIpCount()
    {
        $ips = ActivePages::find()
            ->select([
                'ip_user',
                'count' => new Expression('COUNT(*)')
            ])
            ->groupBy('ip_user')
            ->orderBy(['count' => SORT_DESC])
            ->asArray()
            ->limit(20)
            ->all();

        foreach ($ips as $ip) {
            Console::output("\t\n ❌ [IP: {$ip['ip_user']}]  Views: {$ip['count']}");
        }
    }


    //======================================================

    /**
     *  спарсить цену на сайте  ****************************
     * @throws \Exception
     */
    public function actionParsePrice()
    {
        // Отключаем лимит времени выполнения
        set_time_limit(0);

        $i = 1;
        $countUpdate = CompetitorPrice::find()->count();
        // Работаем через generator/batch, чтобы не забивать память ActiveQuery
        foreach (CompetitorPrice::find()->each(50) as $competitor) {

            usleep(random_int(1000000, 3000000));

            Console::output("\n {$i} / {$countUpdate} \t✅ Сайт: {$competitor->name}");
            Console::output("\t\t✅ Товар: {$competitor->product->name}");

            $html = $this->fetchUrl($competitor->url);

            if (!$html) {
                Console::output("\t\t❌ Не удалось загрузить страницу: {$competitor->url}");
                $i++;
                continue;
            }

            $price = $this->extractPrice($html);

            if ($price !== null) {
                if ($price !== (float)$competitor->price) {
                    $oldPrice = $competitor->price ?? '❌';
                    Console::output("\t\t✅ New Цена: {$price}  ❌ Old Цена: {$oldPrice}");
                    $competitor->price = $price;
                    $competitor->last_checked_at = time();
                    $competitor->save(false, ['price', 'last_checked_at']);
                } else {
                    $lastChecked = date('d.m.Y', $competitor->last_checked_at);
                    Console::output("\t\t⚠️ Цена не поменялась  >>>  [ {$competitor->price} ]  с даты  >>>  [ {$lastChecked} ]");
                }

            } else {
                Console::output("\t\t⚠️ Цена не найдена");
            } $i++;
        }
    }

    /**
     * Извлечение цены с ранним выходом (Early Return)
     */
    /**
     * Извлечение цены с универсальным порядком приоритетов
     */
    private function extractPrice(string $html): ?float
    {

        // 1. Поиск в JSON-LD (микроразметка)
        if (preg_match_all('/<script[^>]+type=["\']application\/ld\+json["\'][^>]*>(.*?)<\/script>/sui', $html, $matches)) {
            foreach ($matches[1] as $jsonText) {
                $data = json_decode(trim($jsonText), true);
                if (!$data) continue;

                $price = $this->parseJsonLd($data);
                if ($price !== null) return $price;
            }
        }

        // 2. БЫСТРЫЙ ПОИСК: Поиск прямо в HTML по атрибутам data-finalprice, data-price и т.д.
        $dataAttributes = ['data-finalprice', 'data-price', 'data-product-price',
            'current-price'];
        foreach ($dataAttributes as $attr) {
            if (preg_match('/' . $attr . '=["\']([^"\']+)["\']/ui', $html, $m)) {
                $price = $this->cleanPrice($m[1]);

                if ($price > 0) return $price;
            }
        }

        // Подключаем DOMDocument для детального анализа
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new \DOMXPath($dom);


        // 3. ТОЧНЫЙ ПОИСК: Ищем элементы итоговой цены (span_price_full, price-final и т.д.)
        $exactClasses = ['span_price_full', 'final-price', 'full-price'];
        foreach ($exactClasses as $exactClass) {
            $exactNode = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' {$exactClass} ')]")->item(0);
            if ($exactNode) {
                $price = $this->cleanPrice($exactNode->textContent);
                if ($price > 0) return $price;
            }
        }


        // 3. Поиск по популярным ID с ценой (например, id="totalPrice")
        $priorityIds = ['totalPrice', 'product-price', 'price'];
        foreach ($priorityIds as $id) {
            $node = $xpath->query("//*[@id='{$id}']")->item(0);
            if ($node) {
                $price = $this->cleanPrice($node->textContent);
                if ($price > 0) return $price;
            }
        }

        // 4. Поиск в <meta itemprop="price">
        $metaNode = $xpath->query('//meta[@itemprop="price"]/@content')->item(0);
        if ($metaNode && !empty($metaNode->nodeValue)) {
            $price = $this->cleanPrice($metaNode->nodeValue);
            if ($price > 0) return $price;
        }

        // 5. Поиск по классам HTML (с фильтрацией зачеркнутых/старых цен)
        $classes = [
            'price', 'product-price', 'product__price', 'product-price__value',
            'price-current', 'current-price', 'price_value', 'product_price',
            'cost', 'amount', 'product-price__item', 'span_price_full'
        ];

        // Исключаем старые/зачеркнутые цены, чтобы случайно не парсить old-price
        $conditions = array_map(fn($c) => "contains(concat(' ', normalize-space(@class), ' '), ' {$c} ')", $classes);
        $xpathQuery = '//*[' . implode(' or ', $conditions) . '][not(contains(@class, "old")) and not(contains(@class, "del"))]';

        $nodes = $xpath->query($xpathQuery);
        foreach ($nodes as $node) {
            $text = trim($node->textContent);
            if (preg_match('/(?:\d[\d\s&nbsp;.,]*)(?:₴|грн|UAH|\$|USD|€|EUR)/iu', $text, $m)) {
                $price = $this->cleanPrice($m[0]);
                if ($price > 0) return $price;
            }
        }

        libxml_clear_errors();
        return null;
    }

    /**
     * Рекурсивный парсер JSON-LD структуры
     */
    private function parseJsonLd($data): ?float
    {
        if (!is_array($data)) return null;

        // Вложенный @graph
        if (isset($data['@graph']) && is_array($data['@graph'])) {
            foreach ($data['@graph'] as $item) {
                $price = $this->parseJsonLd($item);
                if ($price !== null) return $price;
            }
        }

        // Проверка типа Product
        if (isset($data['@type']) && (
                $data['@type'] === 'Product' ||
                (is_array($data['@type']) && in_array('Product', $data['@type']))
            )) {
            if (isset($data['offers'])) {
                $offers = $data['offers'];

                // Если offers это массив предложений
                if (isset($offers[0])) {
                    $offers = $offers[0];
                }

                if (isset($offers['price'])) {
                    return $this->cleanPrice((string)$offers['price']);
                }
                if (isset($offers['lowPrice'])) {
                    return $this->cleanPrice((string)$offers['lowPrice']);
                }
            }
        }

        return null;
    }

    /**
     * Нормализация и очистка цены до float (3 300,00 -> 3300.00)
     */
    private function cleanPrice(string $priceStr): float
    {
        // Оставляем только цифры, точки и запятые
        $priceStr = preg_replace('/[^\d.,]/u', '', $priceStr);

        if (empty($priceStr)) return 0.0;

        // Если есть и точка, и запятая (например 1,250.00 или 1.250,00)
        if (str_contains($priceStr, '.') && str_contains($priceStr, ',')) {
            if (strrpos($priceStr, '.') > strrpos($priceStr, ',')) {
                // 1,250.00 -> 1250.00
                $priceStr = str_replace(',', '', $priceStr);
            } else {
                // 1.250,00 -> 1250.00
                $priceStr = str_replace('.', '', $priceStr);
                $priceStr = str_replace(',', '.', $priceStr);
            }
        } else {
            // Если только запятая (3300,00 -> 3300.00)
            $priceStr = str_replace(',', '.', $priceStr);
        }

        return (float)$priceStr;
    }

    /**
     * Безопасная загрузка страниц через cURL
     */
    private function fetchUrl(string $url): ?string
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => $this->getRandomUserAgent(),
            CURLOPT_REFERER => $this->getRandomRefer($url),
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($httpCode === 200 && $response) ? $response : null;
    }

    private function getRandomUserAgent(): string
    {
        $default = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36';

        $randomId = ActivePages::find()->select('id')->orderBy('RAND()')->scalar();

        if (!$randomId) {
            return $default;
        }

        $userAgent = ActivePages::find()
            ->select('user_agent')
            ->where(['id' => $randomId])
            ->scalar();

        return $userAgent ?: $default;
    }

    private function getRandomRefer(string $url): string
    {
        $host = parse_url($url, PHP_URL_HOST);
        $scheme = parse_url($url, PHP_URL_SCHEME) ?: 'https';

        $domainUrl = $host ? "{$scheme}://{$host}/" : 'https://www.google.com/';

        $refers = [
            'https://www.google.com/',
            'https://www.google.com/search?q=' . urlencode($host ?? 'shop'),
            'https://www.bing.com/',
            'https://www.bing.com/search?q=' . urlencode($host ?? 'shop'),
            $domainUrl,
        ];

        return $refers[array_rand($refers)];
    }
}