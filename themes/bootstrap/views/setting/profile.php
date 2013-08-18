<script type="text/javascript">
    var test = function(e) {
        console.log(e.target);
        //load ajax stuff here
        $('#content0, #content1').toggle();
    }
</script>
<?php $this->widget('bootstrap.widgets.TbTabs', array(
    'type'=>'tabs',
    'placement'=>'above', // 'above', 'right', 'below' or 'left'
    'tabs'=>array(
        array('label'=>'个人资料', 'content'=>'', 'active'=>true),
        array('label'=>'通知设置', 'content'=>''),
    ),
    'events'=>array('shown'=>'js:test')
)); ?>

<div id="content0">
<?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'verticalForm',
        'htmlOptions'=>array('class'=>'well'),
    ));
    ?>
    <fieldset>
        <!--legend>Legend</legend-->
        <?php echo $form->textFieldRow($model, 'username', array('readonly' => 'readonly')/*, array('hint'=>'In addition to freeform text, any HTML5 text-based input appears like so.')*/); ?>
        <?php echo $form->textFieldRow($model, 'password', array('class'=>'span3')); ?>
        <?php echo $form->textFieldRow($model, 'email', array('class'=>'span4')); ?>
        <?php echo $form->textFieldRow($model, 'fname'); ?>
        <?php echo $form->textFieldRow($model, 'lname'); ?>
        <?php echo $form->dropDownListRow($model, 'gender', $genders); ?>
        <?php echo $form->dropDownListRow($model, 'status', $status, array("disabled"=>"disabled")); ?>

    </fieldset>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'保存')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

<div id="content1" style="display: none;">

    Content 1

</div>