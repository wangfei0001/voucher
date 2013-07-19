<?php

class m130719_125156_some_database_changes extends CDbMigration
{
	public function up()
	{

        $this->execute("
            ALTER TABLE  `users` ADD  `status` ENUM(  'active',  'suspend' ) NOT NULL AFTER  `fk_city` ;
            ALTER TABLE  `users` CHANGE  `status`  `status` ENUM(  'active',  'suspend' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  'active';
            ALTER TABLE  `vouchers` ADD  `status` ENUM(  'approved',  'init',  'expired' ) NOT NULL AFTER  `reusable` ;
        ");
	}

	public function down()
	{
		echo "m130719_125156_some_database_changes does not support migration down.\n";
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