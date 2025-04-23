<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\shorts\models\Log $model */

$this->title = $model->link_id;
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="log-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'link_id' => $model->link_id, 'ip_id' => $model->ip_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'link_id' => $model->link_id, 'ip_id' => $model->ip_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'link_id',
            'ip_id',
            'count',
        ],
    ]) ?>

</div>
