<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%products_translate}}`.
 */
class m250304_092705_add_h1_column_to_products_translate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%products_translate}}', 'h1', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%products_translate}}', 'h1');
    }
}
