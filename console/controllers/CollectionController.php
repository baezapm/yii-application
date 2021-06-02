<?php
namespace console\controllers;

use common\models\Collection;
use yii\console\Controller;
use yii\helpers\Json;

class CollectionController extends Controller
{
    public $user;

    public function actionSearch()
    {

        echo Json::encode(Collection::find()->with('collectionPhotos')->where('user_id='.$this->user)->asArray()->all())."\n";
    }

    public function optionAliases()
    {
        return ['u' => 'user'];
    }

    public function options($actionID)
    {
        return ['user'];
    }
}