<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%collection}}`.
 */
class m210521_153744_create_collection_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%collection}}', [
          'id' => $this->primaryKey(),
          'name' => $this->string()->notNull()->unique(),
          'user_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
           'fk-collection-user_id',
           'collection',
           'user_id',
           'user',
           'id',
           'CASCADE'
       );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%collection}}');
    }
}
