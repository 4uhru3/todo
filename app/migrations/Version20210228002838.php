<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Add default user
 */
final class Version20210228002838 extends AbstractMigration
{
	/**
	 * @return string
	 */
	public function getDescription() : string
    {
        return '';
    }

	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema) : void
    {
    	$this->addSql("INSERT INTO `users` (`id`, `login`, `password`, `roles`, `created`, `updated`) VALUES 
			('0162939c-b4b4-4d5b-9350-b02c69080656',
			 'admin',
			 '\$argon2id\$v=19\$m=65536,t=4,p=1\$gfMmRGiKdvJ7GtZ6zwbE8A\$waojhMSSO9U/ZLniEiGHsv57WHxjnf4t91j4V4RkTL4',
			 'admin',
			 '2021-02-28 01:35:14',
			 '2021-02-28 01:35:15'
			 );
		");
    }

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema) : void
    {
        $this->addSql("DELETE FROM `users` WHERE id = '0162939c-b4b4-4d5b-9350-b02c69080656'");
    }
}
