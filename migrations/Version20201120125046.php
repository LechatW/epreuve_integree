<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201120125046 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE phone_number DROP FOREIGN KEY FK_6B01BC5B3B7323CB');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493B7323CB');
        $this->addSql('DROP TABLE `call`');
        $this->addSql('DROP TABLE holiday');
        $this->addSql('DROP TABLE phone');
        $this->addSql('DROP TABLE phone_number');
        $this->addSql('ALTER TABLE session DROP frequency, DROP frequency_interval, DROP days, DROP week_days');
        $this->addSql('DROP INDEX UNIQ_8D93D6493B7323CB ON user');
        $this->addSql('ALTER TABLE user DROP phone_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `call` (id INT AUTO_INCREMENT NOT NULL, user_in_id INT NOT NULL, user_out_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_CC8E2F3EF23B856B (user_in_id), INDEX IDX_CC8E2F3E615D4347 (user_out_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE holiday (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE phone (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE phone_number (phone_id INT NOT NULL, number_id INT NOT NULL, INDEX IDX_6B01BC5B3B7323CB (phone_id), INDEX IDX_6B01BC5B30A1DE10 (number_id), PRIMARY KEY(phone_id, number_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `call` ADD CONSTRAINT FK_CC8E2F3E615D4347 FOREIGN KEY (user_out_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `call` ADD CONSTRAINT FK_CC8E2F3EF23B856B FOREIGN KEY (user_in_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE phone_number ADD CONSTRAINT FK_6B01BC5B30A1DE10 FOREIGN KEY (number_id) REFERENCES number (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phone_number ADD CONSTRAINT FK_6B01BC5B3B7323CB FOREIGN KEY (phone_id) REFERENCES phone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session ADD frequency VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD frequency_interval INT DEFAULT NULL, ADD days LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', ADD week_days LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE user ADD phone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493B7323CB FOREIGN KEY (phone_id) REFERENCES phone (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6493B7323CB ON user (phone_id)');
    }
}
