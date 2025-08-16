<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ip_bot}}`.
 */
class m241114_094739_create_ip_bot_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ip_bot}}', [
            'id' => $this->primaryKey(),
            'ip' => $this->string(20),
            'isp' => $this->string(),
            'blocking' => $this->boolean()->defaultValue(true),
            'comment' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ip_bot}}');
    }
}
