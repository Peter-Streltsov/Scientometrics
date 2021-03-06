<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\publications\articles\conferences\ArticleConference */
/* @var $classes */
/* @var $languages */
/* @var $magazines */
/* @var $associations */
/* @var $linked_authors */
/* @var $newauthor */
/* @var $author_items */
/* @var $newcitation */
/* @var $citation_classes */

$this->title = 'Редактировать данные - ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Статьи - публикации материалов конференций', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="article-conferences-update">

    <div class="row">
        <div class="col-lg-10">
            <br>
            <br>
            <h3 style="color: gray;"><?= Html::encode($this->title) ?></h3>
            <br>
            <br>
            <br>
            <br>
        </div>
    </div>

    <!-- -->
    <?php Pjax::begin(); ?>
    <div>
        <?= $this->render('forms/update/buttons_form', [
            'model' => $model,
            //'file' => $file
        ]) ?>
    </div>
    <?php Pjax::end(); ?>
    <br>
    <br>

    <!----------------------------------------------------------------------------------------------------------------->
    <!-- Rendering main article form using Yii Pjax widget ------------------------------------------------------------>

    <?php Pjax::begin([
        'enablePushState' => false,
    ]); ?>
    <div class="articles-form">
        <?= $this->render('forms/update/article_form', [
            'classes' => $classes,
            'languages' => $languages,
            'magazines' => $magazines,
            'model' => $model
        ]) ?>
    </div>
    <?php Pjax::end(); ?>

    <!----------------------------------------------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------------------------------------------->

    <br>
    <br>

    <!----------------------------------------------------------------------------------------------------------------->
    <!-- Rendering associations form form using Yii Pjax widget ------------------------------------------------------->

    <?php Pjax::begin([
        'enablePushState' => false,
        'id' => 'associations',
    ]); ?>
    <div id="associations">
        <?= $this->render('forms/update/associations_form', [
            'associations' => $associations,
            'id' => $id
        ]); ?>
    </div>
    <?php Pjax::end(); ?>

    <!----------------------------------------------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------------------------------------------->

    <br>
    <br>

    <?php Pjax::begin([
        'enablePushState' => false,
        'id' => 'authors'
    ]); ?>

    <div id="authors">
        <?= $this->render('forms/update/authors_form', [
            'linked_authors' => $linked_authors,
            'model' => $model,
            'error' => null,
            'author_items' => $author_items,
            'newauthor' => $newauthor,
            'id' => $id
        ]); ?>
    </div>

    <?php Pjax::end(); ?>

    <br>
    <br>

    <!----------------------------------------------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------------------------------------------->

    <?php Pjax::begin([
        'id' => 'citations',
        'enablePushState' => false,
    ]); ?>

    <div id="citations">
        <?= $this->render('forms/update/citations_form', [
            'model' => $model,
            'citations' => $citations,
            'citation_classes' => $citation_classes,
            'newcitation' => $newcitation,
            'id' => $id
        ]) ?>
    </div>

    <?php Pjax::end(); ?>

</div>
