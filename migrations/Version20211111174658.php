<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211111174658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `tigerreports_reports` (report_id INT AUTO_INCREMENT NOT NULL, status VARCHAR(50) NOT NULL, appreciation VARCHAR(255) DEFAULT NULL, date VARCHAR(20) NOT NULL, reported_uuid VARCHAR(36) NOT NULL, reporter_uuid VARCHAR(255) NOT NULL, reason VARCHAR(150) DEFAULT NULL, reported_ip VARCHAR(22) DEFAULT NULL, reported_location VARCHAR(60) DEFAULT NULL, reported_messages LONGTEXT DEFAULT NULL, reported_gamemode VARCHAR(10) DEFAULT NULL, reported_on_ground VARCHAR(1) DEFAULT NULL, reported_sneak VARCHAR(1) DEFAULT NULL, reported_sprint VARCHAR(1) DEFAULT NULL, reported_health VARCHAR(10) DEFAULT NULL, reported_food VARCHAR(10) DEFAULT NULL, reported_effects LONGTEXT DEFAULT NULL, reporter_ip VARCHAR(22) NOT NULL, reporter_location VARCHAR(60) NOT NULL, reporter_messages LONGTEXT DEFAULT NULL, archived INT NOT NULL, PRIMARY KEY(report_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `tigerreports_reports`');
    }
}
