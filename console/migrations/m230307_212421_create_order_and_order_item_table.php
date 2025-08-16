<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_and_order_item}}`.
 */
class m230307_212421_create_order_and_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_status}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()

        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->comment('Дата створення'),
            'updated_at' => $this->integer()->comment('Дата оновлення'),
            'order_status_id' => $this->integer()->comment('Статус'),
            'fio' => $this->string()->comment('ПІБ'),
            'phone' => $this->string()->comment('Телефон'),
            'city' => $this->string()->comment('Город'),
            'note' => $this->text()->comment('Примітка'),

        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createTable('{{%order_item}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->comment('Інформація про замовлення'),
            'product_id' => $this->integer()->comment('Товар'),
            'quantity' => $this->string()->comment('Кількість'),
            'price' => $this->decimal(19, 2)->comment('Ціна'),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');


        $this->createIndex(
            'idx-order-status-id',
            'order_status',
            'id'
        );
        $this->createIndex(
            'idx-order-id',
            'order',
            'city'
        );
        $this->createIndex(
            'idx-order-item-id',
            'order_item',
            'order_id'
        );

        $this->addForeignKey(
            'fk-order-id',
            'order_item',
            'order_id',
            'order',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-status-order-id',
            'order',
            'order_status_id',
            'order_status',
            'id',
            'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
        $this->dropTable('{{%order_cart}}');
        $this->dropTable('{{%order_status}}');
    }
}
