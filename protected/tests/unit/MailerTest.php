<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-10-12
 * Time: PM2:21
 * To change this template use File | Settings | File Templates.
 */
class MailerTest extends CDbTestCase
{

    public function setUp()
    {
        Yii::import('application.models.mail.*');
    }



    /***
     * Test reset password
     */
    public function testResetPassword()
    {
        $data = array(
            'link'  =>  '<a href="http://www.google.com">http://www.google.com</a>',
            'email' =>  'wangfei001@hotmail.com',
            'name'  =>  'fei',
            'time'  =>  'time'
        );


        $mailApi = new MailApi();
        $result = $mailApi->send(MailApi::MAIL_TEMPLATE_RESETPASSWORD, $data);

        $this->assertTrue(is_numeric($result));

        $row = Ums::model()->find('id_ums = ' .$result);

        $this->assertTrue($row instanceof Ums);

        $this->assertEquals($row->status, MailBase::MAIL_STATUS_INIT);

        $row->delete();
    }
}
