<?php

class CategoryTest extends CDbTestCase
{
	public $fixtures=array(
		'categories'=>'Category',
        'userskey' => 'Userskey'
	);

	public function testCreate()
	{
        var_dump($this->categories);
        var_dump($this->userskey);
	}
}