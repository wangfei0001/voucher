<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-9-1
 * Time: PM9:23
 * To change this template use File | Settings | File Templates.
 */
class UserController extends ApiController
{

    /***
     * User register an account
     *
     * curl -d "username=wangfei0008&password=616682&email=wangfei001@yahoo.com" --dump-header headers http://voucher/api/v1/user
     */
    public function Create()
    {
        $response = array(
            'data'      =>  null,
            'status'    =>  false
        );

        $model = new UserForm();

        if(isset($_POST)){
            $model->attributes = $_POST;

            if($model->validate()){

                $user = $model->create();

                if($user){
                    $response['data'] = Userskey::model()->find('fk_user = :fk_user', array('fk_user' => $user->id_user));
                    $response['status'] = true;
                }
            }
        }

        $this->_sendResponse($response);
    }

}
