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

            ALTER TABLE  `vouchers` ADD  `click_total` INT NOT NULL DEFAULT  '0' COMMENT  '点击次数' AFTER  `featured` ;
            ALTER TABLE  `addresses` ADD  `name` VARCHAR( 128 ) NOT NULL AFTER  `fk_merchant` ;
            ALTER TABLE  `addresses` CHANGE  `name`  `name` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ;
            CREATE TABLE IF NOT EXISTS `voucher_address` (
              `id_voucher_address` bigint(20) NOT NULL AUTO_INCREMENT,
              `fk_voucher` bigint(20) NOT NULL,
              `fk_address` bigint(20) NOT NULL,
              PRIMARY KEY (`id_voucher_address`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
            CREATE TABLE IF NOT EXISTS `ums` (
              `id_ums` bigint(20) NOT NULL AUTO_INCREMENT,
              `status` enum('init','pending','completed') COLLATE utf8_unicode_ci NOT NULL,
              `params` text COLLATE utf8_unicode_ci NOT NULL,
              `created_at` datetime NOT NULL,
              `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id_ums`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
            CREATE TABLE IF NOT EXISTS `contact` (
              `id_contact` bigint(20) NOT NULL AUTO_INCREMENT,
              `content` text COLLATE utf8_unicode_ci NOT NULL,
              `contact_info` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'email,qq,phone number, everything.',
              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id_contact`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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