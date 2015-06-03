<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data'],
        'enableClientValidation' => false,
    ]); ?>

    <?= $form->field($oBook, 'author_id')->dropDownList($aAuthor) ?>

    <?= $form->field($oBook, 'name')->textInput(['maxlength' => 500]) ?>

    <?= $form->field($oBook, 'preview')->fileInput() ?>

    <?= Html::hiddenInput('referrer', $sRef);?>

    <?php if ($oBook->preview): ?>
    <div>
        <img src="<?php echo Yii::$app->homeUrl?>/uploads/<?php echo $oBook->preview;?>">
    </div>
    <?php endif ?>

    <?= $form->field($oBook, 'date_release')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($oBook->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $oBook->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<script type="text/javascript">
    $('#book-date_release').datepicker({
        'dateFormat': 'dd.mm.yy'
    });
</script>
