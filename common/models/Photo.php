<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "collection_photos".
 *
 * @property int $id
 * @property string $photo_unsplash_id
 * @property int $collection_id
 * @property string $path
 *
 * @property Collection $collection
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'collection_photos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['photo_unsplash_id', 'collection_id', 'path'], 'required'],
            [['collection_id'], 'integer'],
            [['photo_unsplash_id', 'path'], 'string', 'max' => 255],
            [['collection_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collection::className(), 'targetAttribute' => ['collection_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photo_unsplash_id' => 'Photo Unsplash ID',
            'collection_id' => 'Collection ID',
            'path' => 'Path',
        ];
    }

    /**
     * Gets query for [[Collection]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCollection()
    {
        return $this->hasOne(Collection::className(), ['id' => 'collection_id']);
    }
}
