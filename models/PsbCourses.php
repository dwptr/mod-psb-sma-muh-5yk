<?php
/**
 * PsbCourses
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/PSB
 *
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 *
 * --------------------------------------------------------------------------------------
 *
 * This is the model class for table "ommu_psb_courses".
 *
 * The followings are the available columns in table 'ommu_psb_courses':
 * @property string $course_id
 * @property integer $publish
 * @property integer $defaults
 * @property string $course_name
 * @property string $course_desc
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property PsbYearCourse[] $PsbYearCourses
 */
class PsbCourses extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $creation_search;
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PsbCourses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ommu_psb_courses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_name', 'required'),
			array('publish, defaults', 'numerical', 'integerOnly'=>true),
			array('course_name', 'length', 'max'=>32),
			array('creation_id', 'length', 'max'=>11),
			array('course_desc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('course_id, publish, defaults, course_name, course_desc, creation_date, creation_id, modified_date, modified_id,
				creation_search, modified_search', 'safe', 'on'=>'search'),
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
			'courses' => array(self::HAS_MANY, 'PsbYearCourse', 'course_id'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			'view' => array(self::BELONGS_TO, 'ViewPsbCourses', 'course_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'course_id' => Yii::t('attribute', 'Course'),
            'publish' => Yii::t('attribute', 'Publish'),
            'defaults' => Yii::t('attribute', 'Default'),
            'course_name' => Yii::t('attribute', 'Course Name'),
            'course_desc' => Yii::t('attribute', 'Course Desc'),
            'creation_date' => Yii::t('attribute', 'Creation Date'),
            'creation_id' => Yii::t('attribute', 'Creation'),
            'modified_date' => Yii::t('attribute', 'Modified Date'),
            'modified_id' => Yii::t('attribute', 'Modified'),
            'creation_search' => Yii::t('attribute', 'Creation'),
            'modified_search' => Yii::t('attribute', 'Modified'),
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

		$criteria->compare('t.course_id', $this->course_id,true);
		if(Yii::app()->getRequest()->getParam('type') == 'publish')
			$criteria->compare('t.publish', 1);
		elseif(Yii::app()->getRequest()->getParam('type') == 'unpublish')
			$criteria->compare('t.publish', 0);
		elseif(Yii::app()->getRequest()->getParam('type') == 'trash')
			$criteria->compare('t.publish', 2);
		else {
			$criteria->addInCondition('t.publish', array(0,1));
			$criteria->compare('t.publish', $this->publish);
		}
		$criteria->compare('t.defaults', $this->defaults);
		$criteria->compare('t.course_name', $this->course_name,true);
		$criteria->compare('t.course_desc', $this->course_desc,true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.creation_date)', date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_id', $this->creation_id,true);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.modified_date)', date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id', $this->modified_id,true);
		
		// Custom Search
		$criteria->with = array(
			'creation' => array(
				'alias' => 'creation',
				'select' => 'displayname'
			),
			'modified' => array(
				'alias' => 'modified',
				'select' => 'displayname'
			),
		);
		$criteria->compare('creation.displayname', strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname', strtolower($this->modified_search), true);

		if(!Yii::app()->getRequest()->getParam('PsbCourses_sort'))
			$criteria->order = 'course_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>30,
			),
		));
	}


	/**
	 * Get column for CGrid View
	 */
	public function getGridColumn($columns=null) {
		if($columns !== null) {
			foreach($columns as $val) {
				/*
				if(trim($val) == 'enabled') {
					$this->defaultColumns[] = array(
						'name'  => 'enabled',
						'value' => '$data->enabled == 1? "Ya": "Tidak"',
					);
				}
				*/
				$this->defaultColumns[] = $val;
			}
		} else {
			//$this->defaultColumns[] = 'course_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'defaults';
			$this->defaultColumns[] = 'course_name';
			$this->defaultColumns[] = 'course_desc';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_id';
			$this->defaultColumns[] = 'modified_date';
			$this->defaultColumns[] = 'modified_id';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			$this->defaultColumns[] = array(
				'name' => 'course_name',
				'value' => '$data->course_name',
			);
			$this->defaultColumns[] = 'course_desc';
			$this->defaultColumns[] = array(
				'header' => 'years',
				'value' => 'CHtml::link($data->view->years, Yii::app()->controller->createUrl("o/yearcourse/manage", array("course"=>$data->course_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_search',
				'value' => '$data->creation->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Yii::app()->dateFormatter->formatDateTime($data->creation_date, \'medium\', false)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterDatepicker($this, 'creation_date'),
			);
			if(!Yii::app()->getRequest()->getParam('type')) {
				$this->defaultColumns[] = array(
					'name' => 'defaults',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'default\', array(\'id\'=>$data->course_id)), $data->defaults, 1)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter' => $this->filterYesNo(),
					'type' => 'raw',
				);
			}
			if(!Yii::app()->getRequest()->getParam('type')) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'publish\', array(\'id\'=>$data->course_id)), $data->publish, 1)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter' => $this->filterYesNo(),
					'type' => 'raw',
				);
			}
		}
		parent::afterConstruct();
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::model()->findByPk($id, array(
				'select' => $column,
			));
 			if(count(explode(',', $column)) == 1)
 				return $model->$column;
 			else
 				return $model;
			
		} else {
			$model = self::model()->findByPk($id);
			return $model;
		}
	}

	/**
	 * User get information
	 */
	public static function getValue($id, $value=null)
	{
		$course = self::model()->findByPk($id, array(
			'select' => 'course_id, course_name',
		));
		$value = $value != null && $value != '' && $value != 0 ? $value : '-';
		
		return $course->course_name.': '.$value;
	}

	/**
	 * Get Years
	 */
	public static function getCourse($default=null, $type=null) 
	{		
		$criteria=new CDbCriteria;
		if($default != null)
			$criteria->compare('defaults',$default);
		$model = self::model()->findAll($criteria);

		if($array == true) {
			$items = array();
			if($model != null) {
				foreach($model as $key => $val)
					$items[$val->course_id] = $val->course_name;
				return $items;
				
			} else
				return false;
			
		} else
			return $model;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->isNewRecord)
				$this->creation_id = Yii::app()->user->id;
			else
				$this->modified_id = Yii::app()->user->id;				
		}
		return true;
	}

}