<?php

class m130913_224955_split_addresses extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE  `merchants` DROP  `lat` ,
            DROP  `lng` ,
            DROP  `address1` ,
            DROP  `address2` ,
            DROP  `postcode` ,
            DROP  `phone` ,
            DROP  `fax` ,
            DROP  `geohash` ;


            CREATE TABLE addresses (
              id_address bigint(20) NOT NULL AUTO_INCREMENT,
              fk_merchant bigint(20) NOT NULL,
              address1 varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              address2 varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
              lat float(10,6) NOT NULL,
              lng float(10,6) NOT NULL,
              postcode varchar(16) COLLATE utf8_unicode_ci NOT NULL,
              phone varchar(16) COLLATE utf8_unicode_ci NOT NULL,
              fax int(16) DEFAULT NULL,
              geohash varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '自动生成',
              created_at datetime NOT NULL,
              updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (id_address)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ");
	}

	public function down()
	{
		echo "m130913_224955_split_addresses does not support migration down.\n";
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