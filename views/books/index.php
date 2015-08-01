<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Authors;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BooksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Books', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div>

        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'options' => ['class' => 'form-inline']
        ]); ?>

        <div class="form-group">
            <?= $form->field($searchModel, 'author_id')->dropDownList(
                array_merge( [0=>'Автор'] ,Authors::getList()),
                [
                    'options' => [
                        'class'=>'form-control',
                        $searchModel->author_id => ['selected' => true]
                    ]
                ]
            )->label(false); ?>
        </div>

        <div class="form-group">
            <?= $form->field($searchModel, 'name')->textInput(['placeholder'=>'название книги'])->label(false) ?>
        </div>

        <?= $form->field($searchModel,'date_from')->widget(
            \yii\jui\DatePicker::className(), [
            'options' =>[
                'class' => 'form-control',
                'readonly'=> ''
            ]
        ]) ?>

        <?= $form->field($searchModel,'date_to')->widget(
            \yii\jui\DatePicker::className(), [
            'options' =>[
                'class' => 'form-control',
                'readonly'=> ''
            ]
        ]) ?>

        <?= Html::submitButton('Искать', ['class' => 'btn btn-primary', 'style'=>'margin-top:-10px']) ?>

    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'options'=>[
            'id'=>'table_books'
        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            [
                'attribute' => 'preview',
                'format' => 'html',
                'value' => function($data) {
                    return $data->preview ? Html::img($data->getImgSrc(), ['width'=>'50','class'=>'books-img']) : $data->preview;
                },
            ],
            'authorFullName',
            [
                'attribute' => 'date',
                'format' =>  ['date'],
            ],
            [
                'attribute' => 'date_create',
                'format' =>  ['date']
            ],
            [
                'class'   => 'yii\grid\ActionColumn',
                'header'  => 'Кнопки действий',
                'template'=>'{update} {view} {delete}'
            ]
        ],
    ]); ?>

</div>

<div id="modal_books_view" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->