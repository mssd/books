<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\data\Pagination;

use app\models\Book;
use app\models\BookSearch;
use app\models\Author;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'controllers' => ['book'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $aAuthor = ArrayHelper::map(Author::find()->all(), 'id', function($model, $defaultValue) {
            return $model->lastname.' '.$model->firstname;
        });

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'aAuthor' => $aAuthor,
            'queryParams' => Yii::$app->request->queryParams,
        ]);
    }

    /**
    * Просмотр книги
    */
    public function actionAjaxview()
    {
        if (isset($_POST['id'])) {
            echo $this->renderPartial('view', [
                'oBook' => $this->findModel($_POST['id']),
            ]);
        }
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {  
        $oBook = new Book();
        $oBook->date_release = date('d.m.Y');
        $sRef = 'index';

        $aAuthor = ArrayHelper::map(Author::find()->all(), 'id', function($model, $defaultValue) {
            return $model->lastname.' '.$model->firstname;
        });

        if ($oBook->load(Yii::$app->request->post())) {
            $oBook->preview = UploadedFile::getInstance($oBook, 'preview');

            $oBook->date_release = date('Y-m-d', strtotime($oBook->date_release));

            if($oBook->save())
            {
                $oBook->preview->saveAs('uploads/' . $oBook->preview->name);

                return $this->redirect(['index']);
            }
        }  

        return $this->render('create', [
            'oBook' => $oBook,
            'aAuthor' => $aAuthor,
            'sRef' => $sRef,
        ]);        
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $sRef = isset($_POST['referrer']) ? $_POST['referrer'] : Yii::$app->request->referrer;
        $oBook = $this->findModel($id);

        $aAuthor = ArrayHelper::map(Author::find()->all(), 'id', function($model, $defaultValue) {
            return $model->lastname.' '.$model->firstname;
        });

        if ($oBook->load(Yii::$app->request->post())) {
            $oBook->preview = UploadedFile::getInstance($oBook, 'preview');

            $oBook->date_release = date('Y-m-d', strtotime($oBook->date_release));

            if($oBook->save())
            {                
                $oBook->preview->saveAs('uploads/' . $oBook->preview->name);
                
                return $this->redirect($sRef);
            }
        }   
       
        return $this->render('update', [
            'oBook' => $oBook,
            'aAuthor' => $aAuthor,
            'sRef' => $sRef,
        ]);        
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($oBook = Book::findOne($id)) !== null) {
            return $oBook;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
