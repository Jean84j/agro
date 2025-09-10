<?php
namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use Yii;
use yii\httpclient\Client;

class IpInfoCustom extends BaseWidgetBackend
{
    /** @var string Токен ipinfo.io */
    public $token;

    /** @var string|null IP-адрес (если null — берём IP пользователя) */
    public $ip;

    /** @var string Шаблон вывода */
    public $view = 'ipinfo';

    public function run()
    {
        $ip = $this->ip ?: Yii::$app->request->userIP;
        $token = Yii::$app->params['ipinfo.io.token'];

        $client = new Client(['baseUrl' => 'https://ipinfo.io']);
        $response = $client->get("{$ip}?token={$token}")->send();

        // ✅ Кэшируем ответ на 1 час
        $data = Yii::$app->cache->getOrSet("ipinfo-{$ip}", function() use ($client, $ip, $token) {
            $response = $client->get("{$ip}?token={$token}")->send();
            return $response->isOk ? $response->data : null;
        }, 3600);

        $data = $response->data;
        return $this->render($this->view, ['data' => $data]);
    }
}

