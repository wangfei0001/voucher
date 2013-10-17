<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-10-12
 * Time: PM2:26
 * To change this template use File | Settings | File Templates.
 */

Yii::import('application.models.Ums');

Yii::import('application.models.mail.*');


class SendMailsCommand extends CConsoleCommand
{


    public function actionIndex()
    {
        $criteria=new CDbCriteria;

        $criteria->order = 'created_at asc';
        $criteria->condition = 'status = "' .MailBase::MAIL_STATUS_INIT .'"';

        $rows = Ums::model()->findAll($criteria);

        foreach($rows as $row){
            $mail = new MailBase($row->attributes);
            $mail->setSender(new EmailSender());

            $mail->send();

        }

        die('done');
    }
}
