<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%brands_translate}}`.
 */
class m250106_135209_create_brands_translate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%brands_translate}}', [
            'id' => $this->primaryKey(),
            'brand_id' => $this->integer(),
            'language' => $this->string(3),
            'name' => $this->string(),
            'description' => $this->text(),
            'seo_title' => $this->string(),
            'seo_description' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%brands_translate}}');
    }
}
