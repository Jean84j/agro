<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories_translate}}`.
 */
class m240627_115058_create_categories_translate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories_translate}}', [
            'id' => $this->primaryKey(),

            'language' => $this->string(10),
            'category_id' => $this->integer(),
            'name' => $this->string(255),
            'pageTitle' => $this->string(255),
            'description' => $this->string(),
            'metaDescription' => $this->string(),
            'prefix' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%categories_translate}}');
    }
}
