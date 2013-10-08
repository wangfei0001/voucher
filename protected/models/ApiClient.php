<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-9-3
 * Time: PM9:25
 * To change this template use File | Settings | File Templates.
 */
class ApiClient
{
    const HOSTNAME = 'voucher';



    /***
     * Methods
     */
    const HTTP_METHOD_POST = 'POST';

    const HTTP_METHOD_GET = 'GET';

    const HTTP_METHOD_DELETE = 'DELETE';

    const HTTP_METHOD_PUT = 'PUT';



    /***
     * Const
     */

    const API_METHOD_LOGIN = 'LOGIN';

    const API_METHOD_LOGOUT = 'LOGOUT';

    const API_MODIFY_NORMAL_PROFILE = 'PROFILE_NORMAL';

    const API_MODIFY_PASSWORD_PROFILE = 'PROFILE_PASSWORD';

    const API_METHOD_GETPROFILE = 'PROFILE';

    const API_ADDFAVOURITE_VOUCHER = 'ADD_VOUCHER';

    const API_REMOVEFAVOURITE_VOUCHER = 'REMOVE_VOUCHER';

    const API_GETFAVOURITE_VOUCHER = 'GET_VOUCHERS';


    const API_CHECKVERSION = 'CHECK_VERSION';


    protected $publicKey;

    protected $privateKey;


    protected $apiMethodsMapping = array(
        self::API_METHOD_LOGOUT  => array(self::HTTP_METHOD_DELETE, true),
        self::API_METHOD_LOGIN  => array(self::HTTP_METHOD_POST, false),
        self::API_METHOD_GETPROFILE => array(self::HTTP_METHOD_GET, false),
        //收藏voucher
        self::API_ADDFAVOURITE_VOUCHER => array(self::HTTP_METHOD_POST, true),
        self::API_REMOVEFAVOURITE_VOUCHER => array(self::HTTP_METHOD_DELETE, true),
        self::API_GETFAVOURITE_VOUCHER => array(self::HTTP_METHOD_GET, true),
        //检查版本
        self::API_CHECKVERSION => array(self::HTTP_METHOD_GET, false),
        //修改用户信息
        self::API_MODIFY_NORMAL_PROFILE => array(self::HTTP_METHOD_PUT, true),
        self::API_MODIFY_PASSWORD_PROFILE => array(self::HTTP_METHOD_PUT, true)
    );



    /***
     * @param $url
     * @param $apiName
     * @param null $data
     */
    protected function sendRequest($url, $apiName, $data = null)
    {
        $method = $this->apiMethodsMapping[$apiName][0];        //http method

        $needAuth = $this->apiMethodsMapping[$apiName][1];

        $ch = curl_init();



        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if($method == self::HTTP_METHOD_POST){      //post data
            curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
        }else if($method == self::HTTP_METHOD_GET){     //如果是get方法，附加参数
            if($data) $url .= '?' . http_build_query($data);
        }else if($method == self::HTTP_METHOD_PUT){
            $body = http_build_query($data);

            $fp = fopen('php://temp/maxmemory:256000', 'w');
            if (!$fp) {
                die('could not open temp memory data');
            }
            fwrite($fp, $body);
            fseek($fp, 0);

            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_PUT, true);
            curl_setopt($ch, CURLOPT_INFILE, $fp); // file pointer
            curl_setopt($ch, CURLOPT_INFILESIZE, strlen($body));


        }

        $header = array();
        $header[] = 'Host: ' .self::HOSTNAME;
        if($needAuth){
            $stringToSign = $method ."\n"
                .strtolower(self::HOSTNAME) ."\n"
                .$url ."\n";

            $header[] = 'Authorization: '.$this->publicKey .':' .Hmac::encode($stringToSign, $this->privateKey);


            echo '---------------' .PHP_EOL;
            echo $stringToSign .PHP_EOL;
            echo '+++++++++++++++' .PHP_EOL;
            echo 'Authorization: '.$this->publicKey .':' .Hmac::encode($stringToSign, $this->privateKey) .PHP_EOL;
            echo '---------------' .PHP_EOL;

            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        //$request_header_info = curl_getinfo($ch, CURLINFO_HEADER_OUT);

        curl_setopt($ch, CURLOPT_URL, 'http://' .self::HOSTNAME .$url);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if(empty($result)){
            throw new Exception("Empty response.");
        }

//        echo($result);die('ok');

//        Yii::log("--------" .date('Y-m-d H:i:s') ."-------\n",'info', 'application.*');

//        Yii::log($result,'info');
//
//        Yii::log("----------------\n",'info');

        if($method == self::HTTP_METHOD_PUT){
            fclose($fp);
        }

        return CJSON::decode($result);

    }



    /***
     *
     *
     * @param $method
     * @param $url
     * @param null $data
     * @throws Exception
     */
    protected function callApi($apiName, $url, $data = null)
    {
        $apiName = strtoupper($apiName);

        if(isset($this->apiMethodsMapping[$apiName])){

            $url = '/api/v1/' .$url;
            return $this->sendRequest($url, $apiName, $data);
        }else{
            throw new Exception('Method ' .$apiName .' not support!');
        }
    }


    /***
     * @param $pub
     * @param $pri
     */
    public function setKeys($pub, $pri)
    {
        $this->publicKey = $pub;
        $this->privateKey = $pri;
    }


    /***
     * @param $username
     * @param $password
     * @return mixed
     */
    public function login($username, $password)
    {
        return $this->callApi(self::API_METHOD_LOGIN, 'login', array(
            'username'  =>  $username,
            'password'  =>  $password
        ));
    }

    /***
     * Users logout
     *
     * @param $userId
     */
    public function logout($userId)
    {
        return $this->callApi(self::API_METHOD_LOGOUT, 'login/' .$userId, null);
    }




    /***
     * Get User Profile
     *
     * @param $userId
     * @return mixed
     */
    public function getProfile($userId)
    {
        return $this->callApi(self::API_METHOD_GETPROFILE, 'user/' .$userId);
    }



    /***
     * Change the profile, normal
     *
     * @param $userId
     * @param array $profile
     * @return mixed
     */
    public function changeNormal($userId, array $profile)
    {
        return $this->callApi(self::API_MODIFY_NORMAL_PROFILE, 'user/' .$userId, $profile);
    }


    /***
     * @param $id_voucher
     * @return mixed
     */
    public function addVoucherAsFavourite($id_voucher)
    {
        return $this->callApi(self::API_ADDFAVOURITE_VOUCHER, 'favourite', array(
            'type' => 'voucher',
            'id'   =>   $id_voucher
        ));
    }


    public function removeFavourite($id_favourite)
    {
        return $this->callApi(self::API_REMOVEFAVOURITE_VOUCHER, 'favourite/' .$id_favourite, array(
            'id'   =>   $id_favourite
        ));
    }

    public function getFavouriteVouchers()
    {
        return $this->callApi(self::API_GETFAVOURITE_VOUCHER, 'favourite', array(
            'type' => 'voucher'
        ));
    }

    public function checkVersion($curVer)
    {
        return $this->callApi(self::API_CHECKVERSION, 'version', array('curver'=>$curVer));
    }

}
