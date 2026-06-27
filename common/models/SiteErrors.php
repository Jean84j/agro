<?php

namespace common\models;

use backend\models\ProductsBackend;
use common\models\shop\AuxiliaryCategories;
use common\models\shop\Category;
use common\models\shop\Product;
use common\models\shop\ProductImage;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "site_errors".
 *
 * @property int $id
 * @property string|null $ip_user
 * @property string|null $url_page
 * @property string|null $user_agent
 * @property string|null $client_from
 * @property string|null $date_visit
 * @property string|null $status_serv
 * @property string|null $other
 */
class SiteErrors extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site_errors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip_user', 'url_page', 'user_agent', 'client_from', 'date_visit', 'status_serv', 'other'], 'default', 'value' => null],
            [['client_from'], 'string'],
            [['ip_user'], 'string', 'max' => 15],
            [['url_page', 'user_agent'], 'string', 'max' => 255],
            [['date_visit', 'other'], 'string', 'max' => 10],
            [['status_serv'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip_user' => 'Ip User',
            'url_page' => 'Url Page',
            'user_agent' => 'User Agent',
            'client_from' => 'Client From',
            'date_visit' => 'Date Visit',
            'status_serv' => 'Status Serv',
            'other' => 'Other',
        ];
    }

    public function getClearUrl($url): string
    {
        $url = urldecode($url);
        if (str_contains($url, 'srsltid')) {

            $parts = explode('srsltid', $url, 2);

            $url = substr($parts[0], 0, -1);

            return $url;

        }

        if (str_contains($url, 'fbclid')) {

            $parts = explode('fbclid', $url, 2);

            $url = substr($parts[0], 0, -1);

            return $url;

        }

        return $url;
    }

    public static function productCountViews($url)
    {
        return SiteErrors::find()
            ->where(['like', 'url_page', $url])
            ->count();
    }

    public function getImage(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        $path = $path ?? '';
        $segments = explode('/', trim($path, '/'));

        if (!empty($segments) && $segments[0] === 'ru') {
            array_shift($segments);
        }

        $slug = end($segments);
        $dir = implode('/', array_slice($segments, 0, -1));

        $noImage = '/images/no-image.png';

        $map = [
            'product' => [
                'model' => Product::class,
                'image' => function ($model) {
                    $productImage = ProductImage::find()
                        ->where(['product_id' => $model->id])
                        ->orderBy('priority')
                        ->one();
                    return $productImage->extra_small ?? null
                            ? '/product/' . $productImage->extra_small
                            : null;
                },
            ],
            'post' => [
                'model' => Posts::class,
                'imageField' => 'small',
                'prefix' => '/posts/',
            ],
            'auxiliary-product-list' => [
                'model' => AuxiliaryCategories::class,
                'imageField' => 'image',
                'prefix' => '/images/auxiliary-categories/',
            ],
            'product-list' => [
                'model' => Category::class,
                'imageField' => 'file',
                'prefix' => '/images/category/',
            ],
        ];

        if (!isset($map[$dir])) {
            return $noImage;
        }

        $config = $map[$dir];
        $model = ($config['model'])::findOne(['slug' => $slug]);

        if (!$model) {
            return $noImage;
        }

        // Если задана функция получения изображения
        if (isset($config['image']) && is_callable($config['image'])) {
            return $config['image']($model) ?? $noImage;
        }

        // Если задано поле и префикс
        if (!empty($config['imageField']) && !empty($model->{$config['imageField']})) {
            return $config['prefix'] . $model->{$config['imageField']};
        }

        return $noImage;
    }

    public function getStatus(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        $path = $path ?? '';
        $segments = explode('/', trim($path, '/'));

        if (!empty($segments) && $segments[0] === 'ru') {
            array_shift($segments);
        }

        $slug = end($segments);
        $dir = implode('/', array_slice($segments, 0, -1));

        $status = '';

        if ($dir === 'product' && !empty($slug)) {
            $statusId = ProductsBackend::find()
                ->select('status_id')
                ->where(['slug' => $slug])
                ->scalar();

            switch ($statusId) {
                case 1:
                    // В наявності  зеленый
                    $status = '<i class="fas fa-chevron-circle-down mr-1" style="color: rgba(19,165,10,0.82)"></i>';
                    break;

                case 2:
                    // Відсутній  красный
                    $status = '<i class="fas fa-times-circle mr-1" style="color: rgba(195,18,18,0.82)"></i>';
                    break;

                case 3:
                    // Очікується желтый
                    $status = '<i class="fas fa-stopwatch mr-1" style="color: rgba(204,175,12,0.82)"></i>';
                    break;

                case 4:
                    // Під заказ  голубой
                    $status = '<i class="fas fa-envelope-square mr-1" style="color: rgba(16,133,176,0.82)"></i>';
                    break;

                default:
                    $status = '<i class="fas fa-exclamation-triangle mr-1"></i>';
                    break;

            }
        }

        return $status;

    }

    public
    static function countIpUsers(): int
    {
        $res = [];
        $pages = SiteErrors::find()
            ->asArray()
            ->all();
        foreach ($pages as $page) {
            $res[] = $page['ip_user'];
        }
        $res = array_unique($res);

        return count($res);
    }

}
