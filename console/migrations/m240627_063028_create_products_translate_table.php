<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products_translate}}`.
 */
class m240627_063028_create_products_translate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products_translate}}', [
            'id' => $this->primaryKey(),
            'language' => $this->string(10),
            'product_id' => $this->integer(),
            'name' => $this->string(),
            'description' => $this->string(),
            'short_description' => $this->string(),
            'seo_title' => $this->string(255),
            'seo_description' => $this->string(255),
            'footer_description' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products_translate}}');
    }
}
