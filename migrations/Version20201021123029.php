<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201021123029 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE number (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, phone_number VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_96901F546B01BC5B (phone_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE number_phonebook (number_id INT NOT NULL, phonebook_id INT NOT NULL, INDEX IDX_CC55473B30A1DE10 (number_id), INDEX IDX_CC55473B1200F70D (phonebook_id), PRIMARY KEY(number_id, phonebook_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phonebook (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, roles_management TINYTEXT NOT NULL COMMENT \'(DC2Type:array)\', roles_visibility TINYTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE number_phonebook ADD CONSTRAINT FK_CC55473B30A1DE10 FOREIGN KEY (number_id) REFERENCES number (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE number_phonebook ADD CONSTRAINT FK_CC55473B1200F70D FOREIGN KEY (phonebook_id) REFERENCES phonebook (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE number_phonebook DROP FOREIGN KEY FK_CC55473B30A1DE10');
        $this->addSql('ALTER TABLE number_phonebook DROP FOREIGN KEY FK_CC55473B1200F70D');
        $this->addSql('DROP TABLE number');
        $this->addSql('DROP TABLE number_phonebook');
        $this->addSql('DROP TABLE phonebook');
        $this->addSql('DROP TABLE user');
    }
}
