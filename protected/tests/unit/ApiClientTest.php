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
        'users'     =>  'User',
        'userskey'  =>  'Userskey',
        'vouchers'  =>  'Voucher',
        'favourites' => 'Favourite'
    );

    protected $apiClient;


    public function setUp()
    {
        parent::setUp();
        $this->apiClient = new ApiClient();
    }


    /***
     *
     */
    public function testLogin()
    {
        $mustHave = array('public_key', 'private_key', 'id_user', 'username');

        $user = $this->users['user1'];
        $json = $this->apiClient->login($user['username'], $user['password']);

        $this->assertTrue(is_array($json) && $json['status'] == true);

        foreach($mustHave as $val){
            $this->assertTrue(isset($json['data'][$val]), 'Variable ' .$val .' not set');
        }
    }


    /***
     *
     */
    public function testLogout()
    {
        $user = $this->users['user1'];

        $key = $this->userskey['key1'];


        $this->apiClient->setKeys($key['public_key'], $key['private_key']);

        $json = $this->apiClient->logout($user['id_user']);

        $this->assertTrue(is_array($json));

        $this->assertEquals($json['status'], true);

    }




    /***
     * 添加优惠券
     */
    public function testAddFavourite()
    {

        $key = $this->userskey['key1'];

        $voucher = $this->vouchers['voucher1'];

        $this->apiClient->setKeys($key['public_key'], $key['private_key']);

        $json = $this->apiClient->addVoucherAsFavourite($voucher['id_voucher']);

        $this->assertTrue(is_array($json));

        $this->assertEquals($json['status'], true);

        $this->assertGreaterThan(0, $json['data']);

    }


    public function testRemoveFavourite()
    {
        $favourite = $this->favourites['user1voucher1'];

        $key = $this->userskey['key1'];

        $this->apiClient->setKeys($key['public_key'], $key['private_key']);

        $json = $this->apiClient->removeFavourite($favourite['id_favourite']);

        $this->assertTrue(is_array($json));

        $this->assertEquals($json['status'], true);
    }


    public function testCheckVersion()
    {
        $mustHave = array('version', 'description', 'released_at');

        $json = $this->apiClient->checkVersion('1.1.0');

        $this->assertTrue(is_array($json));

        $this->assertEquals($json['status'], true);

        foreach($mustHave as $val){
            $this->assertTrue(isset($json['data'][$val]), 'Variable ' .$val .' not set');
        }
    }


    public function testGetFavourites()
    {

        $mustHave = array('name', 'id_favourite', 'id_voucher', 'merchant');

        $key = $this->userskey['key1'];

        $this->apiClient->setKeys($key['public_key'], $key['private_key']);

        $json = $this->apiClient->getFavouriteVouchers();

        $this->assertTrue(is_array($json));

        $this->assertEquals($json['status'], true);

        $data = $json['data'];

        $this->assertTrue(is_array($data) && count($data) == 1);

        foreach($data as $voucher){
            foreach($mustHave as $val){
                $this->assertTrue(isset($voucher[$val]), 'Variable ' .$val .' not set');
            }
        }
    }

    public function testGetProfile()
    {
        $mustHave = array('username', 'email', 'fname', 'lname');

        $json = $this->apiClient->getProfile($this->users['user1']['id_user']);

        $this->assertTrue(is_array($json));

        $this->assertEquals($json['status'], true);

        $data = $json['data'];

        $this->assertTrue(is_array($data));

        foreach($mustHave as $val){
            $this->assertTrue(isset($json['data'][$val]), 'Variable ' .$val .' not set');
        }

    }

    public function testModifyNormalProfile()
    {
        $user = $this->users['user1'];

        $data = array(
            'username'  =>  $user['username'],
            'email'     =>  $user['email'],
            'fname'     =>  $user['fname'],
            'lname'     =>  $user['lname'],
            'type'      =>  'normal'
        );

        $key = $this->userskey['key1'];

        $this->apiClient->setKeys($key['public_key'], $key['private_key']);

        $json = $this->apiClient->changeNormal($user['id_user'], $data);

        $this->assertTrue(is_array($json));

        $this->assertEquals($json['status'], true);
    }

    public function testModifyPasswordProfile()
    {

    }


    /***
     *
     */
    public function testLogoutWithoutSignature()
    {
        $user = $this->users['user1'];

        $json = $this->apiClient->logout($user['id_user']);

        $this->assertTrue(is_null($json));
    }
}
