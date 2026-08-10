<?php

namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\web\Request;
use yii\web\View;

/**
 * @property string $siteName
 * @property string $type
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $url
 * @property string $defaultImage
 * @property string $image
 * @property string $imagePath
 * @property string $web
 * @property View $view
 */
class SeoMetaMaster extends Component
{
    /**
     * @var string
     */
    public $siteName = 'My Test Application';
    /**
     * @var string
     */
    public $web = "@app/web";
    /**
     * @var string
     */
    public $defaultImage;
    /**
     * @var string
     */
    public $protocol = 'https';
    /**
     * @var string
     */
    private $type = 'article';
    /**
     * @var Request
     */
    private $request;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $image;
    /**
     * @var string
     */
    private $imagePath;
    /**
     * @var string
     */
    private $view;
    /**
     * @var string
     */
    private $keywords;
    /**
     * @var float
     */
    private $price;
    /**
     * @var boolean
     */
    private $indexable;
    /**
     * @var array
     */
    private $alternateUrls;

    /**
     * @inheritDoc
     */
    public function init()
    {
        if (!$this->request)
            $this->request = Yii::$app->request;
        parent::init();
    }

    /** Site name setter
     * @param $siteName
     * @return $this
     */
    public function setSiteName(string $siteName)
    {
        $this->siteName = $siteName;
        return $this;
    }

    /** Page title setter
     * @param $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /** Url setter
     * @param $title
     * @return $this
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    /** Alternate Url setter
     * @param array $alternateUrls
     * @return $this
     */
    public function setAlternateUrls(array $alternateUrls)
    {
        $this->alternateUrls = $alternateUrls;
        return $this;
    }

    /** Set request object
     * @param $title
     * @return $this
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    /** OgType setter
     * @param $type
     * @return $this
     */
    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    /** Meta description setter
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    /** Meta keyword setter is deprecated from 1.1.0
     * @param string $keywords
     * @return $this
     * @deprecated
     */
    public function setKeywords(?string $keywords)
    {
        $this->keywords = $keywords ?? '';
        return $this;
    }

    /** Set Open Graph image tag
     * @param string $image
     * @param string|null $imagePath
     * @return $this
     */
    public function setImage(string $image, string $imagePath = null)
    {
        $this->image = $image;
        $this->imagePath = $imagePath;
        return $this;
    }

    /** Set Product price
     * @param float $price
     * @return $this
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
        return $this;
    }

    /** Set Indexable
     * @param boolean $indexable
     * @return $this
     */
    public function setIndexable(bool $indexable)
    {
        $this->indexable = $indexable;
        return $this;
    }

    /** Register meta tags in View
     * @param View $view
     */
    public function register(View $view)
    {
        $this->view = $view;
        $this->registerCoreInfo();
        $this->registerTitle();
        $this->registerDescription();
        $this->registerImage();
    }

    /**
     * Register core meta and og tags
     */
    private function registerCoreInfo()
    {
        if ($this->indexable === false) {
            $this->registerOrUpdateMetaTag(['name' => 'robots', 'content' => 'noindex,nofollow']);
        } else {
            $this->registerOrUpdateMetaTag(['name' => 'robots', 'content' => 'index,follow']);
        }

        $this->registerOrUpdateMetaTag(['property' => 'og:site_name', 'content' => $this->siteName]);
        $this->registerOrUpdateMetaTag(['property' => 'og:type', 'content' => $this->type]);
        $this->registerOrUpdateMetaTag(['property' => 'og:url', 'content' => $this->url ?: $this->getAbsoluteUrl()]);
        $this->registerOrUpdateMetaTag(['name' => 'twitter:card', 'content' => 'summary_large_image']);
        $this->registerOrUpdateMetaTag(['name' => 'twitter:domain', 'content' => parse_url($this->request->getHostInfo(), PHP_URL_HOST)]);
        $this->registerOrUpdateLinkTag(['rel' => 'canonical', 'href' => $this->canonicalUrl($this->url) ?: $this->getAbsoluteUrl()]);

        if ($this->alternateUrls) {
            $this->registerOrUpdateLinkTag(['rel' => 'alternate', 'hreflang' => 'uk-UA', 'href' => $this->alternateUrls['ukUrl']]);
            $this->registerOrUpdateLinkTag(['rel' => 'alternate', 'hreflang' => 'ru-UA', 'href' => $this->alternateUrls['ruUrl']]);
            $this->registerOrUpdateLinkTag(['rel' => 'alternate', 'hreflang' => 'x-default', 'href' => $this->alternateUrls['ukUrl']]);
        }

        if ($this->price) {
            $this->registerOrUpdateMetaTag(['property' => 'product:price:amount', 'content' => $this->price]);
            $this->registerOrUpdateMetaTag(['property' => 'product:price:currency', 'content' => 'UAH']);
        }

        if ($this->keywords) {
            $this->registerOrUpdateMetaTag(['name' => 'keywords', 'content' => $this->keywords]);
        }

        if (Yii::$app->language == 'uk') {
            $this->registerOrUpdateMetaTag(['property' => 'og:locale', 'content' => 'uk_UA']);
        } else {
            $this->registerOrUpdateMetaTag(['property' => 'og:locale', 'content' => 'ru_RU']);
        }

    }

