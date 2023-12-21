<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231220104717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE creche (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, introduction LONGTEXT NOT NULL, name VARCHAR(255) NOT NULL, localisation VARCHAR(255) NOT NULL, post_code INT NOT NULL, city VARCHAR(255) NOT NULL, phone_number VARCHAR(10) NOT NULL, insurance_number VARCHAR(20) NOT NULL, legal_status VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6A2569C8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, team_firstname VARCHAR(255) NOT NULL, team_lastname VARCHAR(255) NOT NULL, fonction VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE creche ADD CONSTRAINT FK_6A2569C8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creche DROP FOREIGN KEY FK_6A2569C8A76ED395');
        $this->addSql('DROP TABLE creche');
        $this->addSql('DROP TABLE team');
    }
}
