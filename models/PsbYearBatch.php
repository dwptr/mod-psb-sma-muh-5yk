<?php
/**
 * PsbYearBatch
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
 * This is the model class for table "ommu_psb_year_batch".
 *
 * The followings are the available columns in table 'ommu_psb_year_batch':
 * @property string $batch_id
 * @property integer $publish
 * @property string $year_id
 * @property string $batch_name
 * @property string $batch_start
 * @property string $batch_finish
 * @property integer $batch_valuation
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property PsbRegisters[] $PsbRegisters
 * @property PsbYears $year
 */
class PsbYearBatch extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $year_search;
	public $creation_search;
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PsbYearBatch the static model class
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
		return 'ommu_psb_year_batch';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('year_id, publish, batch_name, batch_start, batch_finish, batch_valuation', 'required'),
			array('publish, batch_valuation', 'numerical', 'integerOnly'=>true),
			array('year_id, creation_id, modified_id', 'length', 'max'=>11),
			array('', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('batch_id, publish, year_id, batch_name, batch_start, batch_finish, batch_valuation, creation_date, creation_id, modified_date, modified_id,
				year_search, creation_search, modified_search', 'safe', 'on'=>'search'),
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
			'registers' => array(self::HAS_MANY, 'PsbRegisters', 'batch_id'),
			'year' => array(self::BELONGS_TO, 'PsbYears', 'year_id'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			'view' => array(self::BELONGS_TO, 'ViewPsbYearBatch', 'batch_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'batch_id' => Yii::t('attribute', 'Batch'),
            'publish' => Yii::t('attribute', 'Publish'),
            'year_id' => Yii::t('attribute', 'Year'),
            'batch_name' => Yii::t('attribute', 'Batch Name'),
            'batch_start' => Yii::t('attribute', 'Batch Start'),
            'batch_finish' => Yii::t('attribute', 'Batch Finish'),
            'batch_valuation' => Yii::t('attribute', 'Batch Valuation'),
            'creation_date' => Yii::t('attribute', 'Creation Date'),
            'creation_id' => Yii::t('attribute', 'Creation'),
            'modified_date' => Yii::t('attribute', 'Modified Date'),
            'modified_id' => Yii::t('attribute', 'Modified'),
            'creation_search' => Yii::t('attribute', 'Creation'),
            'modified_search' => Yii::t('attribute', 'Modified'),
            'year_search' => Yii::t('attribute', 'Year'),
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
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);

		$criteria=new CDbCriteria;

		$criteria->compare('t.batch_id', $this->batch_id,true);
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
		if(Yii::app()->getRequest()->getParam('year'))
			$criteria->compare('t.year_id', Yii::app()->getRequest()->getParam('year'));
		else {
			if($currentAction == 'o/year/edit' && Yii::app()->getRequest()->getParam('id'))
				$criteria->compare('t.year_id', Yii::app()->getRequest()->getParam('id'));
			else				
				$criteria->compare('t.year_id', $this->year_id);
		}
		$criteria->compare('t.batch_name', $this->batch_name,true);
		if($this->batch_start != null && !in_array($this->batch_start, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.batch_start)', date('Y-m-d', strtotime($this->batch_start)));
		if($this->batch_finish != null && !in_array($this->batch_finish, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.batch_finish)', date('Y-m-d', strtotime($this->batch_finish)));
		$criteria->compare('t.batch_valuation', $this->batch_valuation);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.creation_date)', date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_id', $this->creation_id,true);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.modified_date)', date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id', $this->modified_id,true);
		
		// Custom Search
		$criteria->with = array(
			'year' => array(
				'alias' => 'year',
				'select' => 'years'
			),
			'creation' => array(
				'alias' => 'creation',
				'select' => 'displayname'
			),
			'modified' => array(
				'alias' => 'modified',
				'select' => 'displayname'
			),
		);
		$criteria->compare('year.years', strtolower($this->year_search), true);
		$criteria->compare('creation.displayname', strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname', strtolower($this->modified_search), true);

		if(!Yii::app()->getRequest()->getParam('PsbYearBatch_sort') && $currentAction != 'year/edit')
			$criteria->order = 'batch_id DESC';

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
			//$this->defaultColumns[] = 'batch_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'year_id';
			$this->defaultColumns[] = 'batch_name';
			$this->defaultColumns[] = 'batch_start';
			$this->defaultColumns[] = 'batch_finish';
			$this->defaultColumns[] = 'batch_valuation';
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
			/*
			$this->defaultColumns[] = array(
				'class' => 'CCheckBoxColumn',
				'name' => 'id',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'trash_id[]')
			);
			*/
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			$this->defaultColumns[] = array(
				'name' => 'year_search',
				'value' => '$data->year->years',
			);
			$this->defaultColumns[] = array(
				'name' => 'batch_name',
				'value' => '$data->batch_name',
			);
			$this->defaultColumns[] = array(
				'name' => 'batch_start',
				'value' => 'Yii::app()->dateFormatter->formatDateTime(\$data->batch_start, \'medium\', false)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterDatepicker($this, 'batch_start'),
			);
			$this->defaultColumns[] = array(
				'name' => 'batch_finish',
				'value' => 'Yii::app()->dateFormatter->formatDateTime($data->batch_finish, \'medium\', false)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterDatepicker($this, 'batch_finish'),
			);
			$this->defaultColumns[] = array(
				'header' => 'registers',
				'value' => 'CHtml::link($data->view->registers, Yii::app()->controller->createUrl(\'o/admin/manage\', array("batch"=>$data->batch_id)))',
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
			$this->defaultColumns[] = array(
				'name' => 'batch_valuation',
				'value' => '$data->batch_valuation == 1 ? Yii::t("phrase", "Ujian Nasional") : Yii::t("phrase", "Raport")',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' =>array(
					1=>Yii::t('phrase', 'Ujian Nasional'),
					0=>Yii::t('phrase', 'Raport'),
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'header' => Yii::t('phrase', 'Recap'),
				'value' => 'CHtml::link(Yii::t("phrase", "Recap"), Yii::app()->controller->createUrl("o/admin/recap", array("id"=>$data->batch_id,"type"=>"batch")))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			if(!Yii::app()->getRequest()->getParam('type')) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'publish\', array(\'id\'=>$data->batch_id)), $data->publish, 1)',
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
	 * Get Years
	 */
	public static function getBatch($publish=null, $array=true) 
	{		
		$criteria=new CDbCriteria;
		if($publish != null)
			$criteria->compare('publish',$publish);
		$criteria->order = 'year_id ASC, batch_start ASC';
		$model = self::model()->findAll($criteria);

		if($array == true) {
			$items = array();
			if($model != null) {
				foreach($model as $key => $val)
					$items[$val->batch_id] = $val->batch_name.' '.$val->year->years;
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
			$this->batch_start = date('Y-m-d', strtotime($this->batch_start));
			$this->batch_finish = date('Y-m-d', strtotime($this->batch_finish));
			
			if($this->isNewRecord)
				$this->creation_id = Yii::app()->user->id;	
			else
				$this->modified_id = Yii::app()->user->id;
			
			if($this->batch_start >= $this->batch_finish)
				$this->addError('batch_finish', 'Batch Finish harus lebih besar dari Batch Start');
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$this->batch_start = date('Y-m-d', strtotime($this->batch_start));
			$this->batch_finish = date('Y-m-d', strtotime($this->batch_finish));
		}
		return true;
	}

}