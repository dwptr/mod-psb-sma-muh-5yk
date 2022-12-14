<?php
/**
 * Psb Schools (psb-schools)
 * @var $this SchoolController
 * @var $model PsbSchools
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/PSB
 *
 */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('school_id'); ?><br/>
			<?php echo $form->textField($model,'school_id', array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('school_name'); ?><br/>
			<?php echo $form->textField($model,'school_name', array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('school_address'); ?><br/>
			<?php echo $form->textArea($model,'school_address', array('rows'=>6, 'cols'=>50)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('school_phone'); ?><br/>
			<?php echo $form->textField($model,'school_phone', array('size'=>15,'maxlength'=>15)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('school_status'); ?><br/>
			<?php echo $form->textField($model,'school_status', array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
