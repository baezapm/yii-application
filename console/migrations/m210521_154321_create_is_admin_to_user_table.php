<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%is_admin_to_user}}`.
 */
class m210521_154321_create_is_admin_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'is_admin', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'is_admin');
    }
}
