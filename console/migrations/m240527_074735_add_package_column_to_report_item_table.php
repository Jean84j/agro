<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%report_item}}`.
 */
class m240527_074735_add_package_column_to_report_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%report_item}}', 'package', $this->string(6)->defaultValue('SMALL'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%report_item}}', 'package');
    }
}
