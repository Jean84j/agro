<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product_properties}}`.
 */
class m230727_174352_add_sort_column_to_product_properties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_properties}}', 'sort', $this->integer()->defaultValue(10));
        $this->addColumn('{{%product_properties}}', 'category_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_properties}}', 'sort');
        $this->dropColumn('{{%product_properties}}', 'category_id');
    }
}
