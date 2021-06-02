<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Collection */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Collections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="collection-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Download Collection', ['update', 'id' => $model->id], ['class' => 'btn btn-success', 'id'=>'download']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Add images', ['unsplash/index', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'user_id',
        ],
    ]) ?>

    <h3>Collection Photos</h3>
    <div class="card-columns row">
        <?php foreach ($photos as $photo) { ?>
            <div class="card image-grid-item col-sm-3">
                <img class="card-img-top img-fluid" src="<?= $photo["path"] ?>" alt="image">
                <div class="card-block card-block-btn-group">
                    <div>
                        <!--<?= Html::a(Yii::t('app', 'Show'), ['photo/view', "id" => $photo->id], ['class' => 'btn btn-primary']) ?>-->
                        <!-- <?= Html::a(Yii::t('app', 'Delete'), ['photo/delete', "id" => $photo->id], ['class' => 'btn btn-danger']) ?>-->
                        <?= Html::a('Delete', ['photo/delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>

</div>
