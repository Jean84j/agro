<?php


namespace console\controllers;

use common\models\Posts;
use common\models\shop\ProductImage;
use Yii;
use yii\console\Controller;
use yii\imagine\Image;

class ResizeImageController extends Controller
{
    /**
     * Обрізка зображення з оригіналу;
     */
    public function actionProduct()
    {
        $photos = ProductImage::find()->all();

        $dir = Yii::getAlias('@frontendWeb/product/');
        $i = 1;
        foreach ($photos as $photo) {
            $original = $dir . $photo['name'];
            $is = ProductImage::find()->where(['extra_extra_large' => 'extra_extra_large-' . $original])->one();
            if (!$is && file_exists($original)) {
                $name = basename($photo['name']);
                Image::resize($original, 350, 350)->save($dir . $photo->product_id . '/extra_extra_large-' . $name, ['quality' => 70]);
                Image::resize($original, 290, 290)->save($dir . $photo->product_id . '/extra_large-' . $name, ['quality' => 70]);
                Image::resize($original, 195, 195)->save($dir . $photo->product_id . '/large-' . $name, ['quality' => 70]);
                Image::resize($original, 150, 150)->save($dir . $photo->product_id . '/medium-' . $name, ['quality' => 70]);
                Image::resize($original, 90, 90)->save($dir . $photo->product_id . '/small-' . $name, ['quality' => 70]);
                Image::resize($original, 64, 64)->save($dir . $photo->product_id . '/extra_small-' . $name, ['quality' => 70]);
                $photo->extra_extra_large = $photo->product_id . '/' . 'extra_extra_large-' . $name;
                $photo->extra_large = $photo->product_id . '/' . 'extra_large-' . $name;
                $photo->large = $photo->product_id . '/' . 'large-' . $name;
                $photo->medium = $photo->product_id . '/' . 'medium-' . $name;
                $photo->small = $photo->product_id . '/' . 'small-' . $name;
                $photo->extra_small = $photo->product_id . '/' . 'extra_small-' . $name;
                if ($photo->save(false)) {
                    echo "\n " . $i . " | Успішно збережено: " . $name . PHP_EOL;
                } else {
                    print_r($photo->errors);
                }
                $i++;
            } else {
                echo "\n " . $i . " | Успішно існує: " . $photo['name'] . PHP_EOL;
            }
        }

        echo "\nOk";
    }
    /**
     * Обрізка зображення з оригіналу Webp;
     */
    public function actionWebpProduct()
    {
        $photos = ProductImage::find()->all();

        $dir = Yii::getAlias('@frontendWeb/product/');
        $i = 1;
        foreach ($photos as $photo) {
            $original = $dir . $photo['name'];
            $is = ProductImage::find()->where(['webp_extra_extra_large' => 'webp_extra_extra_large-' . $original])->one();
            if (!$is && file_exists($original)) {
                $file_name = basename($photo['name']);
                $parts = explode('.', $file_name);
                $name = $parts[0]; // получаем первую часть до точки

                Image::resize($original, 1640, 1080)->save($dir . $photo->product_id . '/webp_' . $name . '.webp', ['quality' => 70]);
                Image::resize($original, 350, 350)->save($dir . $photo->product_id . '/webp_extra_extra_large-' . $name . '.webp', ['quality' => 70]);
                Image::resize($original, 290, 290)->save($dir . $photo->product_id . '/webp_extra_large-' . $name . '.webp', ['quality' => 70]);
                Image::resize($original, 195, 195)->save($dir . $photo->product_id . '/webp_large-' . $name . '.webp', ['quality' => 70]);
                Image::resize($original, 150, 150)->save($dir . $photo->product_id . '/webp_medium-' . $name . '.webp', ['quality' => 70]);
                Image::resize($original, 90, 90)->save($dir . $photo->product_id . '/webp_small-' . $name . '.webp', ['quality' => 70]);
                Image::resize($original, 64, 64)->save($dir . $photo->product_id . '/webp_extra_small-' . $name . '.webp', ['quality' => 70]);

                $photo->webp_name = $photo->product_id . '/' . 'webp_' . $name . '.webp';
                $photo->webp_extra_extra_large = $photo->product_id . '/' . 'webp_extra_extra_large-' . $name . '.webp';
                $photo->webp_extra_large = $photo->product_id . '/' . 'webp_extra_large-' . $name . '.webp';
                $photo->webp_large = $photo->product_id . '/' . 'webp_large-' . $name . '.webp';
                $photo->webp_medium = $photo->product_id . '/' . 'webp_medium-' . $name . '.webp';
                $photo->webp_small = $photo->product_id . '/' . 'webp_small-' . $name . '.webp';
                $photo->webp_extra_small = $photo->product_id . '/' . 'webp_extra_small-' . $name . '.webp';
                if ($photo->save(false)) {
                    echo "\n " . $i . " | Успішно збережено: " . $name . '.webp' . PHP_EOL;
                } else {
                    print_r($photo->errors);
                }
                $i++;
            } else {
                echo "\n " . $i . " | Успішно існує: " . $photo['name'] . PHP_EOL;
            }
        }

        echo "\nOk";
    }

