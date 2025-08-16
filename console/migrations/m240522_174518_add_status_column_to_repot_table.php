<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%report}}`.
 */
class m240522_174518_add_status_column_to_repot_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%report}}', 'order_status_id', $this->integer());
        $this->addColumn('{{%report}}', 'order_pay_ment_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%report}}', 'order_status_id');
        $this->dropColumn('{{%report}}', 'order_pay_ment_id');
    }
}
