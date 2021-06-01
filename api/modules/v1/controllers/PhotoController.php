<?php

namespace api\modules\v1\controllers;

use common\models\Collection;
use common\models\Photo;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;

class PhotoController extends ActiveController
{
    public $modelClass = Photo::class;

    public function init()
    {
        parent::init();
        Yii::$app->user->enableSession = false;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpBearerAuth::class,
            ],
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset(
            $actions['delete'],
            $actions['create'],
            $actions['update'],
            $actions['index'],
            $actions['view']
        );

        return $actions;
    }

    public function actionIndex()
    {
        $subQuery = Collection::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->select('id');
        $query = Photo::find()->where(['in', 'collection_id', $subQuery]);
        $photos = $query->all();

        if (count($photos) < 1) {
            throw new NotFoundHttpException("photos not found.");
        }

        return $photos;
    }

    public function actionView($id)
    {
        return $this->getPhoto($id);
    }

    private function getPhoto($id)
    {
        $photo = Photo::findOne($id);

        if (!$photo) {
            throw new NotFoundHttpException('Photo not found.');
        }

        //$collection = $photo->getCollection()->one();
        $collection = $photo->find()->where(['photo_unsplash_id' => $id)->one();

        if ($collection->user_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are unauthorized to access the requested resource.');
        }

        return $photo;
    }


}