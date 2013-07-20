<?php

class m130717_091916_add_fk_user_to_merchant_table extends CDbMigration
{
	public function up()
	{
        $this->execute('
            ALTER TABLE  `merchants` ADD  `fk_user` BIGINT NOT NULL AFTER  `company` ;
            ALTER TABLE  `merchants` ADD INDEX (  `fk_user` ) ;
            ALTER TABLE  `merchants` ADD FOREIGN KEY (  `fk_user` ) REFERENCES  `users` (
            `id_user`
            ) ON DELETE NO ACTION ON UPDATE NO ACTION ;
        ');
	}

	public function down()
	{
		echo "m130717_091916_add_fk_user_to_merchant_table does not support migration down.\n";
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