<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m230104_213435_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'parentId' => $this->integer(),
            'name' => $this->string()->notNull(),
            'pageTitle' => $this->string()->notNull(),
            'slug' => $this->string()->unique(),
            'file' => $this->string(),
            'visibility' => $this->string(),
            'description' => $this->text(),
            'metaDescription' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
