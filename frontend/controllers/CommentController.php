<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Comments;
use yii\web\Controller;


class CommentController extends Controller
{
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