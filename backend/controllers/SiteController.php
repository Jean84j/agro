<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['dashboard-tab-content'],
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return array|string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        // Обробка AJAX-запиту від нашого робота
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($model->login()) {
                return [
                    'success' => true,
                    'redirect' => Yii::$app->user->getReturnUrl(),
                ];
            }

            $firstError = current($model->getFirstErrors());
            return [
                'success' => false,
                'message' => $firstError ?: 'Невірний логін або пароль.',
            ];
        }

        // Звичайний відображення сторінки (GET-запит)
        $this->layout = 'blank';
        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
     public function actionDashboardTabContent()
    {

        $id = Yii::$app->request->post('id');

        switch ($id) {
            case 'order-tab':
                $content = $this->renderPartial('_order-tab-content');
                break;
            case 'review-tab':
                $content = $this->renderPartial('_review-tab-content');
                break;
            case 'views-tab':
                $content = $this->renderPartial('_views-tab-content');
                break;
            case 'top-review-tab':
                $content = $this->renderPartial('_top-review-tab-content');
                break;
            case 'sub-top-review-tab':
                $content = $this->renderPartial('_sub-top-review-tab-content');
                break;
            case 'top-bay-tab':
                $content = $this->renderPartial('_top-bay-tab-content');
                break;
            default:
                return [
                    'success' => false,
                    'error' => 'Unknown tab ID'
                ];
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'content' => $content
        ];
    }
}
