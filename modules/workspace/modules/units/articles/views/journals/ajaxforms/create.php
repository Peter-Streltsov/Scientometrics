<?php

// extensions
use kartik\select2\Select2;
// yii classes
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $classes  */
/* @var $this \yii\web\View */
/* @var $model \app\modules\Control\models\Articles|mixed|\yii\db\ActiveRecord */
/* @var $types array */
/* @var $magazines  */
/* @var $languages \app\models\common\Languages */

?>


<div class="articles-form">

    <div class="panel panel-default">
        <div class="panel panel-body">
            <?php $form = ActiveForm::begin(); ?>

            <br>

            <?php

            $classes_items = ArrayHelper::map($classes, 'id', 'description');

            ?>

            <div class="well">
                <b style="color: red;">Авторов необходимо сопоставить статье после создания базовой записи</b>
            </div>

            <br>
            <br>

            <div class="row">
                <div class="col-lg-12">
                    <?= $form->field($model, 'title')->textarea(['maxlength' => true]) ?>
                </div>
            </div>

            <br>
            <br>

            <div class="row">
                <div class="col-lg-12">
                    <?= $form->field($model, 'magazine')->dropDownList($magazines)?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'number')->textInput() ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'direct_number')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <br>
            <br>

            <div class="row">
                <div class="col-lg-2">
                    <?= $form->field($model, 'year')->dropDownList(Yii::$app->yearselector->select)?>
                </div>
                <div class="col-lg-5">
                    <?= $form->field($model, 'doi')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-5">
                    <?= $form->field($model, 'language')->dropDownList($languages); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-5">
                    <?= $form->field($model, 'type')->dropDownList($types); ?>
                </div>
                <div class="col-lg-7">
                    <?= $form->field($model, 'class')->dropDownList($classes_items); ?>
                </div>
            </div>

            <br>
            <br>

            <div class="row">
                <div class="col-lg-12">
                    <?= $form->field($model, 'annotation')->textarea(); ?>
                </div>
            </div>

            <br>
            <br>

            <div class="row">
                <div class="col-lg-12">
                    <?= $form->field($model, 'index')->textarea(['rows' => 5]); ?>
                </div>
            </div>

            <br>
            <br>

            <div class="row">
                <div class="col-lg-5">
                    <?= $form->field($model, 'file')->fileInput(['class' => 'btn btn-default']) ?>
                </div>
            </div>

            <div class="form-group">

                <br>
                <br>
                <?= Html::submitButton('Сохранить', ['class' => 'button big primary']) ?>
                <br>
            </div>

            <?php ActiveForm::end(); ?>

            <br>
            <br>
            <br>
        </div>
    </div>

</div>