<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jacky
 * Date: 3/07/13
 * Time: 5:15 PM
 * To change this template use File | Settings | File Templates.
 */
//http://www.yiiframework.com/wiki/175/how-to-create-a-rest-api/

if (!function_exists('apache_request_headers')) {
    eval('
            function apache_request_headers() {
                foreach($_SERVER as $key=>$value) {
                    if (substr($key,0,5)=="HTTP_") {
                        $key=str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5)))));
                        $out[$key]=$value;
                    }
                }
                return $out;
            }');
}

class ApiController extends CController
{
    // Members
    /**
     * Key which has to be in HTTP USERNAME and PASSWORD headers
     */
    Const APPLICATION_ID = 'ASCCPE';

    /**
     * Default response format
     * either 'json' or 'xml'
     */
    private $format = 'json';

    protected $latestVersion = 1;

    protected $id;

    public $id_user;


    /***
     * 存储所有将要使用api signature的controller，actions设置
     *
     * @var array
     */
    protected $protectedActions = array(
        'login'     =>  array('delete'),
        'voucher'   =>  array(),
        'favourite' =>  array('create', 'delete')
    );



    /***
     * Check if we need to do api authorization
     *
     * @throws Exception
     */
    protected function checkNeedAuth()
    {

        $controllerId = $this->getParam('controller');

        if(isset($this->protectedActions[$controllerId])){
            $actionId = Yii::app()->controller->action->id;
            if(in_array($actionId, $this->protectedActions[$controllerId])){        //this is an action need to be protected
                                                                                    //, so need to check the api signiture

                $header = apache_request_headers();
                $auth = isset($header['Authorization']) ? $header['Authorization'] : null;

//$fp = fopen('./protected/runtime/auth.log', 'a+');
//fwrite($fp, '--------------' .PHP_EOL);
//fwrite($fp, $auth .PHP_EOL);
//fclose($fp);

                if(!empty($auth)){
//                    if(substr($auth,0,6) == 'Basic '){
//                        $auth = str_replace('Basic ','', $auth);
//                        $auth = base64_decode($auth);
//
//                    }

                    $stringToSign = $_SERVER['REQUEST_METHOD'] ."\n"
                        .strtolower($header['Host']) ."\n"
                        .$_SERVER['REQUEST_URI'] ."\n";

                    $auth = explode(':', $auth);
                    if(!is_array($auth) || count($auth) != 2){
                        throw new Exception('请求授权失败，格式错误');
                    }

                    $userKey = $this->validateUser($auth[0]);
                    //check the signature
                    if(empty($userKey) || $auth[1] != HMAC::encode($stringToSign, $userKey['private_key'])){
                        throw new Exception('Api Signature Authorization 认证失败！无访问权限');
                    }
                }else{
                    throw new Exception('该资源需要进行 Http Basic Authorization 认证失败！无访问权限');
                }
            }
        }
    }



    /***
     * @param $pub
     * @return bool
     */
    protected function validateUser($pub)
    {
        $row = Userskey::model()->find('public_key = :public_key', array('public_key'=>$pub));

        if($row){
            $this->id_user = $row->fk_user;
            return $row;
        }

        return false;
    }


    /***
     * Error handle function for Api controller
     *
     * @param CEvent $event
     */
    public function handleError(CEvent $event)
    {
        $statusCode = 500;

        if ($event instanceof CExceptionEvent)
        {
            if(!empty($event->exception->statusCode))
                $statusCode = $event->exception->statusCode;

            $body = array(
                'code' => $event->exception->getCode(),
                'message' => $event->exception->getMessage(),
                'file' => YII_DEBUG ? $event->exception->getFile() : '*',
                'line' => YII_DEBUG ? $event->exception->getLine() : '*',
                'status' => false
            );

        }
        elseif($event instanceof CErrorEvent)
        {
            $body = array(
                'code' => $event->code,
                'message' => $event->message,
                'file' => YII_DEBUG ? $event->file : '*',
                'line' => YII_DEBUG ? $event->line : '*',
                'status' => false
            );
        }
        $event->handled = TRUE;
        $this->_sendResponse($body, $statusCode);
    }


