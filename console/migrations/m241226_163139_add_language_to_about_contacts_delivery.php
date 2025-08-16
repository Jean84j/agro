<?php

use yii\db\Migration;

/**
 * Class m241226_163139_add_language_to_about_contacts_delivery
 */
class m241226_163139_add_language_to_about_contacts_delivery extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%about}}', 'language', $this->string(3)->notNull()->defaultValue('uk'));

        $this->addColumn('{{%contacts}}', 'language', $this->string(3)->notNull()->defaultValue('uk'));

        $this->addColumn('{{%delivery}}', 'language', $this->string(3)->notNull()->defaultValue('uk'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%about}}', 'language');

        $this->dropColumn('{{%contacts}}', 'language');

        $this->dropColumn('{{%delivery}}', 'language');
    }

}
