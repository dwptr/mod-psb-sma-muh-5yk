<?php
/**
 * Psb Registers (psb-registers)
 * @var $this AdminController
 * @var $model PsbRegisters
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 28 April 2016, 10:52 WIB
 * @link https://github.com/ommu/PSB
 *
 */

	$this->breadcrumbs=array(
		'Psb Registers'=>array('manage'),
		$model->register_id,
	);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'register_id',
			'value'=>$model->register_id,
		),
		array(
			'name'=>'author_id',
			'value'=>$model->author_id != 0 ? $model->author->name : '-',
		),
		/*
		array(
			'name'=>'status',
			'value'=>$model->status == '1' ? CHtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : CHtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
			//'value'=>$model->status,
		),
		*/
		array(
			'name'=>'nisn',
			'value'=>$model->nisn != '' ? $model->nisn : '-',
		),
		array(
			'name'=>Yii::t('phrase', 'Year'),
			'value'=>$model->batch_id != 0 ? $model->batch_relation->year->years : '-',
		),
		array(
			'name'=>'batch_id',
			'value'=>$model->batch_id != 0 ? $model->batch_relation->batch_name : '-',
		),
		array(
			'name'=>'register_name',
			'value'=>$model->register_name != '' ? $model->register_name : '-',
		),
		array(
			'name'=>'birth_city',
			'value'=>$model->birth_city != 0 ? $model->city_relation->city : '-',
		),
		array(
			'name'=>'birth_date',
			'value'=>!in_array($model->birth_date, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30')) ? $this->dateFormat($model->birth_date, 'full', false) : '-',
		),
		array(
			'name'=>'gender',
			'value'=>$model->gender == 'male' ? Yii::t('phrase', 'Laki-laki') : Yii::t('phrase', 'Perempuan'),
		),
		array(
			'name'=>'religion',
			'value'=>Phrase::trans($model->religion_relation->religion_name, 2),
		),
		array(
			'name'=>'address',
			'value'=>$model->address != '' ? $model->address : '-',
		),
		array(
			'name'=>'register_phone',
			'value'=>$model->register_phone != '' ? $model->register_phone : '-',
		),
		array(
			'name'=>'parent_phone',
			'value'=>$model->parent_phone != '' ? $model->parent_phone : '-',
		),
		array(
			'name'=>'register_request',
			'value'=>$model->register_request == 'ipa' ? Yii::t('phrase', 'IPA') : Yii::t('phrase', 'IPS'),
		),
		array(
			'name'=>'school_id',
			'value'=>PsbSchools::getDetailSchool($model->school_id),
			'type'=>'raw',
		),
		array(
			'name'=>'school_un_detail',
			'value'=>PsbRegisters::getUNDetail($model->school_un_detail, $model->batch_relation->batch_valuation),
			'type'=>'raw',
		),
		array(
			'name'=>'school_un_rank',
			'value'=>PsbRegisters::getDetailCourse(unserialize($model->school_un_rank)),
			'type'=>'raw',
		),
		array(
			'name'=>'school_un_average',
			'value'=>$model->school_un_average,
		),
		array(
			'name'=>'creation_date',
			'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? $this->dateFormat($model->creation_date) : '-',
		),
		array(
			'name'=>'creation_search',
			'value'=>$model->creation_id != 0 ? $model->creation->displayname : '-',
		),
	),
)); ?>