<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $indexes  */
/* @var $model \app\models\identity\Users|array|null */
/* @var $personal \app\models\identity\Personnel|array|null */
/* @var $meanindex float */
/* @var $articles array */
/* @var $currentarticles array */
/* @var $dataprovider \yii\data\ArrayDataProvider */

$this->title = 'Личный кабинет - ' . $model->name.  ' ' . $model->lastname;
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('/js/modules/personal/module.js');

?>

<br>
<br>
<br>

<!-- upper buttons -->
<div class="row">
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-4">
                <div id="upper_buttons">
                    <?php
                    echo $this->render('forms/controlrow', [
                        'model' => $model,
                        'notifications' => $notifications,
                        'message' => $message,
                        'author' => $author
                    ]);
                    ?>
                </div>
            </div>
            <div class="col-lg-8">
                <?= $this->render('forms/indexes', [
                    'personaldata' => $personaldata
                ]); ?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <?php
                echo $this->render('forms/info', [
                    'author' => $author,
                    'staff' => $personal
                ]);
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-offset-1 col-lg-3">
        <div id="photo-holder">
            <?php
            if ($model->image == null) {
                echo $this->render('forms/noimage', [
                    'file' => $file
                ]);
            } else {
                echo $this->render('forms/imageholder', [
                    'user' => $model
                ]);
            }
            ?>
        </div>
    </div>
</div>
<br>
<br>
<div class="row">
    <div class="col-lg-12">
        <hr>
    </div>
</div>
<br>
<br>
<br>

<!-- personal data -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-body">
                <br>
                <?php

                echo $this->render('forms/personaldata', [
                    'personaldata' => $personaldata
                ]);

                ?>
            </div>
        </div>
    </div>
</div>
<!-- end block -->

<br>
<div class="row">
    <div class="col-lg-12">
        <hr>
    </div>
</div>
<br>
<br>

<div id="diagrams" class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <div align="left">
                    <?= Html::button('<span class="glyphicon glyphicon-dashboard"></span>', ['id' => 'chart1']);?>
                    <?= Html::button('<span class="glyphicon glyphicon-equalizer"></span>', ['id' => 'chart2']);?>
                </div>
                <h5 style="color: gray;" align="right">Распределение научных результатов</h5>
            </div>
            <div class="panel panel-body">
                <div>
                    <?php
                    echo $this->render('forms/diagrams', [
                            'personal' => $personaldata
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<br>
<br>
<br>

<?php

\yii\helpers\VarDumper::dump($author->indexedArticlesJournals);
