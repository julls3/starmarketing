<?php

/**
 * This is the model class for table "tbl_deligations".
 *
 * The followings are the available columns in table 'tbl_deligations':
 * @property integer $project
 * @property integer $user
 *
 * The followings are the available model relations:
 * @property TblUser $user0
 * @property TblProjects $project0
 */
class Deligations extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_deligations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project, user', 'required'),
			array('project, user', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('project, user', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user0' => array(self::BELONGS_TO, 'TblUser', 'user'),
			'project0' => array(self::BELONGS_TO, 'TblProjects', 'project'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'project' => 'Project',
			'user' => 'User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('project',$this->project);
		$criteria->compare('user',$this->user);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Deligations the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * Функция возвращает массив менеджеров, прикрепленных к сайту
         * 
         * @param integer $id - идентификатор проекта
         * @return array $managers - список менеджеров по проекту
         */
        public static function get_managers($id){
            $managers = array();
            $c = array(
                'condition' => "project = $id" 
            );
            $users = self::model()->findAll($c);
            if(!empty($users)){
                foreach ($users as $u){
                     $c = array(
                        'condition' => "id = $u->user" 
                     );
                     $manager = Users::model()->find($c);
                     if($manager->role == 'manager'){
                         $managers[]  = $manager;
                     }
                }
                return $managers;
            }
            
        }
        
        /**
         * Функция возвращает массив мастеров, прикрепленных к сайту
         * 
         * @param integer $id - идентификатор проекта
         * @return array $managers - список мастеров по проекту
         */
        public static function get_masters($id){
            $managers = array();
            $c = array(
                'condition' => "project = $id" 
            );
            $users = self::model()->findAll($c);
            if(!empty($users)){
                foreach ($users as $u){
                     $c = array(
                        'condition' => "id = $u->user" 
                     );
                     $manager = Users::model()->find($c);
                     if($manager->role == 'master'){
                         $managers[]  = $manager;
                     }
                }
                return $managers;
            }
            
        }
        
        /**
         * Функция возвращает массив мастеров, прикрепленных к сайту
         * 
         * @param integer $id - идентификатор проекта
         * @return array $managers - список мастеров по проекту
         */
        public static function get_users($id){
            $managers = array();
            $c = array(
                'condition' => "project = $id" 
            );
            $users = self::model()->findAll($c);
            if(!empty($users)){
                foreach ($users as $u){
                     $c = array(
                        'condition' => "id = $u->user" 
                     );
                     $manager = Users::model()->find($c);
                     if($manager->role == 'user'){
                         $managers[]  = $manager;
                     }
                }
                return $managers;
            }
            
        }
        
        
         /**
         * Функция возвращает массив пользователей, прикрепленных к сайту
         * 
         * @param integer $id - идентификатор проекта
         * @return array $deligations - список менеджеров по проекту
         */
        public static function get_all($id){
            $deligations = array();
            $c = array(
                'condition' => "project = $id" 
            );
            $users = self::model()->findAll($c);
            if(!empty($users)){
                foreach ($users as $u){
                     $c = array(
                        'condition' => "id = $u->user" 
                     );
                     $manager = Users::model()->find($c);
                     $deligations[] = $manager;
                }
                return $deligations;
            }
            
        }
        
        /**
         * Делегирование пользователя к проекту
         * 
         */
        
        public static function add_new($project,$user){
            $d = new Deligations();
            $d->project = $project;
            $d->user = $user;
            $d->save();
            return $d;
        }
        
        
        /**
         * Удаление делигаций по проекту
         * 
         */
        
        public static function delete_by_project($project){
            self::model()->deleteAll("project = $project");
        }
}
