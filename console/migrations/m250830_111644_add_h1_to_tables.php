<?php

use yii\db\Migration;

class m250830_111644_add_h1_to_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%posts}}', 'h1', $this->string());
        $this->addColumn('{{%posts_translate}}', 'h1', $this->string());

        $this->addColumn('{{%seo_pages}}', 'h1', $this->string());
        $this->addColumn('{{%seo_page_translate}}', 'h1', $this->string());

        $this->addColumn('{{%tag}}', 'h1', $this->string());
        $this->addColumn('{{%tag_translate}}', 'h1', $this->string());

        $this->addColumn('{{%brand}}', 'h1', $this->string());
        $this->addColumn('{{%brands_translate}}', 'h1', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%posts}}', 'h1');
        $this->dropColumn('{{%posts_translate}}', 'h1');

        $this->dropColumn('{{%seo_pages}}', 'h1');
        $this->dropColumn('{{%seo_page_translate}}', 'h1');

        $this->dropColumn('{{%tag}}', 'h1');
        $this->dropColumn('{{%tag_translate}}', 'h1');

        $this->dropColumn('{{%brand}}', 'h1');
        $this->dropColumn('{{%brands_translate}}', 'h1');
    }
}
