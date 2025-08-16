<?php

use yii\db\Migration;

/**
 * Class m250326_065326_add_h1_to_tables
 */
class m250326_065326_add_h1_to_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%category}}', 'h1', $this->string());
        $this->addColumn('{{%categories_translate}}', 'h1', $this->string(150));
        $this->addColumn('{{%auxiliary_categories}}', 'h1', $this->string(150));
        $this->addColumn('{{%auxiliary_translate}}', 'h1', $this->string(150));
    }

    /**
     * {@inheritdoc}
     */

    public function safeDown()
    {
        $this->dropColumn('{{%category}}', 'h1');
        $this->dropColumn('{{%categories_translate}}', 'h1');
        $this->dropColumn('{{%auxiliary_categories}}', 'h1');
        $this->dropColumn('{{%auxiliary_translate}}', 'h1');
    }
}
