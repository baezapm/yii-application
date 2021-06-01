<?php

namespace frontend\controllers;

use Yii;
use common\models\Photo;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use DateTime;
use Exception;
use igogo5yo\uploadfromurl\UploadFromUrl;
use yii\helpers\BaseFileHelper;
use yii\helpers\VarDumper;
use yii\web\Response;
use ZipArchive;

/**
 * PhotoController implements the CRUD actions for Photo model.
 */
class PhotoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Photo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Photo::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Photo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Photo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Photo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Photo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Photo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Photo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Photo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Photo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAdd($photo_unsplash_id, $collection_id, $path)
    {
      Yii::$app->response->format = Response::FORMAT_JSON;
      $transaction = Photo::getDb()->beginTransaction();
      try {
            //If photo is already added in the collection
            $photo = Photo::find()->where(['photo_unsplash_id' => $photo_unsplash_id, 'collection_id' => $collection_id])->one();

            if(!empty($photo->id)){
                return [
                    "type" => "error",
                    "message" => "Photo already added in the collection"
                ];
            }
            $newPhoto = new Photo();
            $newPhoto->photo_unsplash_id = $photo_unsplash_id;
            $newPhoto->collection_id = $collection_id;
            $newPhoto->path = $path;
            $newPhoto->save();

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();

            return [
                "type" => "error",
                "message" => "something happend. Photo doesn't added."
            ];
        }

        return [
            "type" => "success",
            "message" => "Photo added to the collection."
        ];
    }
}
