<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-10-12
 * Time: PM2:20
 * To change this template use File | Settings | File Templates.
 */
class MailApi
{
    const MAIL_TEMPLATE_RESETPASSWORD = 'ResetPassword';

//    protected $supportParams = array(
//        MAIL_TEMPLATE_RESETPASSWORD     =>      array('name','link','email')
//    );


    protected function getTemplateId($type)
    {
        switch($type){
            case self::MAIL_TEMPLATE_RESETPASSWORD:
                break;
            default:
                return false;
                break;
        }

        return $type;
    }




    /***
     * Send email, save into cron or send on the fly
     *
     * @param $type
     * @param array $data
     * @return bool|mixed
     * @throws Exception
     */
    public function send($type, array $data)
    {
        $templateId = $this->getTemplateId($type);
        if(empty($templateId)) throw new Exception('Template not found!');

        $className = $templateId;
        Yii::import('application.models.mail.templates.*');
        Yii::import('application.models.mail.MailBase');

        if(!class_exists($className)){
            throw new Exception('template class ' .$className .' not found!');
        }
        $mail = new $className($data);

        if($mail->validate()){
            return MailBase::addMail($mail->toParams());
        }


        return false;
    }

}
