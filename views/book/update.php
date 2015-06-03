<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = 'Редактирвоание книги: ' . ' ' . $oBook->name;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирвоание';
?>
<div class="book-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'oBook' => $oBook,
        'aAuthor' => $aAuthor,
        'sRef' => $sRef,
    ]) ?>

</div>
