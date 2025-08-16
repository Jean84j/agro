<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%report}}`.
 */
class m240522_162323_create_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%report}}', [
            'id' => $this->primaryKey(),
            'platform' => $this->string(50),
            'number_order' => $this->string(50),
            'date_order' => $this->string(50),
            'date_delivery' => $this->string(50),
            'number_order_1c' => $this->string(50),
            'date_payment' => $this->string(50),
            'price_delivery' => $this->integer(),
            'type_payment' => $this->string(50),
            'fio' => $this->string(),
            'tel_number' => $this->string(20),
            'address' => $this->string(),
            'comments' => $this->string(),
            'delivery_service' => $this->string(50),
            'ttn' => $this->string(100),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%report}}');
    }
}
