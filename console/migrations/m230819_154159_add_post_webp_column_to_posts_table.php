<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%posts}}`.
 */
class m230819_154159_add_post_webp_column_to_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%posts}}', 'webp_image', $this->string());
        $this->addColumn('{{%posts}}', 'webp_extra_large', $this->string());
        $this->addColumn('{{%posts}}', 'webp_large', $this->string());
        $this->addColumn('{{%posts}}', 'webp_medium', $this->string());
        $this->addColumn('{{%posts}}', 'webp_small', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%posts}}', 'webp_image');
        $this->dropColumn('{{%posts}}', 'webp_extra_large');
        $this->dropColumn('{{%posts}}', 'webp_large');
        $this->dropColumn('{{%posts}}', 'webp_medium');
        $this->dropColumn('{{%posts}}', 'webp_small');
    }
}
