<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_tag}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%product}}`
 * - `{{%tag}}`
 */
class m230131_191937_create_junction_table_for_product_and_tag_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_tag}}', [
            'product_id' => $this->integer(),
            'tag_id' => $this->integer(),
            'PRIMARY KEY(product_id, tag_id)',
        ]);

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-product_tag-product_id}}',
            '{{%product_tag}}',
            'product_id'
        );

        // add foreign key for table `{{%product}}`
        $this->addForeignKey(
            '{{%fk-product_tag-product_id}}',
            '{{%product_tag}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );

        // creates index for column `tag_id`
        $this->createIndex(
            '{{%idx-product_tag-tag_id}}',
            '{{%product_tag}}',
            'tag_id'
        );

        // add foreign key for table `{{%tag}}`
        $this->addForeignKey(
            '{{%fk-product_tag-tag_id}}',
            '{{%product_tag}}',
            'tag_id',
            '{{%tag}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%product}}`
        $this->dropForeignKey(
            '{{%fk-product_tag-product_id}}',
            '{{%product_tag}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-product_tag-product_id}}',
            '{{%product_tag}}'
        );

        // drops foreign key for table `{{%tag}}`
        $this->dropForeignKey(
            '{{%fk-product_tag-tag_id}}',
            '{{%product_tag}}'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            '{{%idx-product_tag-tag_id}}',
            '{{%product_tag}}'
        );

        $this->dropTable('{{%product_tag}}');
    }
}
