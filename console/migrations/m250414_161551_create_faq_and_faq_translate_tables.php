<?php

use yii\db\Migration;

/**
 * Class m250414_161551_create_faq_and_faq_translate_tables
 */
class m250414_161551_create_faq_and_faq_translate_tables extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%faq}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'question' => $this->string(),
            'answer' => $this->text(),
            'visible' => $this->boolean(),

        ]);

        $this->createTable('{{%faq_translate}}', [
            'id' => $this->primaryKey(),
            'faq_id' => $this->integer(),
            'language' => $this->string(3),
            'question' => $this->text(),
            'answer' => $this->text(),

        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%faq_translate}}');

        $this->dropTable('{{%faq}}');
    }
}
