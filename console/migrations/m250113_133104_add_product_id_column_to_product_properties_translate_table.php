<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product_properties_translate}}`.
 */
class m250113_133104_add_product_id_column_to_product_properties_translate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_properties_translate}}', 'product_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_properties_translate}}', 'product_id');
    }
}
