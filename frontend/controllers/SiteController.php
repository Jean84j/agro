<?php

namespace frontend\controllers;

use common\models\Messages;
use common\models\Settings;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use frontend\widgets\Bestsellers;
use frontend\widgets\BestsellersDacha;
use frontend\widgets\PopularCategories;
use Spatie\SchemaOrg\Schema;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use yii\web\Cookie;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends BaseFrontendController
{

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;

        if ($exception === null) {
            throw new NotFoundHttpException();
        }

        $statusCode = $exception instanceof HttpException
            ? $exception->statusCode
            : 500;

        Yii::$app->metamaster
            ->setIndexable(false)
            ->setType('website')
//            ->setTitle()
//            ->setDescription(strip_tags())
            ->setUrl(Url::canonical())
//            ->setAlternateUrls($this->getAlternateUrl())
//            ->setImage('')
//            ->setKeywords('')
//            ->setPrice('')
            ->register(Yii::$app->view);

        return $this->render('error/error', [
            'statusCode' => $statusCode,
            'exception' => $exception
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $seo = Settings::seoPageTranslate('home');

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
                ->url(Url::canonical())
                ->hoursAvailable(Schema::openingHoursSpecification()
                    ->opens('9:00')
                    ->closes('19:00')
                    ->dayOfWeek([
                        'Monday',
                        'Tuesday',
                        'Wednesday',
                        'Thursday',
                        'Friday'
                    ])
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

        $homepage = Schema::WebPage()
            ->name($seo->title)
            ->description($seo->description)
            ->url(Url::canonical());
        Yii::$app->params['webPage'] = $homepage->toScript();

        Yii::$app->metamaster
            ->setIndexable(true)
            ->setType('website')
            ->setTitle($seo->title)
            ->setDescription(strip_tags($seo->description))
            ->setUrl(Url::canonical())
            ->setAlternateUrls($this->getAlternateUrl())
//            ->setImage('')
//            ->setKeywords('')
//            ->setPrice('')
            ->register(Yii::$app->view);

        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            Yii::$app->session->setFlash('login', 'Ви зайшли до облікового запису.');

            return $this->goBack();
        }

        $model->password = '';

        return $this->render('authorization/login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('logout', 'Ви вийшли з облікового запису.');
        return $this->goHome();
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup(): mixed
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('signup', 'Дякуемо за реєстрацію. Будь ласка, 
            перевірте свою поштову скриньку на наявність листа з підтвердженням.');
            return $this->goHome();
        }

        return $this->render('authorization/signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('passwordReset', 'Перевірте свою електронну пошту для подальших інструкцій.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('info', 'На жаль, ми не можемо скинути пароль для вказаної адреси електронної пошти.');
        }

        return $this->render('authorization/requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новий пароль збережено.');

            return $this->goHome();
        }

        return $this->render('authorization/resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @return yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('verifyEmail', 'Вашу адресу електронної пошти підтверджено!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('success', 'На жаль, ми не можемо підтвердити ваш обліковий запис за допомогою наданого токена.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('verificationEmail', 'Перевірте свою електронну пошту для подальших інструкцій.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('info', 'На жаль, ми не можемо повторно надіслати листа з підтвердженням на вказану адресу електронної пошти.');
        }

        return $this->render('authorization/resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionLoadContent()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $name = Yii::$app->request->post('widgetName');

        $widgetsMap = [
            'bestsellers'        => Bestsellers::class,
            'bestsellers-dacha'  => BestsellersDacha::class,
            'popular-categories' => PopularCategories::class,

        ];

        if (!isset($widgetsMap[$name])) {
            return [
                'success' => false,
                'message' => 'Неизвестный виджет',
            ];
        }

        $widgetClass = $widgetsMap[$name];

        return [
            'success' => true,
            'content' => $widgetClass::widget(),
        ];
    }

    public function actionMailingList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isPost) {
            $email = Yii::$app->request->post('email');

            $model = new Messages();
            $model->name = 'AgroPro';
            $model->email = $email;
            $model->message = 'Додати в розсилку';
            if ($model->save()) {
                return ['success' => true, 'message' => 'Подписка оформлена!'];
            } else {
                return ['success' => false, 'message' => 'Ошибка при сохранении данных.'];
            }

        } else {
            throw new BadRequestHttpException('Неверный запрос.');
        }
    }

    public function actionAcceptCookies()
    {
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'cookies_accepted',
            'value' => '1',
            'expire' => time() + 3600 * 24 * 365, // 1 год
        ]));
        return $this->asJson(['success' => true]);
    }

    public function actionLanguageCookies()
    {
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'cookies_language',
            'value' => '1',
            'expire' => time() + 3600 * 24 * 365, // 1 год
        ]));
        return $this->asJson(['success' => true]);
    }

}
