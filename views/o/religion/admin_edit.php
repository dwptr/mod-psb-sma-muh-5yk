<?php
/**
 * Psb Religions (psb-religions)
 * @var $this ReligionController
 * @var $model PsbReligions
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 27 April 2016, 15:50 WIB
 * @link https://github.com/ommu/PSB
 *
 */

	$this->breadcrumbs=array(
		'Psb Religions'=>array('manage'),
		$model->religion_id=>array('view','id'=>$model->religion_id),
		Yii::t('phrase', 'Update'),
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>