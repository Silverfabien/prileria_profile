<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211110192318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `BAT_mute` (id INT AUTO_INCREMENT NOT NULL, UUID VARCHAR(100) DEFAULT NULL, mute_ip VARCHAR(50) DEFAULT NULL, mute_staff VARCHAR(30) NOT NULL, mute_reason VARCHAR(100) DEFAULT NULL, mute_server VARCHAR(30) NOT NULL, mute_begin DATETIME NOT NULL, mute_end DATETIME DEFAULT NULL, mute_state INT NOT NULL, mute_unmutedate DATETIME DEFAULT NULL, mute_unmutestaff VARCHAR(30) DEFAULT NULL, mute_unmutereason VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bat_ban MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE bat_ban DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE bat_ban CHANGE id ban_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE bat_ban ADD PRIMARY KEY (ban_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `BAT_mute`');
        $this->addSql('ALTER TABLE `BAT_ban` MODIFY ban_id INT NOT NULL');
        $this->addSql('ALTER TABLE `BAT_ban` DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE `BAT_ban` CHANGE ban_id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE `BAT_ban` ADD PRIMARY KEY (id)');
    }
}
