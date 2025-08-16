<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%slider}}`.
 */
class m230618_064518_add_slug_column_to_slider_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%slider}}', 'slug', $this->string()->comment('Слаг'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%slider}}', 'slug');
    }
}
