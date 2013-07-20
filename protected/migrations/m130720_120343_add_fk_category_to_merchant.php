<?php

class m130720_120343_add_fk_category_to_merchant extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE  `merchants` ADD  `fk_category` BIGINT NOT NULL AFTER  `fk_user` ,
            ADD INDEX (  `fk_category` ) ;
            ALTER TABLE  `merchants` ADD FOREIGN KEY (  `fk_category` ) REFERENCES  `category` (
            `id_category`
            ) ON DELETE NO ACTION ON UPDATE NO ACTION ;
        ");
	}

	public function down()
	{
		echo "m130720_120343_add_fk_category_to_merchant does not support migration down.\n";
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