<?php
/* @var $this ServicesController */
/* @var $model Services */

$this->breadcrumbs=array(
	'Услуги'=>array('index'),
	'Создать услугу',
);

$this->menu=array(
	array('label'=>'Список услуг', 'url'=>array('index')),
	array('label'=>'Управление услугами', 'url'=>array('admin')),
);
?>

<h1>Создание услуг</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>