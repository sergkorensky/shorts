<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = Yii::$app->name.' - Короткие ссылки';
?>
<div class="shorts-default-index">
<h1>Модуль создания коротких ссылок</h1>
    <h3><?= Html::a('Адреса URL',Url::toRoute('link/index')); ?></h3>
    <h3><?= Html::a('Статистика',Url::toRoute('log/index')); ?></h3>
	
</div>
