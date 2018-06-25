<?php

namespace app\modules\Control\controllers;

// project models
use app\models\common\Languages;
use app\models\pnrd\indexes\IndexesArticles;
use app\models\units\articles\Article;
use app\models\units\articles\ArticleTypes;
// deprecated models
use app\modules\Control\models\ArticlesAffilations;
use app\modules\Control\models\ArticlesAuthors;
use app\modules\Control\models\ArticlesCitations;
use app\modules\Control\models\Authors;
use app\modules\Control\models\CitationClasses;
use app\modules\Control\models\Fileupload;
// base models
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ArticlesController implements the CRUD actions for Articles model.
 */
class ArticlesController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];

    }  // end function



    /**
     * Lists all Articles models
     * @return mixed
     */
    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Article::find()//->joinWith('authors'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);

    } // end action



    /**
     * Displays a single Articles model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model = Article::find($id)
            ->where(['articles.id' => $id])
            //->joinWith('data')
            ->one();

        //$model[0]['class'] = $class['description'];

        $authors = Authors::find()->select(['id', 'name', 'lastname'])->asArray()->all();

        if ($authors == null) { $authors = 'не задано';}

        return $this->render('view', [
            'model' => $model,
            'authors' => $authors,
        ]);

    } // end action



    /**
     * Creates a new Articles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Article();
        $languages = new Languages();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $classes = IndexesArticles::find()->asArray()->all();
        $types = ArticleTypes::find()->asArray()->all();
        $types = ArrayHelper::map($types, 'id', 'type');

        return $this->render('create', [
            'model' => $model,
            'languages' => $languages,
            'types' => $types,
            'classes' => $classes
        ]);

    } // end action



    /**
     * Updates an existing Articles model
     * Adds citations, authors etc.
     * If update is successful, will be redirected to 'update' page
     *
     * @param integer $id - article id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = Article::find()->where(['id' => $id])->one();

        if (isset($_POST['delete_text'])) {
            $model->text = null;
            $model->save();
        }

        // affilation
        if (Yii::$app->request->post() && isset($_POST['affilation_flag'])) {
            $newaffilation = new ArticlesAffilations();
            $newaffilation->article_id = $id;
            if ($newaffilation->load(Yii::$app->request->post()) && $newaffilation->save()) {
                Yii::$app->session->setFlash('success', 'Данные обновлены');
            } else {
                Yii::$app->session->setFlash('warning', 'Не удалось обновить данные');
            }
        } elseif (Yii::$app->request->post() && isset($_POST['affilation_delete'])) {
            $affilation = ArticlesAffilations::find()->where([
                'article_id' => $id,
                'name' => $_POST['affilation_delete']
            ])->one();
            $affilation->delete();
        }

        // adding citation
        if (Yii::$app->request->post() && isset($_POST['citation_flag'])) {
            $citation = new ArticlesCitations();
            if ($_POST['citation_flag'] == 'delete') {
                $citation = ArticlesCitations::find()->where(['id' => $_POST['citation_id']])->one();
                $citation->delete() ?
                    Yii::$app->session->setFlash('danger', 'Цитирование удалено')
                    : Yii::$app->session->setFlash('warning', 'Данные не были обновлены');
            } elseif ($citation->load(Yii::$app->request->post()) && $citation->save()) {
                Yii::$app->session->setFlash('success', 'Цитирование добавлено');
            }
        }

        // uploading article file
        if (Yii::$app->request->post() && isset($_POST['upload_flag'])) {
            $file = new Fileupload();
            $file->uploadedfile = UploadedFile::getInstance($file, 'uploadedfile');
            $file->upload('articles/');
            $articlemodel = Article::find()->where(['id' => $id])->one();
            $articlemodel->file = $file->name;
            $articlemodel->save();
            Yii::$app->session->setFlash('info', 'Статье ' . $articlemodel->title . ' сопоставлен файл ' . $file->name);
        }

        // updating article authors
        if (Yii::$app->request->post()) {
            if (isset($_POST['delete']) && $_POST['delete'] == 1) {
                $author_delete = ArticlesAuthors::find()->where([
                    //'author_id' => $_POST['author'],
                    //'article_id' => $id
                    'id' => $_POST['article_authors_id']
                ])->one();
                $author_delete->delete();
            }
            if (isset($_POST['Articles']['authors'])) {
                $newauthor = new ArticlesAuthors();
                $newauthor->article_id = $id;
                $newauthor->author_id = $_POST['Articles']['authors'];
                $newauthor->save();
            }
        }

        // view parameters

        $model_authors = ArticlesAuthors::find()->where(['article_id' => $id])->all();

        // authors for current article
        $authors = Authors::find()->select(['id', 'name', 'lastname'])->asArray()->all();
        $items = ArrayHelper::map($authors, 'id', function($items) {
            return $items['name']. ' ' . $items['lastname'];
        });

        // file to upload if necessary
        $file = new Fileupload();

        // article categories (pnrd)
        $classes = IndexesArticles::find()->select(['id', 'description'])->asArray()->all();

        // article
        $model = Article::find()
            ->where(['articles.id' => $id])
            ->one();
            //->joinWith('data')
            //->all();

        // updating article data - articleform
        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                //return $this->redirect(['update', 'id' => $id]);
            }
        }

        // added citations
        $citations = ArticlesCitations::find()->where(['article_id' => $id])->all();

        //$citation_classes = CitationClasses::find()->asArray()->all();
        $citation_classes = ArrayHelper::map(
            CitationClasses::find()->asArray()->all(),
            'class',
            'class'
        );

        $newcitation = new ArticlesCitations();

        $affilations = $model->affilations;

        // view
        return $this->render('update', [
            'affilations' => $affilations,
            'model' => $model,
            'file' => $file,
            'classes' => $classes,
            'model_authors' => $model_authors,
            'newcitation' => $newcitation,
            'citations' => $citations,
            'citation_classes' => $citation_classes,
            'authors' => $authors,
            'author_items' => $items
        ]);

    } // end action



    /**
     * Deletes an existing Articles model.
     * If deletion successful, the browser will redirect to 'index' page
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $this->findModel($id)->delete();

        return $this->redirect(['index']);

    } // end action



    /**
     * Finds the Articles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {

        if (($model = Articles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');

    } // end action

} // end class
