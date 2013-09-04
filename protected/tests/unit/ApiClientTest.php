<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-9-3
 * Time: PM9:25
 * To change this template use File | Settings | File Templates.
 */
class ApiClientTest extends CDbTestCase
{
    public $fixtures=array(
        'users'=>'User',
        'userskey'=>'Userskey'
    );

    public function testLogout()
    {
        $user = $this->users;

        $key = $this->userskey;


        exec('curl -v -H "Authorization: wangfei0001:616682" -X DELETE http://voucher/api/v1/login/27', $output, $retval);

        var_dump($output);

    }
}
