<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%translations}}`.
 */
class m241128_123601_create_translations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%translations}}', [
            'id' => $this->primaryKey(),
            'category' => $this->string(10),
            'message' => $this->string(),
            'translation' => $this->string(),
            'language' => $this->string(3),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%translations}}');
    }
}
