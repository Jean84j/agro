<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%seo_page_translate}}`.
 */
class m241126_195502_create_seo_page_translate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%seo_page_translate}}', [
            'id' => $this->primaryKey(),
            'language' => $this->string(3),
            'page_id' => $this->integer(),
            'title' => $this->string(),
            'description' => $this->string(),
            'page_description' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%seo_page_translate}}');
    }
}
