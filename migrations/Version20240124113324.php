<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240124113324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administration (id INT AUTO_INCREMENT NOT NULL, parent_id INT NOT NULL, family_income VARCHAR(255) NOT NULL, tax_return VARCHAR(255) NOT NULL, caf_number VARCHAR(7) NOT NULL, social_number VARCHAR(15) NOT NULL, residency_proof VARCHAR(255) NOT NULL, status_proof VARCHAR(255) NOT NULL, banking_info VARCHAR(255) NOT NULL, discharge VARCHAR(255) NOT NULL, family_record VARCHAR(255) NOT NULL, divorce_decree VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_9FDD0D18727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE administration_creche (administration_id INT NOT NULL, creche_id INT NOT NULL, INDEX IDX_EFFF052639B8E743 (administration_id), INDEX IDX_EFFF05266C6060B (creche_id), PRIMARY KEY(administration_id, creche_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, creche_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, description LONGTEXT NOT NULL, all_day TINYINT(1) DEFAULT NULL, background_color VARCHAR(7) NOT NULL, text_color VARCHAR(7) NOT NULL, INDEX IDX_6EA9A1466C6060B (creche_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE child (id INT AUTO_INCREMENT NOT NULL, family_id INT NOT NULL, child_firstname VARCHAR(100) NOT NULL, child_lastname VARCHAR(100) NOT NULL, birthdate DATE NOT NULL, is_walking TINYINT(1) NOT NULL, allergy VARCHAR(255) NOT NULL, is_disabled TINYINT(1) NOT NULL, disability VARCHAR(255) DEFAULT NULL, birth_certificate VARCHAR(255) NOT NULL, doctor_name VARCHAR(255) NOT NULL, vaccine VARCHAR(255) NOT NULL, insurance VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_22B35429C35E566A (family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE child_creche (child_id INT NOT NULL, creche_id INT NOT NULL, INDEX IDX_370AD94DD62C21B (child_id), INDEX IDX_370AD946C6060B (creche_id), PRIMARY KEY(child_id, creche_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creche (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, introduction LONGTEXT NOT NULL, name VARCHAR(255) NOT NULL, localisation VARCHAR(255) NOT NULL, post_code INT NOT NULL, city VARCHAR(255) NOT NULL, phone_number VARCHAR(10) NOT NULL, insurance_number VARCHAR(20) NOT NULL, legal_status VARCHAR(255) NOT NULL, rules LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_6A2569C8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emergency_contact (id INT AUTO_INCREMENT NOT NULL, family_id INT NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone_contact VARCHAR(15) NOT NULL, INDEX IDX_FE1C6190C35E566A (family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(5) NOT NULL, city VARCHAR(255) NOT NULL, phone VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_A5E6215BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, creche_id INT DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_14B784186C6060B (creche_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, creche_id INT NOT NULL, family_id INT NOT NULL, calendar_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_42C849556C6060B (creche_id), INDEX IDX_42C84955C35E566A (family_id), UNIQUE INDEX UNIQ_42C84955A40A2C8 (calendar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, creche_id INT NOT NULL, weekdays VARCHAR(255) NOT NULL, opening_hours VARCHAR(255) NOT NULL, closing_hours VARCHAR(255) NOT NULL, INDEX IDX_5A3811FB6C6060B (creche_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, creche_id INT NOT NULL, service_name VARCHAR(255) NOT NULL, status TINYINT(1) DEFAULT NULL, INDEX IDX_E19D9AD26C6060B (creche_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, creche_id INT NOT NULL, team_firstname VARCHAR(255) NOT NULL, team_lastname VARCHAR(255) NOT NULL, fonction VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_C4E0A61F6C6060B (creche_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administration ADD CONSTRAINT FK_9FDD0D18727ACA70 FOREIGN KEY (parent_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE administration_creche ADD CONSTRAINT FK_EFFF052639B8E743 FOREIGN KEY (administration_id) REFERENCES administration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE administration_creche ADD CONSTRAINT FK_EFFF05266C6060B FOREIGN KEY (creche_id) REFERENCES creche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A1466C6060B FOREIGN KEY (creche_id) REFERENCES creche (id)');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B35429C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE child_creche ADD CONSTRAINT FK_370AD94DD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE child_creche ADD CONSTRAINT FK_370AD946C6060B FOREIGN KEY (creche_id) REFERENCES creche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE creche ADD CONSTRAINT FK_6A2569C8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE emergency_contact ADD CONSTRAINT FK_FE1C6190C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784186C6060B FOREIGN KEY (creche_id) REFERENCES creche (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849556C6060B FOREIGN KEY (creche_id) REFERENCES creche (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A40A2C8 FOREIGN KEY (calendar_id) REFERENCES calendar (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB6C6060B FOREIGN KEY (creche_id) REFERENCES creche (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD26C6060B FOREIGN KEY (creche_id) REFERENCES creche (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F6C6060B FOREIGN KEY (creche_id) REFERENCES creche (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administration DROP FOREIGN KEY FK_9FDD0D18727ACA70');
        $this->addSql('ALTER TABLE administration_creche DROP FOREIGN KEY FK_EFFF052639B8E743');
        $this->addSql('ALTER TABLE administration_creche DROP FOREIGN KEY FK_EFFF05266C6060B');
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A1466C6060B');
        $this->addSql('ALTER TABLE child DROP FOREIGN KEY FK_22B35429C35E566A');
        $this->addSql('ALTER TABLE child_creche DROP FOREIGN KEY FK_370AD94DD62C21B');
        $this->addSql('ALTER TABLE child_creche DROP FOREIGN KEY FK_370AD946C6060B');
        $this->addSql('ALTER TABLE creche DROP FOREIGN KEY FK_6A2569C8A76ED395');
        $this->addSql('ALTER TABLE emergency_contact DROP FOREIGN KEY FK_FE1C6190C35E566A');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215BA76ED395');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784186C6060B');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849556C6060B');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955C35E566A');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A40A2C8');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB6C6060B');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD26C6060B');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F6C6060B');
        $this->addSql('DROP TABLE administration');
        $this->addSql('DROP TABLE administration_creche');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE child');
        $this->addSql('DROP TABLE child_creche');
        $this->addSql('DROP TABLE creche');
        $this->addSql('DROP TABLE emergency_contact');
        $this->addSql('DROP TABLE family');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
