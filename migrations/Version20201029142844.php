<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201029142844 extends AbstractMigration
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
        $this->addSql('CREATE TABLE phone (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phone_number (phone_id INT NOT NULL, number_id INT NOT NULL, INDEX IDX_6B01BC5B3B7323CB (phone_id), INDEX IDX_6B01BC5B30A1DE10 (number_id), PRIMARY KEY(phone_id, number_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phonebook (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, roles_management TINYTEXT NOT NULL COMMENT \'(DC2Type:array)\', roles_visibility TINYTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_E1D7BA435E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, training_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, registration_start_at DATE NOT NULL, registration_end_at DATE NOT NULL, location VARCHAR(255) NOT NULL, max_registration INT NOT NULL, UNIQUE INDEX UNIQ_D044D5D45E237E06 (name), INDEX IDX_D044D5D4BEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, contact_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, target VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D5128A8F5E237E06 (name), INDEX IDX_D5128A8FE7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, phone_id INT DEFAULT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649AA08CB10 (login), UNIQUE INDEX UNIQ_8D93D6493B7323CB (phone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_session (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, session_id INT NOT NULL, status VARCHAR(20) NOT NULL, INDEX IDX_8849CBDEA76ED395 (user_id), INDEX IDX_8849CBDE613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `call` ADD CONSTRAINT FK_CC8E2F3EF23B856B FOREIGN KEY (user_in_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `call` ADD CONSTRAINT FK_CC8E2F3E615D4347 FOREIGN KEY (user_out_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE number ADD CONSTRAINT FK_96901F54A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE number_phonebook ADD CONSTRAINT FK_CC55473B30A1DE10 FOREIGN KEY (number_id) REFERENCES number (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE number_phonebook ADD CONSTRAINT FK_CC55473B1200F70D FOREIGN KEY (phonebook_id) REFERENCES phonebook (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phone_number ADD CONSTRAINT FK_6B01BC5B3B7323CB FOREIGN KEY (phone_id) REFERENCES phone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phone_number ADD CONSTRAINT FK_6B01BC5B30A1DE10 FOREIGN KEY (number_id) REFERENCES number (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8FE7A1254A FOREIGN KEY (contact_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493B7323CB FOREIGN KEY (phone_id) REFERENCES phone (id)');
        $this->addSql('ALTER TABLE user_session ADD CONSTRAINT FK_8849CBDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_session ADD CONSTRAINT FK_8849CBDE613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE number_phonebook DROP FOREIGN KEY FK_CC55473B30A1DE10');
        $this->addSql('ALTER TABLE phone_number DROP FOREIGN KEY FK_6B01BC5B30A1DE10');
        $this->addSql('ALTER TABLE phone_number DROP FOREIGN KEY FK_6B01BC5B3B7323CB');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493B7323CB');
        $this->addSql('ALTER TABLE number_phonebook DROP FOREIGN KEY FK_CC55473B1200F70D');
        $this->addSql('ALTER TABLE user_session DROP FOREIGN KEY FK_8849CBDE613FECDF');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4BEFD98D1');
        $this->addSql('ALTER TABLE `call` DROP FOREIGN KEY FK_CC8E2F3EF23B856B');
        $this->addSql('ALTER TABLE `call` DROP FOREIGN KEY FK_CC8E2F3E615D4347');
        $this->addSql('ALTER TABLE number DROP FOREIGN KEY FK_96901F54A76ED395');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8FE7A1254A');
        $this->addSql('ALTER TABLE user_session DROP FOREIGN KEY FK_8849CBDEA76ED395');
        $this->addSql('DROP TABLE `call`');
        $this->addSql('DROP TABLE number');
        $this->addSql('DROP TABLE number_phonebook');
        $this->addSql('DROP TABLE phone');
        $this->addSql('DROP TABLE phone_number');
        $this->addSql('DROP TABLE phonebook');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_session');
    }
}
