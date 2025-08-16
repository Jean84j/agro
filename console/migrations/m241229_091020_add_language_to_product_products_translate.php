<?php

use yii\db\Migration;

/**
 * Class m241229_091020_add_language_to_product_products_translate
 */
class m241229_091020_add_language_to_product_products_translate extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'keywords', $this->string());

        $this->addColumn('{{%products_translate}}', 'keywords', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'keywords');

        $this->dropColumn('{{%products_translate}}', 'keywords');

        return false;
    }

}
