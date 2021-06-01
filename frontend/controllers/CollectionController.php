<?php

namespace frontend\controllers;

use Yii;
use common\models\Collection;
use common\models\CollectionSearch;
use common\models\Photo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use DateTime;

/**
 * CollectionController implements the CRUD actions for Collection model.
 */
class CollectionController extends Controller
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
     * Lists all Collection models.
     * @return mixed
     */
     public function actionIndex()
     {
         $searchModel = new CollectionSearch();
         $dataProvider = new ActiveDataProvider([
             'query' => Collection::find()->where(['user_id' => Yii::$app->user->id]),
         ]);

         return $this->render('index', [
             'searchModel' => $searchModel,
             'dataProvider' => $dataProvider,
         ]);
     }

     /**
      * Displays a single Collection model.
      * @param integer $id
      * @return mixed
      * @throws NotFoundHttpException if the model cannot be found
      */
     public function actionView($id)
     {

         $photos = Photo::find()->where(["collection_id" => $id])->all();

         return $this->render('view', [
             'model' => $this->findModel($id),
             'photos' => $photos,
         ]);
     }

     /**
      * Creates a new Collection model.
      * If creation is successful, the browser will be redirected to the 'view' page.
      * @return mixed
      */
     public function actionCreate()
     {
         $model = new Collection();
         $fields = Yii::$app->request->post();
         $fields['Collection']['user_id'] = Yii::$app->user->identity->getId();


         if ($model->load($fields) && $model->save()) {
            try {
                Yii::$app->session->setFlash('success', "Collection created.");

                return $this->redirect(['unsplash/index']);
            } catch (\Throwable $th) {
                Yii::$app->session->setFlash('error', "Error creating collection.");
            }
        }

         return $this->render('create', [
             'model' => $model,
         ]);
     }

     /**
      * Updates an existing Collection model.
      * If update is successful, the browser will be redirected to the 'view' page.
      * @param integer $id
      * @return mixed
      * @throws NotFoundHttpException if the model cannot be found
      */
     public function actionUpdate($id)
     {
         $model = $this->findModel($id);

         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
             $model->save();

             return $this->redirect(['view', 'id' => $model->id]);
         }

         $photos = Photo::find()->where(["collection_id" => $id])->all();

         return $this->render('update', [
             'model' => $model,
             'photos' => $photos,
         ]);
     }

     /**
      * Deletes an existing Collection model.
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
     * Finds the Collection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Collection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Collection::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
