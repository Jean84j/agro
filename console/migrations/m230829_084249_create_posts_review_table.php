<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts_review}}`.
 */
class m230829_084249_create_posts_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts_review}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'created_at' => $this->integer(),
            'rating' => $this->float(),
            'name' => $this->string(),
            'email' => $this->string(),
            'message' => $this->string(),
            'viewed' => $this->integer()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%posts_review}}');
    }
}
