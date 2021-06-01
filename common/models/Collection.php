<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\Photo;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\BaseFileHelper;

/**
 * This is the model class for table "{{%collection}}".
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 *
 * @property User $user
 * @property CollectionPhotos[] $collectionPhotos
 */
class Collection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%collection}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
          'id' => 'ID',
          'user_id' => 'User ID',
          'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[CollectionPhotos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCollectionPhotos()
    {
        return $this->hasMany(CollectionPhotos::className(), ['collection_id' => 'id']);
    }

    public function afterDelete()
    {
        Photo::deleteAll(['collection_id' => $this->id]);
        $path = Yii::getAlias('@frontend') . '/web/uploads/' . $this->user_id . '/' . $this->id;
        BaseFileHelper::removeDirectory($path);
    }
}
