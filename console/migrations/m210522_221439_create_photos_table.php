<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%photos}}`.
 */
class m210522_221439_create_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->createTable('collection_photos', [
          'id' => $this->primaryKey(),
          'photo_unsplash_id' => $this->string()->notNull(),
          'collection_id' => $this->integer()->notNull(),
          'path' => $this->string()->notNull(),
      ]);

      $this->addForeignKey(
          'fk-collection-photos-collection_id',
          'collection_photos',
          'collection_id',
          'collection',
          'id',
          'CASCADE'
      );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%photos}}');
    }
}
