<?php
/**
 * Created by PhpStorm.
 * User: Grog
 * Date: 26.10.2017
 * Time: 22:21
 */

namespace frontend\controllers;

use Yii;
use frontend\models\Comments;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Controller;


class CommentController extends Controller
{
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['send', 'update', 'delete'],
//                'rules' => [
//                    [
//                        'actions' => ['send'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                    [
//                        'actions' => ['update', 'delete'],
//                        'allow' => true,
//                        'matchCallback' => function ($rule, $action) {
//                            $creator = $this->findModel(Yii::$app->request->get('id'))['user_id'];
//                            $current_user = isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : null;
//                            return $creator == $current_user;
//                        }
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
//    }

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

}