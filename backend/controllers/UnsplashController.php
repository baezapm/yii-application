<?php

namespace backend\controllers;

use common\models\Collection;
use DateTime;
use yii\httpclient\Client;
use Exception;
use frontend\models\UnsplashSearchForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\Url;

class UnsplashController extends \yii\web\Controller
{
    public function actionIndex($id = ''){

      if(!empty($id)){
          $collections =  $id;
      }else{
          $collections = Yii::$app->user->identity->getCollections()->asArray()->all();
      }
      return $this->render('index', [
          "collections" => $collections
      ]);
    }

    public function actionSearch()
    {
        $term = Yii::$app->request->post()["search"];
        $page = Yii::$app->request->post()["page"];

        $photos = Yii::$app->get('unsplash')->get($term, $page);

        Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            "search" => $term,
            "data" => $photos
        ];
    }


}
