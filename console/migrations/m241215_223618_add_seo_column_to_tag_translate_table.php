<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%tag_translate}}`.
 */
class m241215_223618_add_seo_column_to_tag_translate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tag_translate}}', 'seo_title', $this->string());
        $this->addColumn('{{%tag_translate}}', 'seo_description', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tag_translate}}', 'seo_title');
        $this->dropColumn('{{%tag_translate}}', 'seo_description');
    }
}
