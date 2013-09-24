<?php
/**
 * контроллер API. Предназначен для взаимодействия сервера с другими контроллерами 
 * средствами AJAX, а также для вызова служебных функций кроном (парсер выдачи, сбор данных GA Api)
 */

class ApiController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
        
    /*==========================================================================
     * Создание проекта
     * =========================================================================
     */
        public function actionPr_create(){
            if(!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('addSite')){
                $pname = $_POST['pname'];
                $ganame = $_POST['ganame'];
                $urlname = $_POST['urlname'];
                if($pname && $ganame && $urlname){
                    $p = Projects::create_project($pname,$ganame,$urlname);
                    echo $p->id;
                }
            }else{
                // выгоняем пользователей, у которых нет прав просмотра 
                echo 'You dont have permissions';
                header('Location: '.$_SERVER['SERVER_NAME']);
                exit;
            }
        }
        
    /**
     *   Делегирование пользователей к проекту
     */
         public function actionDelegate_users(){
             if(!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('addSite')){
                $users = $_POST['users'];
                $project = $_POST['project'];
                if($project && $users){
                    $arr = explode(';',$users);
                    Deligations::delete_by_project($project);
                    foreach($arr as $user){
                        Deligations::add_new($project,$user);
                    }
                }
            }else{
                // выгоняем пользователей, у которых нет прав просмотра 
               
                header('Location: http://'.$_SERVER['SERVER_NAME'].'/');
                exit;
            }
         }
         
         
         /**********************************************************************
          *
          **                     ПАРСЕРЪ
          *                 
         \*********************************************************************/
         public function actionParser($password){
             if($password !== 'starmarketing'){
                exit;
             }
             header("Connection: Keep-Alive"); 
             header("Keep-Alive: timeout=3000");
             set_time_limit (0);
             //выборка всех ключевых слов из бд
             $kws = SeoKeywords::get_all();
             
             
             for($i=0;$i<=150;$i++){
                //SeoPositions::parse($kws[$i]);
                sleep(mt_rand(10,20));
                echo $i;
             }
             
             
         }
         
         
         /**********************************************************************
          *          Делигирование услуг к проекту
          *********************************************************************/
         
         public function actionDeligate_services(){
             if(!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('addSite')){
                   $selected = $_POST['selected'];
                   $project = $_POST['project'];
                   if($selected){
                       $sArray = explode('--',$selected);
                       $services = array();
                       foreach($sArray as $s){
                           $tmp = explode(';',$s);
                           $services[] = array('sid'=>$tmp[0],'budget'=>$tmp[1]);
                       }
                       ServiceDeligations::delete_current($project);
                       foreach($services as $service){
                           ServiceDeligations::add_new($project,$service['sid'],$service['budget']);
                       }
                       echo 'ok';
                       
                   }
                
            }else{
                // выгоняем пользователей, у которых нет прав просмотра 
               
                header('Location: http://'.$_SERVER['SERVER_NAME'].'/');
                exit;
            }
         }
         
         /**
          * Добавление ключевого слова к проекту
          */
         public function actionAdd_kws(){
            if(!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('addSite')){
                $kws = $_POST['keyword'];
                $regs = $_POST['regions'];
                $regions = explode(';',$regs);
                $project = $_POST['project'];
                $target = $_POST['target'];
                $se = $_POST['se'];
                $keywords = explode("\n",$kws);
                foreach($keywords as $kw){
                    if($kw){
                      $k =  SeoKeywords::add_new($project,$se,$target,$kw);
                      foreach($regions as $r){
                          if($r){
                              RegionDeligations::add_new($k->id, $r);
                          }
                      }
                    }
                }
                
            }else{
                // выгоняем пользователей, у которых нет прав просмотра 
                header('Location: http://'.$_SERVER['SERVER_NAME'].'/');
                exit;
            }
         }
         
         
         /**
          * Удаление ключевых слов
          */
         public function actionDelete_kws(){
            if(!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('addSite')){
                $project = $_POST['project'];
                $kws = $_POST['selected'];
                $keywords=explode(';',$kws);
                if($keywords){
                    foreach ($keywords as $k){
                        if($k){
                            RegionDeligations::delete_deligations($k);
                            SeoKeywords::delete_by_id($k);
                        }
                    }
                }
                
            }else{
                // выгоняем пользователей, у которых нет прав просмотра 
                header('Location: http://'.$_SERVER['SERVER_NAME'].'/');
                exit;
            }  
         }
         
         
         public function actionGareports(){
            $model=new GaReports;

            // uncomment the following code to enable ajax-based validation
            /*
            if(isset($_POST['ajax']) && $_POST['ajax']==='ga-reports-gareports-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            */

            if(isset($_POST['GaReports']))
            {
                $model->attributes=$_POST['GaReports'];
                if($model->validate())
                {
                    // form inputs are valid, do something here
                    return;
                }
            }
            $this->render('gareports',array('model'=>$model));
        }
         
}

function oloo(){
    return true;
}