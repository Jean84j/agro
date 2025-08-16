<?php

use common\models\shop\ActivePages;
use frontend\controllers\SiteController;

/** @var SiteController $host */
/** @var SiteController $urls */
/** @var SiteController $date */
/** @var SiteController $siteMapBase */

ActivePages::setActiveUser();

echo '<?xml version="1.0" encoding="UTF-8"?>';

?>
<?php if (isset($siteMapBase)): ?>
    <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <?php $i = 0; foreach ($urls as $url): ?>
            <sitemap>
                <loc><?= htmlspecialchars($host . '/' . $url, ENT_XML1, 'UTF-8'); ?></loc>
                <lastmod><?= $date[$i]; ?></lastmod>
            </sitemap>
        <?php $i++; endforeach; ?>
    </sitemapindex>
<?php else: ?>
    <urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9"
            xmlns:image="https://www.google.com/schemas/sitemap-image/1.1"
            xmlns:xhtml="https://www.w3.org/1999/xhtml"
            xmlns:xsd="https://www.w3.org/2001/XMLSchema">
        
        <?php foreach ($urls as $url): ?>
            <url>
                <loc><?= htmlspecialchars($host . $url['loc'], ENT_XML1, 'UTF-8'); ?></loc>
                <changefreq><?= htmlspecialchars($url['changefreq'], ENT_XML1, 'UTF-8'); ?></changefreq>
                <lastmod><?= htmlspecialchars($url['lastmod'], ENT_XML1, 'UTF-8'); ?></lastmod>
                <priority><?= htmlspecialchars($url['priority'], ENT_XML1, 'UTF-8'); ?></priority>
                
                <?php if (!empty($url['image'])): ?>
                    <image:image>
                        <image:loc><?= htmlspecialchars($host . $url['image'], ENT_XML1, 'UTF-8'); ?></image:loc>
                        <image:caption><?= htmlspecialchars($url['caption'], ENT_XML1, 'UTF-8'); ?></image:caption>
                    </image:image>
                <?php endif; ?>
            </url>
        <?php endforeach; ?>
    </urlset>
<?php endif; ?>
