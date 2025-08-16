<?php

namespace frontend\widgets;

use common\models\Contact;
use Yii;
use yii\base\Widget;
use yii\caching\DbDependency;

class SiteFooter extends Widget
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $language = Yii::$app->language;
        // $language = Yii::$app->session->get('_language');
        // $cacheKey = 'contact_cache_key_' . $language;
        // $contacts = Yii::$app->cache->get($cacheKey);



        // if ($contacts === false) {

            $contacts = Contact::find()->where(['language' => $language])->one();
            // $contacts = Contact::find()->where(['language' => 'uk'])->one();

        //     Yii::$app->cache->set($cacheKey, $contacts, 3600, new DbDependency([
        //         'sql' => 'SELECT COUNT(*) FROM contacts',
        //     ]));
        // }

        return $this->render('site-footer',['contacts' => $contacts]);
    }
}
