<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231220113617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administration (id INT AUTO_INCREMENT NOT NULL, parent_id INT NOT NULL, family_income VARCHAR(255) NOT NULL, tax_return VARCHAR(255) NOT NULL, caf_number VARCHAR(7) NOT NULL, social_number VARCHAR(15) NOT NULL, residency_proof VARCHAR(255) NOT NULL, status_proof VARCHAR(255) NOT NULL, banking_info VARCHAR(255) NOT NULL, discharge VARCHAR(255) NOT NULL, family_record VARCHAR(255) NOT NULL, divorce_decree VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_9FDD0D18727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE administration_creche (administration_id INT NOT NULL, creche_id INT NOT NULL, INDEX IDX_EFFF052639B8E743 (administration_id), INDEX IDX_EFFF05266C6060B (creche_id), PRIMARY KEY(administration_id, creche_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE child (id INT AUTO_INCREMENT NOT NULL, family_id INT NOT NULL, child_firstname VARCHAR(100) NOT NULL, child_lastname VARCHAR(100) NOT NULL, birthdate DATE NOT NULL, is_walking TINYINT(1) NOT NULL, allergy VARCHAR(255) NOT NULL, is_disabled TINYINT(1) NOT NULL, disability VARCHAR(255) DEFAULT NULL, birth_certificate VARCHAR(255) NOT NULL, doctor_name VARCHAR(255) NOT NULL, vaccine VARCHAR(255) NOT NULL, insurance VARCHAR(255) NOT NULL, INDEX IDX_22B35429C35E566A (family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE child_creche (child_id INT NOT NULL, creche_id INT NOT NULL, INDEX IDX_370AD94DD62C21B (child_id), INDEX IDX_370AD946C6060B (creche_id), PRIMARY KEY(child_id, creche_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emergency_contact (id INT AUTO_INCREMENT NOT NULL, family_id INT NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone_contact VARCHAR(15) NOT NULL, INDEX IDX_FE1C6190C35E566A (family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(5) NOT NULL, city VARCHAR(255) NOT NULL, phone VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, creche_id INT DEFAULT NULL, picture VARCHAR(255) NOT NULL, INDEX IDX_14B784186C6060B (creche_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, creche_id INT NOT NULL, weekdays VARCHAR(255) NOT NULL, opening_hours VARCHAR(255) NOT NULL, closing_hours VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5A3811FB6C6060B (creche_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administration ADD CONSTRAINT FK_9FDD0D18727ACA70 FOREIGN KEY (parent_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE administration_creche ADD CONSTRAINT FK_EFFF052639B8E743 FOREIGN KEY (administration_id) REFERENCES administration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE administration_creche ADD CONSTRAINT FK_EFFF05266C6060B FOREIGN KEY (creche_id) REFERENCES creche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B35429C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE child_creche ADD CONSTRAINT FK_370AD94DD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE child_creche ADD CONSTRAINT FK_370AD946C6060B FOREIGN KEY (creche_id) REFERENCES creche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emergency_contact ADD CONSTRAINT FK_FE1C6190C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784186C6060B FOREIGN KEY (creche_id) REFERENCES creche (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB6C6060B FOREIGN KEY (creche_id) REFERENCES creche (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administration DROP FOREIGN KEY FK_9FDD0D18727ACA70');
        $this->addSql('ALTER TABLE administration_creche DROP FOREIGN KEY FK_EFFF052639B8E743');
        $this->addSql('ALTER TABLE administration_creche DROP FOREIGN KEY FK_EFFF05266C6060B');
        $this->addSql('ALTER TABLE child DROP FOREIGN KEY FK_22B35429C35E566A');
        $this->addSql('ALTER TABLE child_creche DROP FOREIGN KEY FK_370AD94DD62C21B');
        $this->addSql('ALTER TABLE child_creche DROP FOREIGN KEY FK_370AD946C6060B');
        $this->addSql('ALTER TABLE emergency_contact DROP FOREIGN KEY FK_FE1C6190C35E566A');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784186C6060B');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB6C6060B');
        $this->addSql('DROP TABLE administration');
        $this->addSql('DROP TABLE administration_creche');
        $this->addSql('DROP TABLE child');
        $this->addSql('DROP TABLE child_creche');
        $this->addSql('DROP TABLE emergency_contact');
        $this->addSql('DROP TABLE family');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE schedule');
    }
}
