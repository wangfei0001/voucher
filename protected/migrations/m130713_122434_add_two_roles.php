<?php

class m130713_122434_add_two_roles extends CDbMigration
{
	public function up()
	{
        $this->execute("
            INSERT INTO `roles` (`id_role`, `role`) VALUES
            (1, 'Merchant'),
            (2, 'App');
            ALTER TABLE  `roles` ADD UNIQUE (
            `role`
            );
            ALTER TABLE  `users` CHANGE  `fname`  `fname` INT( 64 ) NULL ;
            ALTER TABLE  `users` CHANGE  `lname`  `fname` INT( 64 ) NULL ;
            ALTER TABLE  `users` CHANGE  `gender`  `gender` TINYINT( 1 ) NULL ;
        ");
	}

	public function down()
	{
		echo "m130713_122434_add_two_roles does not support migration down.\n";
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