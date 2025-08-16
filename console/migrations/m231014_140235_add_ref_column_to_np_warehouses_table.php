<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%np_warehouses}}`.
 */
class m231014_140235_add_ref_column_to_np_warehouses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%np_warehouses}}', 'ref', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%np_warehouses}}', 'ref');
    }
}
