<?php
/**
 * Psb Courses (psb-courses)
 * @var $this CourseController
 * @var $model PsbCourses
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/PSB
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Psb Courses'=>array('manage'),
		'Create',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>