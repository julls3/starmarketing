<?php

/**
 * This is the model class for table "tbl_projects".
 *
 * The followings are the available columns in table 'tbl_projects':
 * @property integer $id
 * @property string $name
 * @property string $created
 * @property string $ga_account
 * @property string $is_active
 * @property string $url
 */
class Projects extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_projects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, created', 'required'),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, created', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'created' => 'Created',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('created',$this->created,true);
                $criteria->compare('url',$this->url,true);
                $criteria->compare('is_active',$this->is_active,true);
                $criteria->compare('ga_account',$this->ga_account,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Projects the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         *   Возвращает массив обьектов project, которые делегированы пользователю
         * 
         * @param $user_id - идентификатор пользователя
         * @return array $projects - массив обьектов "Проект" . 
         */
        public static function get_user_projects($user_id){
            $condition = array(
                'condition' => "user = $user_id"
            );
            $deligations = Deligations::model()->findAll($condition); // поиск в таблице Deligations
            if(!empty($deligations)){
                // search for ptojects
                $projects = array();
                foreach ($deligations as $d){
                    $condition = array(
                        'condition' => "id = $d->project"
                    );
                    $projects[] = self::model()->find($condition);
                }
                return $projects;
            }
        }
        
        
        /**
         * Функция получает проект по идентификатору
         * 
         * @param integer $id  -идентификатор проекта
         * @return object $r - проект
         */
        public static function get_project($id){
            $condition = array(
                'condition'  => "id = $id"
            );
            $r = self::model()->find($condition);
            return $r;
        }
        
        
        /**
         * Создает проект 
         * 
         * @param $name - имя проекта (255 символов -  макс)
         * @param $ga - аккаунт Гугл Аналитикс (255 символов -  макс)
         * @param $url - ссылка на сайт
         */
         public static function create_project($name,$ga,$url){
             $now = date("Y-m-d H:i:s");
             $p = new Projects();
             $p->name = $name;
             $p->created = $now;
             $p->is_active = 1;
             $p->ga_account = $ga;
             $p->url = $url;
             $p->save();
             return $p;
         }
         
         
         
         /**
          * Возвращает все проекты из базы данных
          * 
          */
         public function get_all_projects(){
             $p = self::model()->findAll();
             return $p;
         }
        
}
