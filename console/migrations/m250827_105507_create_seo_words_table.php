<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%seo_words}}`.
 */
class m250827_105507_create_seo_words_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%seo_words}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'product_id' => $this->integer(),
            'uk_word' => $this->string(50),
            'ru_word' => $this->string(50),
            'visible' => $this->boolean()->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%seo_words}}');
    }
}
