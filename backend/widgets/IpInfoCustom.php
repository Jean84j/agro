<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use backend\models\IpBot;
use common\models\shop\ActivePages;
use common\models\shop\AuxiliaryCategories;
use Yii;
use yii\httpclient\Client;

class IpInfoCustom extends BaseWidgetBackend
{
    /** @var string Токен ipinfo.io */
    public $token;

    /** @var string|null IP-адрес (если null — берём IP пользователя) */
    public $ip;

    /** @var string Шаблон вывода */
    public $view = 'index-ipinfo';

    public function run()
    {
        $ip = $this->ip ?: Yii::$app->request->userIP;
        $token = Yii::$app->params['ipinfo.io.token'];

        $countIp = $this->countIp($ip);

        $client = new Client(['baseUrl' => 'https://ipinfo.io']);

        $data = Yii::$app->cache->getOrSet("ipinfo-{$ip}", function () use ($client, $ip, $token) {
            $response = $client->get("{$ip}?token={$token}")->send();
            return $response->isOk ? $response->data : null;
        }, 2592000);

        $inBase = $this->inBaseIpBot($ip);

        return $this->render($this->view, [
            'data' => $data,
            'inBase' => $inBase,
            'countIp' => $countIp,
        ]);
    }

    protected function inBaseIpBot($ip)
    {
        $botIps = IpBot::find()->select('ip')->where(['blocking' => 1])->column();

        foreach ($botIps as $botIp) {
            if (str_contains($ip, $botIp)) {
                return [
                    'result' => 'Есть в базе',
                    'class' => 'background-ip-in-base',
                ];
            }
        }
        return [
            'result' => 'Нет в базе',
            'class' => 'background-ip',
        ];
    }

    protected function countIp($userIp)
    {
        return ActivePages::find()->where(['ip_user' => $userIp])->count();
    }
}