    private function canonicalUrl(string $url): string
    {
        return str_replace('://mail.', '://', $url);
    }

    private function registerOrUpdateMetaTag($tag)
    {
        $existingTags = $this->view->metaTags;
        $tagKey = $this->generateTagKey($tag);

        if (array_key_exists($tagKey, $existingTags)) {
            unset($this->view->metaTags[$tagKey]);
        }

        $this->view->registerMetaTag($tag, $tagKey);
    }

    private function registerOrUpdateLinkTag($tag)
    {
        $existingTags = $this->view->linkTags;
        $tagKey = $this->generateTagKey($tag);

        if (array_key_exists($tagKey, $existingTags)) {
            unset($this->view->linkTags[$tagKey]);
        }

        $this->view->registerLinkTag($tag, $tagKey);
    }

    private function generateTagKey($tag)
    {
        return md5(json_encode($tag));
    }

    /**
     * @param null $absoluteUrl
     * @return mixed
     */
    public function getAbsoluteUrl($absoluteUrl = null)
    {
        if ($absoluteUrl === null) {
            $absoluteUrl = $this->request->absoluteUrl;
        }

        if (substr($absoluteUrl, 0, 4) !== 'http') {
            $absoluteUrl = $this->request->getHostInfo() . $absoluteUrl;
        }

        return preg_replace('/https|http/', $this->protocol, $absoluteUrl, -1, $count);
    }

    /**
     * Register title
     */
    private function registerTitle()
    {
        if ($this->title) {
            $this->view->title = $this->title;
            $this->registerOrUpdateMetaTag(['property' => 'og:title', 'content' => $this->title]);
            $this->registerOrUpdateMetaTag(['name' => 'twitter:title', 'content' => $this->title]);
            $this->registerOrUpdateMetaTag(['itemprop' => 'name', 'content' => $this->title]);
        }
    }

    /**
     * Register description
     */
    private function registerDescription()
    {
        if ($this->description) {
            $this->registerOrUpdateMetaTag(['name' => 'description', 'content' => $this->description]);
            $this->registerOrUpdateMetaTag(['property' => 'og:description', 'content' => $this->description]);
            $this->registerOrUpdateMetaTag(['name' => 'twitter:description', 'content' => $this->description]);
        }
    }

    /**
     * Register image
     */
    private function registerImage()
    {
        $image = $this->image ?: $this->defaultImage;

        if ($image) {
            $imageUrl = $this->getAbsoluteUrl($image);
            $this->registerOrUpdateMetaTag(['property' => 'og:image', 'content' => $imageUrl]);
            $this->registerOrUpdateMetaTag(['name' => 'twitter:image', 'content' => $imageUrl]);
            $this->registerOrUpdateMetaTag(['itemprop' => 'image', 'content' => $imageUrl]);
            $this->registerOrUpdateMetaTag(['property' => 'og:image:alt', 'content' => $this->title]);
            $this->registerOrUpdateMetaTag(['name' => 'twitter:image:alt', 'content' => $this->title]);
            $this->registerOrUpdateMetaTag(['property' => 'og:image:secure_url', 'content' => $imageUrl]);
        }

        $image = parse_url($image, PHP_URL_PATH);

        $path = Yii::getAlias($this->imagePath ?: $this->web . $image);
        if ($this->imagePath) {
            $path = $this->imagePath;
        }
        if (file_exists($path)) {
            $imageSize = getimagesize($path);
            $this->registerOrUpdateMetaTag(['property' => 'og:image:width', 'content' => $imageSize[0]]);
            $this->registerOrUpdateMetaTag(['property' => 'og:image:height', 'content' => $imageSize[1]]);
        }

        if (is_file($path)) {
            $mime = mime_content_type($path);

            $this->registerOrUpdateMetaTag([
                'property' => 'og:image:type',
                'content' => $mime,
            ]);
        }
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}
