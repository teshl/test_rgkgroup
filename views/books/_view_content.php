<?php

use yii\widgets\DetailView;

?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'date_create',
        'date_update',
        'preview',
        'date',
        'author_id',
    ],
]) ?>