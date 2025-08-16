<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories_properties}}`.
 */
class m250108_185154_create_categories_properties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories_properties}}', [
            'category_id' => $this->integer(),
            'property_id' => $this->integer(),
            'PRIMARY KEY(category_id, property_id)',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%categories_properties}}');
    }
}
