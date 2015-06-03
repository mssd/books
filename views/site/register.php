<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $oUser app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($oUser, 'firstname')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($oUser, 'lastname')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($oUser, 'login')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($oUser, 'password')->passwordInput(['maxlength' => 250]) ?>

    <div class="form-group">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>