<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Collection */

$this->title = 'Update Collection: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Collections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="collection-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <h3>Collection Photos</h3>
    <div class="card-columns">
        <?php foreach ($photos as $photo) { ?>
            <div class="card">
                <img class="card-img-top img-fluid" src="<?= $photo["path"] ?>" alt="image">
                <div class="card-block">
                    <div>
                        <?= Html::a(Yii::t('app', 'Show'), ['photo/view', "id" => $photo->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a(Yii::t('app', 'Delete'), ['photo/delete', "id" => $photo->id], ['class' => 'btn btn-danger']) ?>
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>

</div>
