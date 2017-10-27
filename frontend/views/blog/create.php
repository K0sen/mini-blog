<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Blog */
/* @var $upload frontend\models\UploadForm */

$this->title = 'Create Post';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'upload' => $upload
    ]) ?>

</div>
