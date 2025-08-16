<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%review}}`.
 */
class m230321_194308_create_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%review}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->comment('Товар'),
            'created_at' => $this->integer()->comment('Дата публікації'),
            'rating' => $this->float()->comment('Рейтинг'),
            'name' => $this->string()->comment('Імя'),
            'email' => $this->string()->comment('Email'),
            'message' => $this->string()->comment('Текст'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%review}}');
    }
}
