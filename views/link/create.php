<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\shorts\models\Link $model */

$this->title = 'Create Short Link';
$this->params['breadcrumbs'][] = ['label' => 'Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
