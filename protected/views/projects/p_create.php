<?php
 // интерфейс создания проекта
    /*
     * Создаем проект с базовыми данными, без делегирования дополнительной информации
     */
?>
<?php
/* @var $this ProjectsController */

$this->breadcrumbs=array(
	'Проекты','Создать проект'
);
$this->menu=array(
	//array('label'=>'Создать проект', 'url'=>array('create'),'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('addSite')),
	array('label'=>'Все проекты', 'url'=>array('index'),'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('addSite')),
	
);
?>
<h1>Создать проект</h1>
<form>
  <label>Название проекта</label><br/>
  <input type="text" id="pname" placeholder="255 символов - макс" size="100" /><br/> 
  <label>Аккаунт GA</label><br/>
  <input type="text" id="ganame" placeholder="examle100500" size="100" /><br/>
  <label>Ссылка на сайт</label><br/>
  <input type="text" id="urlname" placeholder="http://" size="100" /><br/> 
  <input type="button"  style="margin-top:20px;" id="bcreate" value="Создать проект" />
</form>

