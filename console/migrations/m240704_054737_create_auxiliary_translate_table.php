<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auxiliary_translate}}`.
 */
class m240704_054737_create_auxiliary_translate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auxiliary_translate}}', [
            'id' => $this->primaryKey(),
            'language' => $this->string(10),
            'category_id' => $this->integer(),
            'name' => $this->string(50),
            'description' => $this->string(),
            'pageTitle' => $this->string(),
            'metaDescription' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auxiliary_translate}}');
    }
}
