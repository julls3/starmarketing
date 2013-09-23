<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<p>
    <?php
    
    
    if(!Yii::app()->user->isGuest){  
     echo 'Какая - нибудь информация. . . ';
    //echo Yii::app()->user->role;
    }else{
        echo '<h1>Пожалуйста, <a href="/index.php/site/login/" >Авторизуйтесь</a></h1>';
    }
    ?>
</p>
