<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use common\models\Collection;
use Yii;
use common\models\CollectionSearch;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;


class CollectionController extends ActiveController
{
    public $modelClass = Collection::class;

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
        $searchModel = new CollectionSearch();
        $searchModel->user_id = Yii::$app->user->id;
        return $searchModel->search(Yii::$app->request->queryParams);
    }

    public function actionView($id)
    {
        $collection = Collection::findOne($id);

        if (!$collection) {
            throw new NotFoundHttpException('Collection not found.');
        }
        return $collection;
    }

    public function actionCreate()
    {
        $newCollection = new Collection();
        $newCollection->name = Yii::$app->request->post('collection');
        $newCollection->user_id = Yii::$app->user->id;


        if (!$newCollection->validate()) {
            throw new UnprocessableEntityHttpException('Invalid data provided');
        }

        $newCollection->save();

        return $newCollection;
    }

    public function actionUpdate($id)
    {
        $collection = Collection::find()->where([
            'user_id' => Yii::$app->user->id,
            'id' => $id
        ])->limit(1)->one();

        if (!$collection) {
            throw new NotFoundHttpException('Collection not found.');
        }

        $data = Yii::$app->request->post();
        $collection->name = $data["title"];

        if (!$collection->validate()) {
            throw new UnprocessableEntityHttpException('Invalid data provided');
        }

        $collection->save();

        return $collection;
    }


}