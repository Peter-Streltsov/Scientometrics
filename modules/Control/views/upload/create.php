<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Control\models\Upload */

$this->title = 'Загрузить данные';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/control/personal?id='.Yii::$app->user->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="upload-create">

    <br><br>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('forms/create', [
        'model' => $model,
        'classes' => $classes,
        'user' => $user,
        'author' => $author,
        'file' => $file,
    ]) ?>

</div>