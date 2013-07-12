<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jacky
 * Date: 3/07/13
 * Time: 5:15 PM
 * To change this template use File | Settings | File Templates.
 */
//http://www.yiiframework.com/wiki/175/how-to-create-a-rest-api/
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
    }

    public function actionView()
    {
    }

    public function actionCreate()
    {
    }

    public function actionUpdate()
    {
    }

    public function actionDelete()
    {
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
        // servers don't always have a signature turned on
        // (this is an apache directive "ServerSignature On")
        //$signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

        echo CJSON::encode($data);

        Yii::app()->end();
    }

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
