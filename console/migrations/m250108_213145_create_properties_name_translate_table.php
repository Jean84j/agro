<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%properties_name_translate}}`.
 */
class m250108_213145_create_properties_name_translate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%properties_name_translate}}', [
            'id' => $this->primaryKey(),
            'language' => $this->string(3),
            'name_id' => $this->integer(),
            'name' => $this->string(50),
            'sort' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%properties_name_translate}}');
    }
}
