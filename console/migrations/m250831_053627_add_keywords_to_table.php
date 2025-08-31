<?php

use yii\db\Migration;

class m250831_053627_add_keywords_to_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%auxiliary_categories}}', 'keywords', $this->string());
        $this->addColumn('{{%auxiliary_translate}}', 'keywords', $this->string());

        $this->addColumn('{{%posts}}', 'keywords', $this->string());
        $this->addColumn('{{%posts_translate}}', 'keywords', $this->string());

        $this->addColumn('{{%seo_pages}}', 'keywords', $this->string());
        $this->addColumn('{{%seo_page_translate}}', 'keywords', $this->string());

        $this->addColumn('{{%tag}}', 'keywords', $this->string());
        $this->addColumn('{{%tag_translate}}', 'keywords', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%posts}}', 'keywords');
        $this->dropColumn('{{%posts_translate}}', 'keywords');

        $this->dropColumn('{{%seo_pages}}', 'keywords');
        $this->dropColumn('{{%seo_page_translate}}', 'keywords');

        $this->dropColumn('{{%tag}}', 'keywords');
        $this->dropColumn('{{%tag_translate}}', 'keywords');

        $this->dropColumn('{{%auxiliary_categories}}', 'keywords');
        $this->dropColumn('{{%auxiliary_translate}}', 'keywords');
    }
}
