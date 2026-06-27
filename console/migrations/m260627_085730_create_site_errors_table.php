<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%site_errors}}`.
 */
class m260627_085730_create_site_errors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%site_errors}}', [
            'id' => $this->primaryKey(),
            'ip_user' => $this->string(15),
            'url_page' => $this->string(),
            'user_agent' => $this->string(),
            'client_from' => $this->text(),
            'date_visit' => $this->string(10),
            'status_serv' => $this->string(5),
            'other' => $this->string(10),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%site_errors}}');
    }
}
