<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts_translate}}`.
 */
class m240707_202038_create_posts_translate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts_translate}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'language' => $this->string(10),
            'title' => $this->string(),
            'description' => $this->text(),
            'seo_title' => $this->string(),
            'seo_description' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%posts_translate}}');
    }
}
