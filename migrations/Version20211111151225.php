<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211111151225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `BAT_kick` (kick_id INT AUTO_INCREMENT NOT NULL, UUID VARCHAR(100) NOT NULL, kick_staff VARCHAR(30) NOT NULL, kick_reason VARCHAR(100) DEFAULT NULL, kick_server VARCHAR(30) NOT NULL, kick_date DATETIME NOT NULL, PRIMARY KEY(kick_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bat_ban CHANGE ban_id ban_id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `BAT_kick`');
        $this->addSql('ALTER TABLE `BAT_ban` CHANGE ban_id ban_id INT NOT NULL');
    }
}
