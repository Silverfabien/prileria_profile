<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211108175343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `bat_ban` (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(100) DEFAULT NULL, ban_ip VARCHAR(50) DEFAULT NULL, ban_staff VARCHAR(30) NOT NULL, ban_reason VARCHAR(100) DEFAULT NULL, ban_server VARCHAR(30) NOT NULL, ban_begin DATETIME NOT NULL, ban_end DATETIME DEFAULT NULL, ban_state INT NOT NULL, ban_unbandate DATETIME DEFAULT NULL, ban_unbanstaff VARCHAR(30) DEFAULT NULL, ban_unbanreason VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `bat_ban`');
    }
}
