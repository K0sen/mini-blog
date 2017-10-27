<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Blog;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use frontend\models\UploadForm;
use yii\data\Pagination;
use common\models\User;
use frontend\models\Comments;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['update', 'delete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $creator = $this->findModel(Yii::$app->request->get('id'))['user_id'];
                            $current_user = isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : null;
                            return $creator == $current_user;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Blog models.
     * TODO DELETE
     * @return mixed
     */
//    public function actionIndex()
//    {
//        $searchModel = new BlogSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    public function actionIndex()
    {
        $query = Blog::find();
        $pagination = new Pagination([
            'defaultPageSize' => 7,
            'totalCount' => $query->count(),
        ]);
        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $comments_model = new Comments();
        $comments = $comments_model->findComments($posts);

        return $this->render('index', [
            'posts' => $posts,
            'comments' => $comments,
            'comments_model' => $comments_model,
            'pagination' => $pagination,
        ]);
    }

    public function actionBlogList($id)
    {
        $posts = Blog::find()->where(['user_id' => $id])->all();
        if (!$posts)
                throw new \yii\web\HttpException(404, 'No blog from the user found');
        $comments_model = new Comments();
        $comments = $comments_model->findComments($posts);

        return $this->render('blog-list', [
            'comments' => $comments,
            'comments_model' => $comments_model,
            'posts' => $posts,
        ]);
    }

    /**
     * Displays a single Blog model.
     * @param string $id
     * @return mixed
     */
    public function actionRead($id)
    {
        $post[] = $this->findModel($id);
        $comments_model = new Comments();
        $comments = $comments_model->findComments($post);

        return $this->render('read', [
            'comments' => $comments,
            'comments_model' => $comments_model,
            'post' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Blog();
        $model->user_id = Yii::$app->user->identity->getId();
        $upload = new UploadForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $upload->imageFile = UploadedFile::getInstance($upload, 'imageFile');
            if ($upload->imageFile && $upload->upload("uploads/pictures/"))
                $model->image = $upload->imageFile->baseName . "." . $upload->imageFile->extension;

            if ($model->save()) {
                return $this->redirect(['read', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'upload' => $upload
        ]);
    }

    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $upload = new UploadForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['read', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'upload' => $upload
            ]);
        }
    }

    /**
     * Deletes an existing Blog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('info', 'Post was deleted');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
