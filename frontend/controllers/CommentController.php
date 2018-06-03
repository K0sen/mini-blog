<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Comments;
use frontend\models\Blog;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;


class CommentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['send', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['send'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $allow_comments = Blog::findOne(Yii::$app->request->post('Comments')["blog_id"])['allow_comments'];
                            return !Yii::$app->user->isGuest && $allow_comments == 1;
                        }
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

    public function actionSend()
    {
        $model = new Comments();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->identity->id;
            if ($model->save())
                Yii::$app->session->setFlash('success', 'You send a comment');
        } else {
            Yii::$app->session->setFlash('error', 'Comment does not send');
        }

        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    public function actionForm()
    {
        $parent_id = Yii::$app->request->post('parent_id');
        $post_id = Yii::$app->request->post('post_id');

        $model = new Comments();

        return $this->renderPartial('send_form.php', [
            'parent_id' => $parent_id,
            'post_id' => $post_id,
            'comments_model' => $model
        ]);
    }

    /**
     * Finds the Comments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Comments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comments::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}