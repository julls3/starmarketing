<?php

/**
 * This is the model class for table "service_deligations".
 *
 * The followings are the available columns in table 'service_deligations':
 * @property integer $id
 * @property integer $sid
 * @property integer $pid
 * @property string $budget
 */
class ServiceDeligations extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'service_deligations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sid, pid, budget', 'required'),
			array('sid, pid', 'numerical', 'integerOnly'=>true),
			array('budget', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sid, pid, budget', 'safe', 'on'=>'search'),
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
			'sid' => 'Sid',
			'pid' => 'Pid',
			'budget' => 'Budget',
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
		$criteria->compare('sid',$this->sid);
		$criteria->compare('pid',$this->pid);
		$criteria->compare('budget',$this->budget,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ServiceDeligations the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * проверяем, делегирована ли услуга проекту
         * 
         * @param $id - идентификатор услугни
         * @param $pid - идентификатор проекта
         * 
         * @return bool - нет, или бюджет услуги по проекту
         */
        public static function check($id,$pid){
            $r  = self::model()->findByAttributes(array('sid'=>array($id), 'pid'=>$pid));
            if($r){
                return $r->budget;
            }else{
                return false;
            }
        }
        
        /**
         * Добавление услуги к проекту с указанием бюджета
         * 
         * @param $project - идентификатор проекта
         * @param $sid - идентификатор услуги
         * @param string $budget - бюджет для данной услуги
         *
         * @return object $d - только что созданная делигация
         */
        
        public static function add_new($project,$sid,$budget){
              $d = new ServiceDeligations();
              $d->sid = $sid;
              $d->pid = $project;
              $d->budget = $budget;
              $d->save();
              return $d;
        }
        
        /**
         * Удаляет делигации для определенного проекта
         * 
         * @param $project - идентификатор проекта
         */
        public static function delete_current($project){
            self::model()->deleteAll("pid = $project");
            return true;
        }
}
