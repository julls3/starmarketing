<?php

/**
 * This is the model class for table "region_deligations".
 *
 * The followings are the available columns in table 'region_deligations':
 * @property integer $id
 * @property integer $kwid
 * @property integer $regid
 */
class RegionDeligations extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'region_deligations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kwid, regid', 'required'),
			array('kwid, regid', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, kwid, regid', 'safe', 'on'=>'search'),
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
			'kwid' => 'id of keyword',
			'regid' => 'id of region',
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
		$criteria->compare('kwid',$this->kwid);
		$criteria->compare('regid',$this->regid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RegionDeligations the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Делегирование региона к ключевому слову
         * 
         * @param $kwid - идентификатор ключевого слова
         * @param $regid - идентификатор региона
         */
        public static function add_new($kwid,$regid){
            //проверяем, нет ли такого делегирования в базе данных
            $q = self::model()->findByAttributes(array(
                'kwid'=>array($kwid),
                'regid'=>array($regid)
            ));
            if(!$q){
                $del = new RegionDeligations();
                $del->kwid = $kwid;
                $del->regid = $regid;
                $del->save();
            }
        }
        
        /**
         * Достаем делегации по ключевому слову
         * 
         * @param $id - идентификатор ключевого слова
         */
        
        public function get_by_kw($id){
            $dels = self::model()->findAllByAttributes(array(
                'kwid' => array($id)
            ));
            return $dels;
        }
        
        /**
         * Удаление 
         * @param $k - идентификатор ключевого слова
         */
        
        public static function delete_deligations($k){
            self::model()->deleteAllByAttributes(array(
                'kwid'=>$k
            ));
        }
}
