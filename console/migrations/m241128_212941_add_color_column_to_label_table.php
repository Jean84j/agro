<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%label}}`.
 */
class m241128_212941_add_color_column_to_label_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%label}}', 'color', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%label}}', 'color');
    }
}
