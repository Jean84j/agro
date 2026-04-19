<?php

namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\web\TooManyRequestsHttpException;

class RateLimiter extends Component
{
    public $limit = 30; // запитів
    public $window = 60; // секунд

    public function init()
    {
        parent::init();

        $this->check();
    }

    protected function check()
    {
        $ip = Yii::$app->request->userIP;
        $key = 'rl_global:' . $ip;

        $cache = Yii::$app->cache;

        $data = $cache->get($key);

        if (!$data) {
            $cache->set($key, [
                'count' => 1,
                'time' => time(),
            ], $this->window);

            return;
        }

        $data['count']++;

        if ($data['count'] > $this->limit) {
            throw new TooManyRequestsHttpException('Too many requests');
        }

        $cache->set($key, $data, $this->window);

    }
}
