<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211110192734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bat_ban ADD ban_id INT AUTO_INCREMENT NOT NULL, DROP id, ADD PRIMARY KEY (ban_id)');
        $this->addSql('ALTER TABLE bat_mute MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE bat_mute DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE bat_mute CHANGE id mute_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE bat_mute ADD PRIMARY KEY (mute_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `BAT_ban` MODIFY ban_id INT NOT NULL');
        $this->addSql('ALTER TABLE `BAT_ban` DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE `BAT_ban` ADD id INT NOT NULL, DROP ban_id');
        $this->addSql('ALTER TABLE `BAT_mute` MODIFY mute_id INT NOT NULL');
        $this->addSql('ALTER TABLE `BAT_mute` DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE `BAT_mute` CHANGE mute_id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE `BAT_mute` ADD PRIMARY KEY (id)');
    }
}
