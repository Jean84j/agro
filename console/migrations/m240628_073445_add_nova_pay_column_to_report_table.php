<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%report}}`.
 */
class m240628_073445_add_nova_pay_column_to_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%report}}', 'nova_pay', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%report}}', 'nova_pay');
    }
}
