<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $model \app\modules\Control\models\Articles|\app\modules\Control\models\Monographies|mixed|\yii\db\ActiveRecord */
/* @var $classes \app\modules\Control\models\Articles[]|array */
?>

<div class="panel panel-default">
    <div class="panel panel-body">

    <?php $form = ActiveForm::begin(); ?>

    <br>

    <?php

    $classes_items = ArrayHelper::map($classes, 'id', 'description');

    ?>

    <div class="row">
        <div class="col-lg-10">
            <?= $form->field($model, 'title')->textInput([
                'maxlength' => true,
                'style' => 'background-color: #ffffe0;'
            ]) ?>
        </div>
    </div>


    <!-- Subtite input - text area (max 255 chars) -->
    <div class="row">
        <div class="col-lg-10">
            <?= $form->field($model, 'subtitle')->textArea([
                'rows' => 2,
                'maxlength' => true,
                'style' => 'background-color: #ffffe0;'
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10">
            <?= $form->field($model, 'publisher')->textInput([
                'maxlength' => true,
                'style' => 'background-color: #ffffe0;'
            ]) ?>
        </div>
    </div>


    <!-- year publishing and DOI index input - in one row -->
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'year')->widget(etsoft\widgets\YearSelectbox::classname(), [
                'yearStart' => -10,
                'yearEnd' => 10,
            ]);
            ?>
        </div>
        <div class="col-lg-7">
            <?= $form->field($model, 'isbn')->textInput([
                'maxlength' => true,
                'style' => 'background-color: #ffffe0;'
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">

            <?= $form->field($model, 'class')->dropDownList($classes_items, [
                'prompt' => 'Выберите категорию',
            ]) ?>
        </div>
    </div>

        <div class="row">
            <div class="col-lg-5">

                <br>
                <?= Html::submitButton('Сохранить', ['class' => 'button big primary']) ?>
                <br>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <br>
    </div>

    </div>