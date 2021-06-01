<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Collection */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Collections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsVar('collectionName', $this->title);
\yii\web\YiiAsset::register($this);

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/jszip.min.js',
    [
        'depends' => "yii\web\JqueryAsset",
    ]
);

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/jszip-utils.min.js',
    [
        'depends' => "yii\web\JqueryAsset",
    ]
);

$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/FileSaver.min.js',
    [
        'depends' => "yii\web\JqueryAsset",
    ]
);
$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/download.js',
    [
        'depends' => "yii\web\JqueryAsset",
    ]
);
?>
<div class="collection-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update Collection', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Download Collection', ['update', 'id' => $model->id], ['class' => 'btn btn-success', 'id'=>'download']) ?>
        <?= Html::a('Delete Collection', ['delete', 'id' => $model->id],  [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this collection?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            foreach ($photos as $key => $photo){ ?>
                <div class="carousel-item <?php if($key == 0){ echo 'active'; } ?>">
                    <img class="d-block w-100 photo" src="<?= $photo["path"] ?>" alt="slide">
                </div>
            <?php } ?>

        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>


</div>
