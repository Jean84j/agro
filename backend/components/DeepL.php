<?php
namespace backend\components;

use GuzzleHttp\Client;
use yii\base\Component;

class DeepL extends Component
{
    public $apiKey; // подхватывается из config/web.php
    private $client;

    public function init()
    {
        parent::init();
        $this->client = new Client([
            'base_uri' => 'https://api-free.deepl.com/v2/', // api.deepl.com если PRO
            'timeout'  => 15.0,
        ]);
    }

    /**
     * Универсальный перевод текста через DeepL
     */
    public function translate($text, $targetLang = 'RU', $sourceLang = 'UK', $options = [])
    {
        if (empty($text)) {
            return '';
        }

        // Настройки по умолчанию
        $defaultOptions = [
            'formality'           => 'default',       // prefer_more / prefer_less
            'split_sentences'     => 'nonewlines',    // nonewlines / 0 / 1
            'preserve_formatting' => 1,               // сохранять форматирование
            'tag_handling'        => 'html',          // переводить только текст, не ломать теги
            'non_splitting_tags'  => 'span,strong',   // не делить внутри тегов
            'ignore_tags'         => 'code,pre',      // игнорировать теги
        ];

        $params = array_merge($defaultOptions, $options);

        // Ограничение DeepL – 5000 символов → режем на части
        $partSize = 4800;
        $parts = [];
        $description = $text;

        while (mb_strlen($description) > $partSize) {
            $part = mb_substr($description, 0, $partSize);
            $lastSpace = mb_strrpos($part, ' ');
            $parts[] = mb_substr($description, 0, $lastSpace);
            $description = mb_substr($description, $lastSpace);
        }
        $parts[] = $description;

        $translated = '';

        foreach ($parts as $part) {
            try {
                $response = $this->client->post('translate', [
                    'form_params' => array_merge($params, [
                        'auth_key'    => $this->apiKey,
                        'text'        => $part,
                        'source_lang' => strtoupper($sourceLang),
                        'target_lang' => strtoupper($targetLang),
                    ]),
                ]);

                $data = json_decode($response->getBody(), true);
                $translated .= $data['translations'][0]['text'] ?? $part;

            } catch (\Exception $e) {
                \Yii::error("DeepL API error: " . $e->getMessage(), __METHOD__);
                $translated .= $part; // на случай ошибки — вернем оригинал
            }
        }

        return $translated;
    }
}
