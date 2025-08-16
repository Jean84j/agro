<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%slider}}`.
 */
class m230502_045644_create_slider_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%slider}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->comment('Название'),
            'description' => $this->text()->comment('Описание'),
            'image' => $this->string()->comment('Картинка'),
            'image_mob' => $this->string()->comment('Картинка мобилбной версии'),
            'visible' => $this->integer()->comment('Показ на странице'),
            'sort' => $this->integer()->comment('Порядок вывода'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%slider}}');
    }
}
