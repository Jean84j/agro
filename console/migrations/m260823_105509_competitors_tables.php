<?php

use yii\db\Migration;

class m260823_105509_competitors_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%competitors}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
        ]);

        $this->createTable('{{%competitor_price}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'name' => $this->string(),
            'url' => $this->string(),
            'price' => $this->decimal(19.2),
            'last_checked_at' => $this->integer(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('{{%competitor_price}}');
        $this->dropTable('{{%competitors}}');
    }

}
