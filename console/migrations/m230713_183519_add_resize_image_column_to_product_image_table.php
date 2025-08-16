<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product_image}}`.
 */
class m230713_183519_add_resize_image_column_to_product_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_image}}', 'extra_extra_large', $this->string());
        $this->addColumn('{{%product_image}}', 'extra_large', $this->string());
        $this->addColumn('{{%product_image}}', 'large', $this->string());
        $this->addColumn('{{%product_image}}', 'medium', $this->string());
        $this->addColumn('{{%product_image}}', 'small', $this->string());
        $this->addColumn('{{%product_image}}', 'extra_small', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_image}}', 'extra_extra_large');
        $this->dropColumn('{{%product_image}}', 'extra_large');
        $this->dropColumn('{{%product_image}}', 'large');
        $this->dropColumn('{{%product_image}}', 'medium');
        $this->dropColumn('{{%product_image}}', 'small');
        $this->dropColumn('{{%product_image}}', 'extra_small');
    }
}
