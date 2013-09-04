<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-9-2
 * Time: PM11:44
 * To change this template use File | Settings | File Templates.
 */
class Hmac
{

    const HMAC_ENCODE_ALGO_SHA256 = 'sha256';



    /***
     * @param $data
     * @param $private
     * @return string
     */
    public static function encode($data, $private)
    {

        return hash_hmac ( self::HMAC_ENCODE_ALGO_SHA256, $data , $private );
    }

}
