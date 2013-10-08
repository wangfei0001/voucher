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

        var_dump(($vouchers));
    }
}