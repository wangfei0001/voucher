<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-9-2
 * Time: PM11:43
 * To change this template use File | Settings | File Templates.
 */
class LoginController extends ApiController
{

    /***
     * Login action
     *
     * curl -d "username=wangfei0008&password=616682" --dump-header headers http://voucher/api/v1/login
     */
    public function Create()
    {

        $username = $this->getParam('username');

        $password = $this->getParam('password');

        $user = User::model()->find('username = :username', array('username' => $username));

        $status = false;

        $data = null;

        if($user->password == $password){
            $data = Userskey::model()->find('fk_user = :fk_user', array('fk_user' => $user->id_user));

            if($data){
                $data = $data->attributes;

                $data['id_user'] = $user->id_user;
                $data['username'] = $user->username;

                unset($data['fk_user'], $data['id_userskey']);

                $status = true;
            }

        }

        $this->_sendResponse(array(
            'data'  =>      $data,
            'status'    =>  $status
        ));
    }



    /***
     * Logout action
     *
     * curl -v -H "Authorization: wangfei0001:616682" -X DELETE http://voucher/api/v1/login/27
     */
    public function Delete()
    {
        $result = false;

        $id_user = $this->getParam('id');

        if($id_user == $this->id_user){
            $result = true;
        }
        $this->_sendResponse(array(
            'data'  =>      null,
            'status'    =>  $result
        ));
    }

}
