<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Индексы ПНРД - статьи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indexes-articles-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <br>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a('Создать новый индекс', ['create', 'class' => 'articles'], ['class' => 'button primary big']) ?>
    </p>

    <br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
                'class' => 'table table-hover'
        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'description:ntext',
            'value',

            [
                    'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}'
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
