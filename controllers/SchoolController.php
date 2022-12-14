<?php
/**
 * SchoolController
 * @var $this SchoolController
 * @var $model PsbSchools 
 * @var $form CActiveForm
 *
 * Reference start
 * TOC :
 *	Index
 *	Suggest
 *	AjaxGet
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/PSB
 *
 *----------------------------------------------------------------------------------------------------------
 */

class SchoolController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'index';

	/**
	 * Initialize admin page theme
	 */
	public function init() 
	{
		$arrThemes = $this->currentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
	}

	/**
	 * @return array action filters
	 */
	public function filters() 
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() 
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','suggest','ajaxget'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
				//'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level != 1)',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex() 
	{
		$this->redirect(Yii::app()->createUrl('site/index'));
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionSuggest($limit=15) 
	{
		if(Yii::app()->getRequest()->getParam('term')) {
			$criteria = new CDbCriteria;
			$criteria->condition = 'school_name LIKE :name';
			$criteria->select = "school_id, school_name";
			$criteria->limit = $limit;
			$criteria->order = "school_id ASC";
			$criteria->params = array(':name' => '%' . strtolower(Yii::app()->getRequest()->getParam('term')) . '%');
			$model = PsbSchools::model()->findAll($criteria);

			if($model) {
				foreach($model as $items) {
					$result[] = array('id' => $items->school_id, 'value' => $items->school_name);
				}
			}
		}
		echo CJSON::encode($result);
		Yii::app()->end();
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAjaxGet() 
	{
		if(isset($_POST['school_id'])) {
			$model=$this->loadModel($_POST['school_id']);
			echo CJSON::encode(array(
				'school_name' => $model->school_name,
				'school_address' => $model->school_address,
				'school_phone' => $model->school_phone,
				'school_status' => $model->school_status,
			));
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = PsbSchools::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) 
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='psb-schools-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
