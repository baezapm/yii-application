
<?php

use yii\web\View;

$this->title = 'Search';
$this->registerJsVar('collections', $collections);
$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/unsplash.js',
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);
?>
<div>
    <h3>Add fotos to collection</h3>
    <br>
    <div class="search-box">
        <div class="form-inline">
            <input type="text" value="" name="search" , id="search" class="form-control" autocomplete="off">
            <button onclick="search(1)" class="btn btn-primary">Search</button>
        </div>
    </div>


    <div id="gallery" class="card-columns row">

    </div>
    <div class="load-more-container">
        <button class="btn btn-outline-primary" id="load-more" data-page="2">Load more</button>
    </div>

</div>
