<?php

use yii\helpers\Html;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model frontend\models\Blog */
/* @var $upload frontend\models\UploadForm */

$username = User::findIdentity($model->user_id)->username;
$this->title = 'Update Blog: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => $username . ' Posts', 'url' => ['blog-list', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="blog-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'upload' => $upload
    ]) ?>

</div>
