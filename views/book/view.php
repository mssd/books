<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = $oBook->name;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $oBook,
        'attributes' => [
            'id',
            [
                'attribute' => 'author_id',
                'value' => $oBook->author->FIO,
            ],            
            'name',
            [
                'attribute' => 'preview',
                'value' => Yii::$app->homeUrl.'/uploads/'.$oBook->preview,
                'format' => ['image',['width'=>'300']],
            ],
            [
                'attribute' => 'date_release',
                'value' => $oBook->release
            ],
            [
                'attribute' => 'date_create',
                'value' => $oBook->create
            ], 
        ],
    ]) ?>

</div>
