<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array('');


    public $selectedMenu = '';

    /***
     * @var bool Do we need to check the merchant profile
     */
    public $renderMerchantNotice = true;

    public function init()
    {
        $user = Yii::app()->user;

        if($user->isGuest) $this->renderMerchantNotice = false;

        if(!$user->isGuest && isset($user->merchantCompleted) && $user->merchantCompleted)
            $this->renderMerchantNotice = false;

    }

    public function setFlash($messageType, $message)
    {
        return Yii::app()->user->setFlash($messageType, $message);
    }


//    public function render($view,$data=null,$return=false)
//    {
//        if($this->renderMerchantNotice){
//
//            $cs = Yii::app()->clientScript;
//            $cs->registerScript('my_script', "jQuery('#myModal').modal({'show':true});", CClientScript::POS_READY);
//
//        }
//        parent::render($view, $data, $return);
//    }
}