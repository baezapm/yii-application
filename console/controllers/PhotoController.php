<?php
namespace console\controllers;

use yii\console\Controller;
use yii\console\widgets\Table;
use yii\helpers\Json;

use Yii;

class PhotoController extends Controller
{
    public $term;

    public function actionSearch(){
        $images = Yii::$app->get('unsplash')->get($this->term);

        $rows=[];
        foreach ($images['results'] as $image){
            array_push($rows,[$image['id'],$image['alt_description'],$image['urls']['raw']]);
        }
        echo Table::widget([
            'headers' => ['id','description','url'],
            'rows' => $rows
        ]);
    }

    public function optionAliases()
    {
        return ['q' => 'term'];
    }

    public function options($actionID)
    {
        return ['term'];
    }
}