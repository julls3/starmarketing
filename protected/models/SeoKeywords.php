<?php

/**
 * This is the model class for table "seo_kws".
 *
 * The followings are the available columns in table 'seo_kws':
 * @property integer $id
 * @property integer $pid
 * @property string $kw
 * @property integer $se
 * @property integer $target
 */
class SeoKeywords extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'seo_kws';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pid, kw, target', 'required'),
			array('pid, se, target', 'numerical', 'integerOnly'=>true),
			array('kw', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pid, kw, se, target', 'safe', 'on'=>'search'),
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
			'pid' => 'project id',
			'kw' => 'Keyword',
			'se' => 'Search Engine (1 - 3)',
			'target' => 'TOP X target ',
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
		$criteria->compare('pid',$this->pid);
		$criteria->compare('kw',$this->kw,true);
		$criteria->compare('se',$this->se);
		$criteria->compare('target',$this->target);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeoKeywords the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * Добавление ключевого слова
         * 
         * @param $project - идентификатор проекта
         * @param $se - маска поисковой машины 
              // google.com.ua = 1
              // google.ru  = 2
              // googleua + googleru = 3
              // yandex = 4
              // yandex + googleua = 5
              // yandex + googleru = 6
              // all = 7
         * @param $target - цель (топ10 топ 20, топ50 ...)
         * @param $kw - ключевое слово
         * 
         * @return $keyword - только что созданный ключевик
         */
        public static function add_new($project,$se,$target,$kw){
           // проверяем, нет ли такого слова в базе данных
           $q = self::model()->findByAttributes(array(
               'kw'=>array($kw),
               'pid'=>array($project)
           ));
           if(!$q){
               $keyword = new SeoKeywords();
               $keyword->kw = $kw;
               $keyword->pid = $project;
               $keyword->se = $se;
               $keyword->target = $target;
               $keyword->save();
               return $keyword;
           }else{
               return $q;
           }
            
        }
        
        
        /**
         * Достаем ключевые слова, прикрепленные к проекту
         * @param $id - идентификатор проекта
         */
        public static function get_by_project($id){
            $tmp = array();
            $prs = self::model()->findAllByAttributes(array(
                'pid'=>array($id)
            ));
            //Достаем регионы, к которым привязано каждое ключевое слово
            foreach ($prs as $pr){
                $regions = array();
                $dels = RegionDeligations::get_by_kw($pr->id);
                if($dels){
                   foreach($dels as $d){
                     $regions[] = Regions::get_by_id($d->regid);
                   } 
                }
                $tmp[] = array('kw'=>$pr, 'regions' =>$regions);
                
            }
            return $tmp;
        }
        
        
        /**
         * Удаление ключевого слова по идентификатору
         * 
         * @param $k - идентификатор ключевого слова
         */
        public static function delete_by_id($k){
            self::model()->deleteAllByAttributes(array(
                'id'=>$k
            ));
        }
        
        /**
         * Получение всех ключевых слов из бд
         * 
         */
        public static function get_all(){
            return self::model()->findAll();
        }
        
        
}
