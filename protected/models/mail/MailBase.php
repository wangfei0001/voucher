<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-10-12
 * Time: PM2:21
 * To change this template use File | Settings | File Templates.
 */
class MailBase
{
    const MAIL_STATUS_INIT      = 'init';

    const MAIL_STATUS_PENDING   = 'pending';

    const MAIL_STATUS_COMPLETED = 'completed';



    const MAIL_FORMAT_TYPE_EMAIL = 'email';

    const MAIL_FORMAT_TYPE_SMS   = 'sms';


    protected $data;

    protected $sender;

    protected $format;


    /***
     * @param Ums $ums
     */
    public function __construct(array $data)
    {
        $mustHave = array('id_ums','status','params');
        foreach($mustHave as $val){
            if(!isset($data[$val])) throw new Exception("data error");
        }
        $this->data = $data;
    }




    /***
     * Send sender and format type
     *
     * @param SenderInterface $sender
     */
    public function setSender(SenderInterface $sender)
    {
        $this->sender = $sender;
        if($sender instanceof EmailSender){
            $this->format = self::MAIL_FORMAT_TYPE_EMAIL;
        }else if($sender instanceof SMSSender){
            $this->format = self::MAIL_FORMAT_TYPE_SMS;
        }
    }


    public function generateContent()
    {
        parse_str($this->data['params'], $params);
        if($this->format == self::MAIL_FORMAT_TYPE_EMAIL){
            $className = $params['templateId'];

            unset($params['templateId']);


            Yii::import('application.models.mail.templates.*');

            $mail = new $className($params);

            return $mail->generateContent();

        }
    }

    public function send()
    {
        if($this->sender){

            $content = $this->generateContent();


            die($content);

            $this->sender->send();
        }else{
            throw new Exception('Sender not set');
        }
    }


    /***
     * Save a email
     *
     * @param array $data
     * @return mixed
     */
    public static function addMail($params)
    {
        $result = false;

        if(!empty($params)){
            $ums = new Ums();
            $ums->status = self::MAIL_STATUS_INIT;
            $ums->params = $params;

            $result = $ums->save();
            if($result) $result = $ums->id_ums;
        }
        return $result;
    }

}
