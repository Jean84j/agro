<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product_image}}`.
 */
class m230819_093058_add_webp_column_to_product_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_image}}', 'webp_name', $this->string());
        $this->addColumn('{{%product_image}}', 'webp_extra_extra_large', $this->string());
        $this->addColumn('{{%product_image}}', 'webp_extra_large', $this->string());
        $this->addColumn('{{%product_image}}', 'webp_large', $this->string());
        $this->addColumn('{{%product_image}}', 'webp_medium', $this->string());
        $this->addColumn('{{%product_image}}', 'webp_small', $this->string());
        $this->addColumn('{{%product_image}}', 'webp_extra_small', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_image}}', 'webp_name');
        $this->dropColumn('{{%product_image}}', 'webp_extra_extra_large');
        $this->dropColumn('{{%product_image}}', 'webp_extra_large');
        $this->dropColumn('{{%product_image}}', 'webp_large');
        $this->dropColumn('{{%product_image}}', 'webp_medium');
        $this->dropColumn('{{%product_image}}', 'webp_small');
        $this->dropColumn('{{%product_image}}', 'webp_extra_small');
    }
}
