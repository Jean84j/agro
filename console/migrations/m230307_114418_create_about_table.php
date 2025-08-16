<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%about}}`.
 */
class m230307_114418_create_about_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%about}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('Назва'),
            'description' => $this->text()->comment('Опис')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%about}}');
    }
}
