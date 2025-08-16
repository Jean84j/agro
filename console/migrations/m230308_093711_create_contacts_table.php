<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contacts}}`.
 */
class m230308_093711_create_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contacts}}', [
            'id' => $this->primaryKey(),
            'address' => $this->string()->comment('Адреса'),
            'tel_primary' => $this->string()->comment('Телефон перший'),
            'tel_second' => $this->string()->comment('Телефон другий'),
            'hours_work' => $this->string()->comment('Години роботи'),
            'coments' => $this->string()->comment('Коментар'),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contacts}}');
    }
}
