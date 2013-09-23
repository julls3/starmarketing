<?php
/* @var $this ServicesController */
/* @var $model Services */

$this->breadcrumbs=array(
	'Услуги'=>array('index'),
	$model->name,
);

$this->menu=array(
	
	array('label'=>'Создать услугу', 'url'=>array('create')),
	array('label'=>'Редактировать текущую', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить текущую', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление услугами', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
