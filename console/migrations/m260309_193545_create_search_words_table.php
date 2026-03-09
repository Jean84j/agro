<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%search_words}}`.
 */
class m260309_193545_create_search_words_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%search_words}}', [
            'id' => $this->primaryKey(),
            'word' => $this->string(),
            'counts_query' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%search_words}}');
    }
}
