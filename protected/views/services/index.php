<?php
/* @var $this ServicesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Services',
);

$this->menu=array(
	array('label'=>'Создать услугу', 'url'=>array('create')),
	array('label'=>'Управление услугами', 'url'=>array('admin')),
);
?>

<h1>Services</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
