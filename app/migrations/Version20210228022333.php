<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210228022333 extends AbstractMigration
{
	/**
	 * @return string
	 */
	public function getDescription(): string
	{
		return '';
	}

	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema): void
	{
		$this->addSql("CREATE TABLE `sessions` (
    		`sess_id` VARBINARY(128) NOT NULL PRIMARY KEY,
    		`sess_data` BLOB NOT NULL,
    		`sess_lifetime` INTEGER UNSIGNED NOT NULL,
    		`sess_time` INTEGER UNSIGNED NOT NULL
		) COLLATE utf8mb4_bin, ENGINE = InnoDB;
	");

	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema): void
	{
		$this->addSql("DROP TABLE `sessions`");
	}

}
