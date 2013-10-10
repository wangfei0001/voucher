<?php

class VoucherTest extends CDbTestCase
{
	public $fixtures=array(
		'vouchers'=>'Voucher',
        'category'=>'Category'
	);

	public function testCreate()
	{

	}


    public function testGetAll()
    {
        $param['id_category'] = $this->category['cat1']['id_category'];

        $vouchers = Voucher::getAll($param);

        $this->assertTrue(is_array($vouchers));

        foreach($vouchers as $voucher){
            $this->verifyVoucher($voucher);
        }
    }


    /***
     * Verify voucher
     *
     * @param $voucher
     */
    protected function verifyVoucher($voucher)
    {
        $mustHave = array('name', 'id_voucher', 'merchant');

        $merchantMustHave = array('id_merchant', 'company');

        foreach($mustHave as $val){
            $this->assertTrue(isset($voucher[$val]), 'Variable ' .$val .' not set');
            if($val == 'merchant'){
                foreach($merchantMustHave as $val2){
                    $this->assertTrue(isset($voucher[$val][$val2]), 'Variable ' .$val2 .' not set');
                }
            }
        }
    }
}