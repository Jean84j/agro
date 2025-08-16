<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%tag}}`.
 */
class m240703_100319_add_translate_column_to_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tag}}', 'name_ru', $this->string(50));
        $this->addColumn('{{%tag}}', 'name_en', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tag}}', 'name_ru');
        $this->dropColumn('{{%tag}}', 'name_en');
    }
}
