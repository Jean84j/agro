<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tag_translate}}`.
 */
class m241122_112859_create_tag_translate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tag_translate}}', [
            'id' => $this->primaryKey(),
            'language' => $this->string(3),
            'tag_id' => $this->integer(),
            'name' => $this->string(50),
            'description' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tag_translate}}');
    }
}
