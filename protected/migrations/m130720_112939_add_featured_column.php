<?php

class m130720_112939_add_featured_column extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE  `vouchers` ADD  `featured` TINYINT NOT NULL DEFAULT  '0' AFTER  `status` ;
        ");
	}

	public function down()
	{
		echo "m130720_112939_add_featured_column does not support migration down.\n";
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