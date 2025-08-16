<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_properties_translate}}`.
 */
class m240706_052616_create_product_properties_translate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_properties_translate}}', [
            'id' => $this->primaryKey(),
            'property_id' => $this->integer(),
            'language' => $this->string(10),
            'properties' => $this->string(50),
            'value' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_properties_translate}}');
    }
}
