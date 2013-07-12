<?php

class m130712_111809_init_database extends CDbMigration
{
	public function up()
	{
        $basePath = Yii::app()->basePath;
        $fileContent = file_get_contents($basePath .'/data/schema.mysql.sql');

        $this->execute($fileContent);
	}

	public function down()
	{
		echo "m130712_111809_init_database does not support migration down.\n";
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