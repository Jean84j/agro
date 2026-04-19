<?php

namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\web\TooManyRequestsHttpException;

class RateLimiter extends Component
{
    public $limit = 60; // запитів
    public $window = 60; // секунд

    public function init()
    {
        parent::init();

        $this->check();
    }

    protected function check()
    {
        $ip = Yii::$app->request->userIP;
        $ua = Yii::$app->request->userAgent;

        $isBot = $this->isBot($ua);

        $limit = $isBot ? 10 : $this->limit;
        $window = $this->window;

        $key = $isBot
            ? 'rl_bot:' . $ip
            : 'rl_global:' . $ip;

        $cache = Yii::$app->cache;

        $data = $cache->get($key);

        if (!$data) {
            $cache->set($key, [
                'count' => 1,
                'time' => time(),
            ], $window);

            return;
        }

        $data['count']++;

        if ($data['count'] > $limit) {
            throw new TooManyRequestsHttpException('Too many requests');
        }

        $cache->set($key, $data, $window);
    }

    protected function isBot($userAgent)
    {
        if (!$userAgent) {
            return true;
        }

        $ua = strtolower($userAgent);

        $botPatterns = [
            'bot',
            'crawl',
            'spider',
            'slurp',
            'scan',
            'checker',
            'checker',
            'fetch',
            'scrape',
            'python-requests',
            'curl',
            'wget',
            'httpclient',
            'go-http-client',
            'postman',
            'axios',
            'headless',
            'phantom',
            'selenium',
            'puppeteer',
            'playwright',
        ];

        foreach ($botPatterns as $pattern) {
            if (str_contains($ua, $pattern)) {
                return true;
            }
        }

        return false;
    }

}
