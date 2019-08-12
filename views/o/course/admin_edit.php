<?php
/**
 * Psb Courses (psb-courses)
 * @var $this CourseController
 * @var $model PsbCourses
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/PSB
 *
 */

	$this->breadcrumbs=array(
		'Psb Courses'=>array('manage'),
		$model->course_id=>array('view','id'=>$model->course_id),
		Yii::t('phrase', 'Update'),
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>