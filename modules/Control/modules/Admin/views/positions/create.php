<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Control\models\Positions */

$this->title = 'Создать должность';
$this->params['breadcrumbs'][] = ['label' => 'Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="positions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>