<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />




	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <script type="text/javascript"
            src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCaCpSc7PTHh-q_qFcuarCbKlTGHYQ76q0&sensor=false">
    </script>

	<?php Yii::app()->bootstrap->register(); ?>
    <!--cript src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script-->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/datepicker.css" />
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
</head>

<body>

<?php
    $this->widget('bootstrap.widgets.TbNavbar',array(
        'items'=>array(
            array(
                'class'=>'bootstrap.widgets.TbMenu',
                'items'=>array(
                    array('label'=>'首页', 'url'=>array('/index/index')),
                    array('label'=>'关于我们', 'url'=>array('/index/about')),
                    array('label'=>'联系我们', 'url'=>array('/index/contact')),
                    array('label'=>'登录', 'url'=>array('/account/login'), 'visible'=>Yii::app()->user->isGuest),
                    array('label'=>'商家账户', 'url'=>array('/account/index'), 'visible'=>!Yii::app()->user->isGuest),
                    array('label'=>'退出 ('.Yii::app()->user->name.')', 'url'=>array('/account/logout'), 'visible'=>!Yii::app()->user->isGuest)
                ),
            ),
        ),
    ));
?>

<div class="container" id="page">

	<?php if(!(Yii::app()->controller->id == 'index' && Yii::app()->controller->action->id == 'index')):?>
    <?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif ?>
    <?php endif ?>

    <?php
        $this->widget('bootstrap.widgets.TbAlert', array(
            'block'=>true, // display a larger alert block?
            'fade'=>true, // use transitions?
            'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
            'alerts'=>array( // configurations per alert type
                'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
                'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
                'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
                'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
            ),
        ));
    ?>

	<?php echo $content; ?>

	<div class="clear"></div>



</div><!-- page -->

<div id="footer">
    <div id="content">

    Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
    All Rights Reserved.<br/>
    <?php echo Yii::powered(); ?>

    </div>
</div><!-- footer -->

</body>
</html>
