<?php
/* @var $this GaReportsController */
/* @var $model GaReports */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ga-reports-gareports-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'kwid'); ?>
		<?php echo $form->textField($model,'kwid'); ?>
		<?php echo $form->error($model,'kwid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'exact_traff'); ?>
		<?php echo $form->textField($model,'exact_traff'); ?>
		<?php echo $form->error($model,'exact_traff'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'broad_traff'); ?>
		<?php echo $form->textField($model,'broad_traff'); ?>
		<?php echo $form->error($model,'broad_traff'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->