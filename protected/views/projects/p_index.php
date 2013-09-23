<?php
/* @var $this ProjectsController */

$this->breadcrumbs=array(
	'Проекты',
);
$this->menu=array(
	array('label'=>'Создать проект', 'url'=>array('create'),'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('addSite')),
	
	
);
?>
<h1>Список проектов</h1>

<?php if($projects): ?>
    <?php foreach($projects as $project):?>
        <div class="project" >
            <a class="prj_title" href="/index.php/projects/view/<?php echo $project->id;?>"><?php echo $project->name;?></a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
<h1>Проекты отсутствуют</h1>
<?php endif; ?>