    /**
     * Обрізка зображення з оригіналу;
     */
    public function actionPost()
    {
        $photos = Posts::find()->all();

        $dir = Yii::getAlias('@frontendWeb/posts/');
        $i = 1;
        foreach ($photos as $photo) {
            $original = $dir . $photo['image'];
            $is = Posts::find()->where(['extra_large' => 'extra_large-' . $original])->one();
            if (!$is && file_exists($original)) {
                $name = $photo['image'];
                Image::resize($original, 330, 222)->save($dir . 'thumb/extra_large-' . $name, ['quality' => 70]);
                Image::resize($original, 263, 177)->save($dir . 'thumb/large-' . $name, ['quality' => 70]);
                Image::resize($original, 159, 107)->save($dir . 'thumb/medium-' . $name, ['quality' => 70]);
                Image::resize($original, 90, 60)->save($dir . 'thumb/small-' . $name, ['quality' => 70]);
                $photo->extra_large = 'extra_large-' . $name;
                $photo->large = 'large-' . $name;
                $photo->medium = 'medium-' . $name;
                $photo->small = 'small-' . $name;
                if ($photo->save(false)) {
                    echo "\n " . $i . " | Успішно збережено: " . $name . PHP_EOL;
                } else {
                    print_r($photo->errors);
                }
                $i++;
            } else {
                echo "\n " . $i . " | Успішно існує: " . $photo['image'] . PHP_EOL;
            }
        }

        echo "\nOk";
    }

    /**
     * Обрізка зображення з оригіналу Webp;
     */
    public function actionWebpPost()
    {
        $photos = Posts::find()->all();

        $dir = Yii::getAlias('@frontendWeb/posts/');
        $i = 1;
        foreach ($photos as $photo) {
            $original = $dir . $photo['image'];

            $is = Posts::find()->where(['webp_extra_large' => 'webp_extra_large-' . $original])->one();
            if (!$is && file_exists($original)) {
                $file_name = $photo['image'];
                $parts = explode('/', $file_name);
                $catalog = $parts[0];
                $res = explode('.', $parts[1]);
                $name = $res[0];

                Image::resize($original, 1640, 1080)->save($dir . $catalog . '/' . $name . '.webp', ['quality' => 70]);
                Image::resize($original, 330, 222)->save($dir . $catalog . '/webp_extra_large-' . $name . '.webp', ['quality' => 70]);
                Image::resize($original, 263, 177)->save($dir . $catalog . '/webp_large-' . $name . '.webp', ['quality' => 70]);
                Image::resize($original, 159, 107)->save($dir . $catalog . '/webp_medium-' . $name . '.webp', ['quality' => 70]);
                Image::resize($original, 90, 60)->save($dir . $catalog . '/webp_small-' . $name . '.webp', ['quality' => 70]);

                $photo->webp_image = $catalog . '/' . $name . '.webp';
                $photo->webp_extra_large = $catalog . '/webp_extra_large-' . $name . '.webp';
                $photo->webp_large = $catalog . '/webp_large-' . $name . '.webp';
                $photo->webp_medium = $catalog . '/webp_medium-' . $name . '.webp';
                $photo->webp_small = $catalog . '/webp_small-' . $name . '.webp';

                if ($photo->save(false)) {
                    echo "\n " . $i . " | Успішно збережено: " . $name . '.webp' . PHP_EOL;
                } else {
                    print_r($photo->errors);
                }
                $i++;
            } else {
                echo "\n " . $i . " | Успішно існує: " . $photo['image'] . PHP_EOL;
            }
        }

        echo "\nOk";
    }

    public function actionPostCatalog()
    {
        $posts = Posts::find()->all();
        $dir = Yii::getAlias('@frontendWeb/posts/');

        foreach ($posts as $post) {
            $destinationDirectory = $dir . $post->date_public;

            if (!file_exists($destinationDirectory)) {
                mkdir($destinationDirectory, 0777);

                rename($dir . $post->image, $destinationDirectory . '/' . $post->image);
                rename($dir . $post->extra_large, $destinationDirectory . '/' . $post->extra_large);
                rename($dir . $post->large, $destinationDirectory . '/' . $post->large);
                rename($dir . $post->medium, $destinationDirectory . '/' . $post->medium);
                rename($dir . $post->small, $destinationDirectory . '/' . $post->small);

                $post->image = $post->date_public . '/' . $post->image;
                $post->extra_large = $post->date_public . '/' . $post->extra_large;
                $post->large = $post->date_public . '/' . $post->large;
                $post->medium = $post->date_public . '/' . $post->medium;
                $post->small = $post->date_public . '/' . $post->small;
                if ($post->save(false)) {

                } else {
                    print_r($post->errors);
                }
                echo 'Файлы успешно перемещены!';
            } else {
                echo 'Не удалось переместить файлы.';
            }
        }
    }
}