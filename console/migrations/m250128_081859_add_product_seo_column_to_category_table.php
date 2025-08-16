<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%category}}`.
 */
class m250128_081859_add_product_seo_column_to_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%category}}', 'product_title', $this->string());
        $this->addColumn('{{%category}}', 'product_description', $this->string());

        $this->addColumn('{{%categories_translate}}', 'product_title', $this->string());
        $this->addColumn('{{%categories_translate}}', 'product_description', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%category}}', 'product_title');
        $this->dropColumn('{{%category}}', 'product_description');

        $this->dropColumn('{{%categories_translate}}', 'product_title');
        $this->dropColumn('{{%categories_translate}}', 'product_description');
    }
}