    /***
     * Get Controller
     *
     * @return mixed
     * @throws Exception
     */
    protected function getController()
    {
        $version = $this->getParam('version');
        $controller = $this->getParam('controller');
        $association = $this->getParam('association');

        Yii::app()->attachEventHandler('onException',array($this,'handleError'));
        Yii::app()->attachEventHandler('onError',array($this,'handleError'));

        $instance = null;

        if($version != $this->latestVersion){
            throw new Exception('Version ' .$version .' not support!');
        }
        //check main controller
        $className = ucfirst($controller) .'Controller';
        Yii::import('application.controllers.v' .$version .'.' .$className);

        if(!class_exists($className)){
            throw new Exception('Class ' .$className .' not found!');
        }

        if(!$association){  //no association controller
            $instance = new $className($controller);
            $instance->id_user = $this->id_user;
            $instance->checkNeedAuth();
            $instance->init();
            return $instance;
        }


        //check asso controller
        $assoClassName = ucfirst($association) .'Controller';
        Yii::import('application.controllers.v' .$version .'.' .$assoClassName);

        if(!class_exists($assoClassName)){
            throw new Exception('Association Class ' .$assoClassName .' not found!');
        }

        $id = $this->getParam('id');
        if(!$id){
            throw new Exception('Found sub resources but no related id!');
        }
        $this->id = $id;

        $instance = new $assoClassName($association);
        $instance->id_user = $this->id_user;
        $instance->id = $id;
        $instance->checkNeedAuth();
        $instance->init();
        return $instance;
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array();
    }

    // Actions
    public function actionList()
    {
        return $this->getController()->Index();
    }

    public function actionView()
    {
        return $this->getController()->View();
    }

    public function actionCreate()
    {
        return $this->getController()->Create();
    }

    public function actionUpdate()
    {
        return $this->getController()->Update();
    }

    public function actionDelete()
    {
        return $this->getController()->Delete();
    }


    /***
     * Will  implemented by Sub class
     *
     * @throws Exception
     */
    public function Index()
    {
        throw new Exception('Method not implemented!');
    }

    /***
     * Will  implemented by Sub class
     *
     * @throws Exception
     */
    public function View()
    {
        throw new Exception('Method not implemented!');
    }


    /***
     * Will  implemented by Sub class
     *
     * @throws Exception
     */
    public function Update()
    {
        throw new Exception('Method not implemented!');
    }

    /***
     * Will  implemented by Sub class
     *
     * @throws Exception
     */
    public function Create()
    {
        throw new Exception('Method not implemented!');
    }


    /***
     * Will  implemented by Sub class
     *
     * @throws Exception
     */
    public function Delete()
    {
        throw new Exception('Method not implemented!');
    }


    /***
     */
    public function getParam($key, $default = null)
    {
        $value = Yii::app()->request->getParam($key);

        if (is_null($value)) {
            if (isset($_COOKIE[$key])) {
                $value = $_COOKIE[$key];
            } elseif (isset($_SERVER[$key])) {
                $value = $_SERVER[$key];
            }
        }


        if (is_null($value)) {
            $value = $default;
        }

        if (is_string($value)) {
            $value = strip_tags($value);
        }
        return $value;
    }


    /***
     * Get status code message
     *
     * @param $status
     * @return string
     */
    protected function _getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    /***
     * Response the client
     *
     * @param array $data
     * @param int $status
     * @throws Exception
     */
    protected function _sendResponse(array $data, $status = 200)
    {
        if(!isset($data['status'])) throw new Exception('Status has to be set!');

        // set the status
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
        // and the content type
        header('Content-type: application/json');

        // create some body messages
        $message = '';

        // this is purely optional, but makes the pages a little nicer to read
        // for your users.  Since you won't likely send a lot of different status codes,
        // this also shouldn't be too ponderous to maintain
        switch($status)
        {
            case 401:
                $message = 'You must be authorized to view this page.';
                break;
            case 404:
                $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                break;
            case 500:
                $message = 'The server encountered an error processing your request.';
                break;
            case 501:
                $message = 'The requested method is not implemented.';
                break;
        }

        if(!empty($message)){
            $data['message'] = $message;
        }

        echo CJSON::encode($data);

        Yii::app()->end();
    }


    /***
     * @param array $objectArray
     * @return array|bool
     */
    protected function toArray(array $objectArray)
    {
        $result = false;
        if($objectArray){
            $result = array();
            foreach($objectArray as $object){
                if($object instanceof CActiveRecord){
                    $result[] = $object->attributes;
                }
            }
        }
        return $result;
    }
}
