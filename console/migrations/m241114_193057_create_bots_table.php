<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bots}}`.
 */
class m241114_193057_create_bots_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bots}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'comment' => $this->string(),
            'blocking' => $this->boolean()->defaultValue(true),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bots}}');
    }
}
