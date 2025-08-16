<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%np_areas}}`.
 */
class m231014_124206_create_np_areas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%np_areas}}', [
            'id' => $this->primaryKey(),
            'ref' => $this->string(),
            'areasCenter' => $this->string(),
            'description' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%np_areas}}');
    }
}
