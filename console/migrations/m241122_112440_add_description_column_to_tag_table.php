<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%tag}}`.
 */
class m241122_112440_add_description_column_to_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tag}}', 'description', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tag}}', 'description');
    }
}
