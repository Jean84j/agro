<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%np_city}}`.
 */
class m231014_133646_add_description_column_to_np_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%np_city}}', 'description', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%np_city}}', 'description');
    }
}
