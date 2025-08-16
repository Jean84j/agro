<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auxiliary_categories}}`.
 */
class m240202_085734_create_auxiliary_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auxiliary_categories}}', [
            'id' => $this->primaryKey(),
            'parentId' => $this->integer(),
            'name' => $this->string(),
            'pageTitle' => $this->string(),
            'slug' => $this->string(),
            'image' => $this->string(),
            'visibility' => $this->string(),
            'description' => $this->string(),
            'metaDescription' => $this->string(),
            'svg' => $this->string(),
            'prefix' => $this->string(),
            'object' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auxiliary_categories}}');
    }
}
