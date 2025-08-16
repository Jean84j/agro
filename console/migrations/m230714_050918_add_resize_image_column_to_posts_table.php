<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%posts}}`.
 */
class m230714_050918_add_resize_image_column_to_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%posts}}', 'extra_large', $this->string());
        $this->addColumn('{{%posts}}', 'large', $this->string());
        $this->addColumn('{{%posts}}', 'medium', $this->string());
        $this->addColumn('{{%posts}}', 'small', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%posts}}', 'extra_large');
        $this->dropColumn('{{%posts}}', 'large');
        $this->dropColumn('{{%posts}}', 'medium');
        $this->dropColumn('{{%posts}}', 'small');
    }
}
