<?php

namespace frontend\widgets;

use common\models\shop\ProductTag;
use common\models\shop\Tag;
use Yii;
use yii\base\Widget;

class TagCloud extends Widget
{
    public $productsId;

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $language = Yii::$app->language;
        $prod_id = $this->productsId;
        $query = Tag::find()
            ->alias('t')
            ->select([
                't.id',
                't.slug',
                't.name AS original_name',
                'IFNULL(tt.name, t.name) AS name',
            ])
            ->leftJoin('tag_translate tt', 'tt.tag_id = t.id AND tt.language = :language')
            ->addParams([':language' => $language]);

        if ($prod_id) {
            $query->innerJoin(ProductTag::tableName() . ' pt', 'pt.tag_id = t.id')
                ->where(['pt.product_id' => $prod_id]);
        } else {
            $query->limit(55);
        }

        $tags = $query->all();

        return $this->render('tag-cloud', [
            'tags' => $tags,
        ]);
    }
}
