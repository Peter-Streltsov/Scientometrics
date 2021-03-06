<?php

// yii classes
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\publications\articles\journals\ArticleJournal */
/* @var $class \app\models\pnrd\indexes\IndexesArticles|array|null */
/* @var $authors \app\models\identity\Authors[]|array|string */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Статьи - публикации в журналах', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="articles-view">

    <br>
    <h3 style="color: gray;"><?= Html::encode($this->title) ?></h3>
    <br>
    <br>

    <?= Yii::$app->access->isAdmin() ? $this->render('forms/view/buttons', ['model' => $model]) : ''; ?>

    <br>
    <br>
    <div class="panel panel-default">
        <div class="panel panel-body">
            <br>
            <?= DetailView::widget([
                'model' => $model,
                'view' => [
                        ''
                ],
                'options' => [
                    'style' => 'color: gray;',
                    'class' => 'table',
                    'encodeLabels' => true
                ],
                'attributes' => [
                    'id',
                    'title',
                    'year',
                    'language',
                    'doi',
                [
                    'attribute' => 'type',
                    'label' => 'Тип публикации',
                    'value' => function($model) {
                        return $model->type;
                        }
                    ],
                [
                    'attribute' => 'class',
                    'label' => 'Индекс ПНРД',
                    'value' => function($model) {
                            return $model->publicationclass->description;
                    }
                ],
                [
                    'attribute' => 'file',
                    'label' => 'Прикрепленный файл и текст',
                    'format' => 'raw',
                    'value' => function($model) {
                            if ($model->file != '') {
                                ob_start();
                                if (isset($model->file)) {
                                    Modal::begin([
                                        'header' => "<h2>$model->title</h2><br><h4><h4>",
                                        'size' => 'modal-lg',
                                        'bodyOptions' => [
                                        'width' => '200pc;'
                                        ],
                                        'options' => [
                                                'width' => '200'
                                        ],
                                        'toggleButton' => [
                                            'label' => "<span class='glyphicon glyphicon-file'></span>",
                                            'style' => 'border-radius: 2pc;',
                                            'class' => 'button primary big'
                                        ],
                                        'footer' => 'Close'
                                    ]);
                                    echo \yii2assets\pdfjs\PdfJs::widget([
                                            'url' => \yii\helpers\Url::base().'/upload/articles/' . $model->file
                                    ]);
                                    Modal::end();
                                }
                                $modal = ob_get_clean();
                                return $modal;
                            }
                        }
                    ],
                    [
                        'attribute' => 'authors',
                        'value' => function($model) {
                            $authors = $model->authors;
                            //var_dump($authors);
                            if ($authors != null) {
                                foreach ($authors as $author) {
                                    $html[] = $author['name'] . ' ' . $author['lastname'];
                                }
                                return implode("; ", $html);
                            } else {
                                return null;
                            }
                        }
                    ],
                    'annotation'
                ],
            ]);
            ?>
            <br>
            <br>
            <br>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
