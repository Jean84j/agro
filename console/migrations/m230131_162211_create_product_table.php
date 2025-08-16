<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m230131_162211_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'slug' => $this->string(),
            'description' => $this->text()->notNull(),
            'short_description' => $this->text()->notNull(),
            'price' => $this->money(19, 2)->notNull(),
            'old_price' => $this->money(19, 2),
            'seo_title' => $this->string(),
            'seo_description' => $this->string(),
            'status_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'label_id' => $this->integer()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
