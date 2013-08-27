<?php

class m130808_115751_modify_users extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE  `users` CHANGE  `fname`  `fname` VARCHAR( 64 ) NULL DEFAULT NULL ;
            ALTER TABLE  `users` CHANGE  `lname`  `fname` VARCHAR( 64 ) NULL DEFAULT NULL ;
            ALTER TABLE  `vouchers` ADD  `image` VARCHAR( 255 ) NULL AFTER  `fk_merchant` ;
            ALTER TABLE  `vouchers` CHANGE  `image`  `image` TINYINT NULL DEFAULT NULL ;
            ALTER TABLE  `vouchers` ADD  `reuse_total` INT NULL COMMENT  '可以使用次数' AFTER  `reusable` ,
            ADD  `reuse_left` INT NULL COMMENT  '剩余次数' AFTER  `reuse_total` ;
            ALTER TABLE  `merchants` ADD  `geohash` VARCHAR( 128 ) NOT NULL COMMENT  'Geo hash code, 自动生成' AFTER  `term_condition` ;
            ALTER TABLE  `merchants` ADD INDEX (  `geohash` ) ;
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