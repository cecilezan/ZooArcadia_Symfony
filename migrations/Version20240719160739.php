<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240719160739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(64) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_visible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vet_report (id INT AUTO_INCREMENT NOT NULL, animal_id_id INT NOT NULL, name_veto VARCHAR(64) NOT NULL, date_visit DATETIME NOT NULL, detail LONGTEXT NOT NULL, INDEX IDX_864389515EB747A3 (animal_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vet_report ADD CONSTRAINT FK_864389515EB747A3 FOREIGN KEY (animal_id_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE animal ADD race_id_id INT NOT NULL, ADD habitat_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F997ABF46 FOREIGN KEY (race_id_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F20AE7A39 FOREIGN KEY (habitat_id_id) REFERENCES habitat (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F997ABF46 ON animal (race_id_id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F20AE7A39 ON animal (habitat_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vet_report DROP FOREIGN KEY FK_864389515EB747A3');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE vet_report');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F997ABF46');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F20AE7A39');
        $this->addSql('DROP INDEX IDX_6AAB231F997ABF46 ON animal');
        $this->addSql('DROP INDEX IDX_6AAB231F20AE7A39 ON animal');
        $this->addSql('ALTER TABLE animal DROP race_id_id, DROP habitat_id_id');
    }
}
