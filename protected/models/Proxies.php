<?php

/**
 * This is the model class for table "proxies".
 *
 * The followings are the available columns in table 'proxies':
 * @property integer $id
 * @property string $ip
 * @property string $port
 * @property integer $status
 */
class Proxies extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'proxies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ip, port, status', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('ip', 'length', 'max'=>40),
			array('port', 'length', 'max'=>8),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ip, port, status', 'safe', 'on'=>'search'),
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
			'ip' => 'Ip',
			'port' => 'Port',
			'status' => '1-normal, 2 - was dead 3- was dead twice ... 9 - must die',
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
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('port',$this->port,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Proxies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * получаем список всех  прокси
         */
        public static function get_all(){
            return self::model()->findAll();
        }
        
        
        /**
         * Получение рабочего проксика
         * 
         */
        
        public static function get_new(){
            $proxies = self::model()->findAll();
            for($i=0;$i<=count($proxies);$i++){
                if($proxies[$i]->status == 11){
                    $proxies[$i]->status = 1;
                    $proxies[$i]->save();
                    $proxies[$i+1]->status = 11;
                    $proxies[$i+1]->save();
                    return $proxies[$i+1];
                    
                }
            }
        }
}
