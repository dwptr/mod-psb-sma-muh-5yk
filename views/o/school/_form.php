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

<?php $form=$this->beginWidget('application.libraries.yii-traits.system.OActiveForm', array(
	'id'=>'psb-schools-form',
	'enableAjaxValidation'=>true,
)); ?>
<div class="dialog-content">
	<fieldset>

		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages ?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'school_name'); ?>
			<div class="desc">
				<?php
				$model->school_name = $model->school_name;
				echo $form->textField($model,'school_name', array('maxlength'=>64, 'class'=>'span-8')); ?>
				<?php echo $form->error($model,'school_name'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'school_address'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'school_address', array('rows'=>6, 'cols'=>50, 'class'=>'span-11')); ?>
				<?php echo $form->error($model,'school_address'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'school_phone'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'school_phone', array('maxlength'=>15)); ?>
				<?php echo $form->error($model,'school_phone'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'school_status'); ?>
			<div class="desc">
				<?php echo $form->dropDownList($model,'school_status', array(
					1=>Yii::t('phrase', 'Negeri'),
					0=>Yii::t('phrase', 'Swasta'),
				)); ?>
				<?php echo $form->error($model,'school_status'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'publish'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'publish'); ?>
				<?php echo $form->labelEx($model,'publish'); ?>
				<?php echo $form->error($model,'publish'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') , array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>


