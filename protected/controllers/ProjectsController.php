<?php

class ProjectsController extends Controller
{       
        public $layout='//layouts/column2';
        
	public function actionIndex()
	{
                // подготовка данных
                $projects = Projects::get_user_projects(Yii::app()->user->id);
                
                //content
                $content = array();
                $content['projects'] = $projects;
                //rendering view
		$this->render('p_index',$content);
	}
        
        public function actionAdmin()
	{
                
           if(!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('addSite')){
                 // подготовка данных
                $projects = Projects::get_all_projects();
                
                //content
                $content = array();
                $content['projects'] = $projects;
                //rendering view
		$this->render('p_index',$content);
            }else{
                // выгоняем пользователей, у которых нет прав просмотра 
                echo 'You dont have permissions';
                header('Location: '.$_SERVER['SERVER_NAME']);
                exit;
            }

	}

	
        public function actionView($id){
            $project = Projects::get_project($id);
            if(!$project){
                // если в параметре задан неверный id
                throw new CHttpException(404,'Такого проекта не существует');
            }
            $dmanagers = Deligations::get_managers($id);
            $dmasters = Deligations::get_masters($id);
            $dusers = Deligations::get_users($id);
            $deligations = Deligations::get_all($id);
            $mgrs = Users::get_all_managers();
            $masters = Users::get_all_masters();
            $users = Users::get_all_users();
            $services = Services::get_all();
            $dservices = Services::get_deligated($id);
            $regions = Regions::get_all();
            $dkeywords = SeoKeywords::get_by_project($id);
            // content
            $content = array();
            $content['mgrs'] = $mgrs;
            $content['dkws'] = $dkeywords;
            $content['masters'] = $masters;
            $content['services'] = $services;
            $content['dservices'] = $dservices;
            $content['regions'] = $regions;
            $content['users'] = $users;
            $content['project'] = $project;
            $content['deligations'] = $deligations;
            $content['dmanagers'] = $dmanagers;
            $content['dmasters'] = $dmasters;
            $content['dusers'] = $dusers;
            $this->render('p_view',$content);
        }
        
        /**
         * Страница создания проекта
         * Подключает шаблон p_create (/views/projects/p_create.php)
         * http:  /index.php/projects/create
         */
        public function actionCreate(){
            // проверяем права на создание проекта
            if(!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('addSite')){
                $content = array();
                $this->render('p_create',$content);
            }else{
                // выгоняем пользователей, у которых нет прав просмотра 
                echo 'You dont have permissions';
                header('Location: '.$_SERVER['SERVER_NAME']);
                exit;
            }
        }
}