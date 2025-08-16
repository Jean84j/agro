<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%tag}}`.
 */
class m241218_073435_add_visibility_column_to_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tag}}', 'visibility', $this->boolean()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tag}}', 'visibility');
    }
}
