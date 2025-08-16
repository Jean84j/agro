<?php

namespace frontend\controllers;

use common\models\Contact;
use common\models\Messages;
use common\models\Settings;
use Spatie\SchemaOrg\Schema;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class ContactController extends Controller
{
    public function actionView(): string
    {
        $language = Yii::$app->language;
        $contacts = Contact::find()->where(['language' => $language])->one();

        $seo = Settings::seoPageTranslate('contact');
        $type = 'website';
        $title = $seo->title;
        $description = $seo->description;
        $image = '';
        $keywords = '';
        Settings::setMetamaster($type, $title, $description, $image, $keywords);

        $this->setSchemaLocalBusiness();

        return $this->render('view',
            [
                'contacts' => $contacts,
                'page_description' => $seo->page_description,
            ]);

    }

    public function actionCreate()
    {
        $seo = Settings::seoPageTranslate('contact');
        if ($this->request->isPost) {
            $contacts = Contact::find()->one();
            $post = Yii::$app->request->post();
            $model = new Messages();
            $model->subject = $post['subject'];
            $model->name = $post['name'];
            $model->email = $post['email'];
            $model->message = $post['mess'];
            if ($model->save()) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $this->renderAjax('view', [
                    'contacts' => $contacts,
                    'page_description' => $seo->page_description,
                ]);
            } else {

                return null;
            }
        }
        return null;
    }

    protected function setSchemaLocalBusiness()
    {
        $opens[] = '9:00';
        $closes[] = '19:00';
        $dayOfWeek = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday'
        ];
        $organization = Schema::localBusiness()
            ->url('https://agropro.org.ua/')
            ->name('Інтернет-магазин | AgroPro')
            ->description('Купуйте |️ Засоби захисту рослин |️ Посівний матеріал |️ Мікродобрива ⚡ За вигідними цінами в Україні в агромаркеті AgroPro.org.ua.')
            ->email('nisatatyana@gmail.com')
            ->telephone('+3(066)394-18-28')
            ->priceRange('UAH')
            ->contactPoint(Schema::contactPoint()
                ->telephone('+3(066)394-18-28')
                ->areaServed('UA')
                ->contactType('customer service')
                ->url(Yii::$app->request->absoluteUrl)
                ->hoursAvailable(Schema::openingHoursSpecification()
                    ->opens($opens)
                    ->closes($closes)
                    ->dayOfWeek($dayOfWeek)
                )
            )
            ->address([
                "@type" => "PostalAddress",
                "streetAddress" => 'Україна Полтава вул.Зіньківська 35',
                "postalCode" => '36000',
                "addressLocality" => 'Полтава',
                "addressRegion" => 'Полтавська область',
                "addressCountry" => 'Україна'
            ])
            ->image(Yii::$app->request->hostInfo . '/images/logos/meta_logo.jpg');
        Yii::$app->params['organization'] = $organization->toScript();
    }

}
