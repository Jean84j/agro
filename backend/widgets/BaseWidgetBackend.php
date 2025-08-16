<?php

namespace app\widgets;

use common\models\shop\ActivePages;
use common\models\shop\Order;
use common\models\shop\OrderItem;
use common\models\shop\Product;
use yii\base\Widget;
use DateInterval;
use DateTime;

class BaseWidgetBackend extends Widget
{
    protected array $ukrainianMonths = [
        'Jan' => 'Січ', 'Feb' => 'Лют', 'Mar' => 'Бер',
        'Apr' => 'Кві', 'May' => 'Тра', 'Jun' => 'Чер',
        'Jul' => 'Лип', 'Aug' => 'Сер', 'Sep' => 'Вер',
        'Oct' => 'Жов', 'Nov' => 'Лис', 'Dec' => 'Гру'
    ];

    protected array $months = [
        1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель',
        5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
        9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь',
    ];

    public function getUkrainianMonths(): array
    {
        return $this->ukrainianMonths;
    }

    public function getMonths(): array
    {
        return $this->months;
    }

    protected function sortByMonths(array $resultArray): array
    {
        // Получаем месяцы в календарном порядке (січень → грудень)
        $monthsOrder = array_values($this->ukrainianMonths);

        usort($resultArray, function ($a, $b) use ($monthsOrder) {
            $indexA = array_search($a['label'], $monthsOrder);
            $indexB = array_search($b['label'], $monthsOrder);
            return $indexA <=> $indexB;
        });

        return $resultArray;
    }


    public function processCarts(array $carts): array
    {
        $resultArray = [];

        foreach ($carts as $item) {
            $label = $item['label'];
            $value = $item['value'];

            if (isset($resultArray[$label])) {
                $resultArray[$label]['value'] += $value;
            } else {
                $resultArray[$label] = [
                    'label' => $label,
                    'value' => $value,
                ];
            }
        }

        return array_values($resultArray);
    }

    /**
     * Метод для получения месяца и года за месяц до текущей даты
     * @return string Форматированный месяц и год
     */
    protected function getPreviousMonthFormatted(): string
    {
        $currentDate = new DateTime();
        $interval = new DateInterval('P1M');
        $oneMonthAgo = $currentDate->sub($interval);
        $months = $this->months;
        $monthNumber = $oneMonthAgo->format('n');
        $year = $oneMonthAgo->format('Y');
        $monthName = $months[$monthNumber];

        return $monthName . ' ' . $year;
    }

    /**
     *
     *
     */
    protected function getOrdersProducts($package): array
    {
        $ordersId = Order::find()
            ->select('id')
            ->where(['order_pay_ment_id' => 3])
            ->column();

        $productsId = Product::find()
            ->select('id')
            ->where(['package' => $package])
            ->column();

        $ordersProducts = OrderItem::find()
            ->select(['product_id', 'quantity'])
            ->where(['order_id' => $ordersId])
            ->asArray()
            ->all();

        $ordersProducts = array_filter($ordersProducts, function ($product) use ($productsId) {
            return in_array($product['product_id'], $productsId);
        });

        $productTotals = [];
        foreach ($ordersProducts as $product) {
            $productTotals[$product['product_id']] = ($productTotals[$product['product_id']] ?? 0) + $product['quantity'];
        }

        arsort($productTotals);
        $results = array_slice($productTotals, 0, 10, true);

        $productIds = array_keys($results);
        $productsData = Product::find()
            ->alias('p')
            ->select(['p.id', 'p.name', 'p.slug', 'pi.extra_small'])
            ->leftJoin('product_image pi', 'pi.product_id = p.id')
            ->where(['p.id' => $productIds])
            ->orderBy(['pi.priority' => SORT_ASC])
            ->asArray()
            ->all();

        $resultProduct = [];
        foreach ($results as $productId => $count) {
            $productData = current(array_filter($productsData, fn($item) => $item['id'] == $productId));
            if ($productData) {
                $resultProduct[$productId] = [
                    'name'  => $productData['name'],
                    'image' => $productData['extra_small'],
                    'slug'  => $productData['slug'],
                    'count' => $count
                ];
            }
        }
        return $resultProduct;
    }

    /**
     *
     *
     */
    protected function getPostUniqueUrls(): array
    {
        $pages = ActivePages::find()
            ->select(['url_page', 'date_visit'])
            ->where(['like', 'url_page', '/post/'])
            ->asArray()
            ->all();
        $uniqueUrls = [];
        foreach ($pages as $page) {
            $url = $page['url_page'];
            $date = $page['date_visit'];
            if (str_contains($url, '/post/') !== false) {
                $parsedUrl = parse_url($url);
                $url = $parsedUrl['path'];
                $url = str_replace(['/en/', '/ru/'], '/', $url);
                $url = str_replace('/post/', '', $url);

                if (isset($uniqueUrls[$url])) {
                    $uniqueUrls[$url]['count'] += 1;
                    if ($date > $uniqueUrls[$url]['date']) {
                        $uniqueUrls[$url]['date'] = $date;
                    }
                } else {
                    $uniqueUrls[$url] = [
                        'slug' => str_replace('/post/', '', $url),
                        'date' => $date,
                        'count' => 1,
                    ];
                }
            }
        }

        return $uniqueUrls;
    }

    /**
     *
     *
     */
    protected function getProductUniqueUrls(): array
    {
        $pages = ActivePages::find()
            ->select(['url_page', 'date_visit'])
            ->where(['like', 'url_page', '/product/'])
            ->asArray()
            ->all();
        $uniqueUrls = [];
        foreach ($pages as $page) {
            $url = $page['url_page'];
            $date = $page['date_visit'];
            if (str_contains($url, '/product/') !== false) {
                $parsedUrl = parse_url($url);
                $url = $parsedUrl['path'];
                $url = str_replace(['/en/', '/ru/'], '/', $url);
                $url = str_replace('/product/', '', $url);

                if (isset($uniqueUrls[$url])) {
                    $uniqueUrls[$url]['count'] += 1;
                    if ($date > $uniqueUrls[$url]['date']) {
                        $uniqueUrls[$url]['date'] = $date;
                    }
                } else {
                    $uniqueUrls[$url] = [
                        'slug' => str_replace('/product/', '', $url),
                        'date' => $date,
                        'count' => 1,
                    ];
                }
            }
        }
        return $uniqueUrls;
    }

}
