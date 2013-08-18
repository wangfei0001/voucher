<?php

class m130808_115751_modify_users extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE  `users` CHANGE  `fname`  `fname` VARCHAR( 64 ) NULL DEFAULT NULL ;
            ALTER TABLE  `users` CHANGE  `lname`  `fname` VARCHAR( 64 ) NULL DEFAULT NULL ;
            ALTER TABLE  `vouchers` ADD  `image` VARCHAR( 255 ) NULL AFTER  `fk_merchant` ;
        ");
	}

	public function down()
	{
		echo "m130808_115751_modify_users does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}