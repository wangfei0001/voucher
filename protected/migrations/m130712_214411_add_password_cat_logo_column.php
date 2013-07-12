<?php

class m130712_214411_add_password_cat_logo_column extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE  `users` ADD  `username` VARCHAR( 256 ) NOT NULL AFTER  `id_user` ;');
        $this->execute('ALTER TABLE  `users` ADD  `password` VARCHAR( 256 ) NOT NULL AFTER  `username` ;');
        $this->execute('ALTER TABLE  `category` ADD  `image` VARCHAR( 256 ) NULL AFTER  `name` ;');
	}

	public function down()
	{
		echo "m130712_214411_add_password_cat_logo_column does not support migration down.\n";
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