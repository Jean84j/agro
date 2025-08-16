<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%active_pages}}`.
 */
class m230526_051659_create_active_pages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%active_pages}}', [
            'id' => $this->primaryKey(),
            'ip_user' => $this->string()->comment('IP пользователя'),
            'url_page' => $this->string()->comment('Страница'),
            'user_agent' => $this->string()->comment('User agent'),
            'client_from' => $this->string()->comment('Откуда пользователь'),
            'date_visit' => $this->string()->comment('Дата визита'),
            'status_serv' => $this->string()->comment('Статус сервера'),
            'other' => $this->string()->comment('Прочее'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%active_pages}}');
    }
}
