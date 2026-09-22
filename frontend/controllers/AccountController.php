<?php

namespace frontend\controllers;

use common\models\Orders\Order;
use Yii;
use yii\filters\AccessControl;

class AccountController extends BaseFrontendController
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
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionView($card = 'dashboard')
    {
        $user_id = Yii::$app->user->id;
        $orders = Order::find()->where(['user_id' => $user_id])->all();
        $lastOrder = Order::find()->where(['user_id' => $user_id])->one();


        return $this->render('view', [
            'card' => $card,
            'orders' => $orders,
            'lastOrder' => $lastOrder,
        ]);
    }
}