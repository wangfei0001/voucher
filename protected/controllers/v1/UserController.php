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




    /***
     * Get User profile, now only includes email, username, firstname and lastname
     */
    public function View()
    {
        $userId = $this->getParam('id');

        $selectedFields = array('email','username','fname','lname');

        $response = array(
            'data'      =>  null,
            'status'    =>  false
        );

        //$row = User::model()->find('id_user = :id_user', array('id_user' => $userid));

        $criteria=new CDbCriteria;
        $criteria->condition = 'id_user = ' .$userId .' and fk_role = 2';
        $criteria->select = $selectedFields;

        $row = User::model()->find($criteria);

        if($row){
            $user = array();
            foreach($row as $key=>$val){
                if($val != null || in_array($key, $selectedFields)){
                   $user[$key] = $val;
                }

            }

            $response['data'] = $user;
            $response['status'] = true;
        }
        $this->_sendResponse($response);
    }


    public function Update()
    {

        $userId = $this->getParam('id');

        $type = $this->getParam('type');

        if($userId != $this->id_user){
            throw new Exception('您没有权限修改用户信息');
        }

        $user = User::model()->find('id_user = :id_user', array('id_user' => $this->id_user));

        $response = array(
            'data'      =>  null,
            'status'    =>  false
        );

        if($type == 'normal'){              //save normal information
            $username = $this->getParam('username');
            $email = $this->getParam('email');
            $fname = $this->getParam('fname');
            $lname = $this->getParam('lname');


            $user->username = $username;

            $user->email = $email;

            $user->fname = $fname;

            $user->lname = $lname;

            $response['status'] = $user->save();

            $response['data'] = $user;

        }else if($type == 'password'){
            $response['data'] = 'password';

            $response['status'] = true;
        }

        $this->_sendResponse($response);
    }
}
