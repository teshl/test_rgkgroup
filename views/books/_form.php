<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Authors;

/* @var $this yii\web\View */
/* @var $model app\models\Books */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="books-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author_id')->dropDownList(
        Authors::getList(),
        [
            'options' => [
                $model->author_id => ['selected' => true]
            ]
        ]
    ); ?>

    <?= $form->field($model,'date')->widget(
        \yii\jui\DatePicker::className(), [
            'options' =>[
                'class' => 'form-control',
                'readonly'=> ''
            ]
        ]) ?>

    <? if($model->preview){
        echo Html::img($model->getImgSrc(), ['width'=>'100','class'=>'books-img']);
    }?>

    <?= $form->field($model, 'image')->fileInput(["accept"=>"image/x-png, image/gif, image/jpeg"]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
