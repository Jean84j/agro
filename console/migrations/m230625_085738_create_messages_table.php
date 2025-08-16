<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%messages}}`.
 */
class m230625_085738_create_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%messages}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('Имя'),
            'email' => $this->string()->comment('Почта'),
            'subject' => $this->string()->comment('Тема'),
            'message' => $this->text()->comment('Сообщение'),
            'comment' => $this->text()->comment('Коментарий менеджера'),
            'viewed' => $this->integer()->comment('Просмотр')->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%messages}}');
    }
}
