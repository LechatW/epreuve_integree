<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201023065245 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `call` (id INT AUTO_INCREMENT NOT NULL, user_in_id INT NOT NULL, user_out_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_CC8E2F3EF23B856B (user_in_id), INDEX IDX_CC8E2F3E615D4347 (user_out_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE number (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, phone_number VARCHAR(20) NOT NULL, type VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_96901F546B01BC5B (phone_number), INDEX IDX_96901F54A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE number_phonebook (number_id INT NOT NULL, phonebook_id INT NOT NULL, INDEX IDX_CC55473B30A1DE10 (number_id), INDEX IDX_CC55473B1200F70D (phonebook_id), PRIMARY KEY(number_id, phonebook_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phonebook (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, roles_management TINYTEXT NOT NULL COMMENT \'(DC2Type:array)\', roles_visibility TINYTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `call` ADD CONSTRAINT FK_CC8E2F3EF23B856B FOREIGN KEY (user_in_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `call` ADD CONSTRAINT FK_CC8E2F3E615D4347 FOREIGN KEY (user_out_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE number ADD CONSTRAINT FK_96901F54A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE number_phonebook ADD CONSTRAINT FK_CC55473B30A1DE10 FOREIGN KEY (number_id) REFERENCES number (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE number_phonebook ADD CONSTRAINT FK_CC55473B1200F70D FOREIGN KEY (phonebook_id) REFERENCES phonebook (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE number_phonebook DROP FOREIGN KEY FK_CC55473B30A1DE10');
        $this->addSql('ALTER TABLE number_phonebook DROP FOREIGN KEY FK_CC55473B1200F70D');
        $this->addSql('ALTER TABLE `call` DROP FOREIGN KEY FK_CC8E2F3EF23B856B');
        $this->addSql('ALTER TABLE `call` DROP FOREIGN KEY FK_CC8E2F3E615D4347');
        $this->addSql('ALTER TABLE number DROP FOREIGN KEY FK_96901F54A76ED395');
        $this->addSql('DROP TABLE `call`');
        $this->addSql('DROP TABLE number');
        $this->addSql('DROP TABLE number_phonebook');
        $this->addSql('DROP TABLE phonebook');
        $this->addSql('DROP TABLE user');
    }
}
