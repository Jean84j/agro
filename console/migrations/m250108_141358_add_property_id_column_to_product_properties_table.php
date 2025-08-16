<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product_properties}}`.
 */
class m250108_141358_add_property_id_column_to_product_properties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_properties}}', 'property_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_properties}}', 'property_id');
    }
}
