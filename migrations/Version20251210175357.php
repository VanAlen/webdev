<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251210175357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customjewelries (id INT AUTO_INCREMENT NOT NULL, gemtype VARCHAR(255) NOT NULL, jewelrytype VARCHAR(255) NOT NULL, notes LONGTEXT NOT NULL, imagepath VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gem (id INT AUTO_INCREMENT NOT NULL, gemtype_id INT DEFAULT NULL, carat DOUBLE PRECISION NOT NULL, size VARCHAR(100) NOT NULL, cut VARCHAR(100) NOT NULL, color VARCHAR(100) NOT NULL, clarity VARCHAR(255) NOT NULL, origin VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, stock INT NOT NULL, price NUMERIC(10, 0) NOT NULL, imagepath VARCHAR(255) DEFAULT NULL, INDEX IDX_995086B0D58B5513 (gemtype_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gembundles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, stock INT NOT NULL, price INT NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gemtype (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jewelries (id INT AUTO_INCREMENT NOT NULL, gemtype_id INT DEFAULT NULL, jewelrytype_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 0) NOT NULL, stock INT NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_CDCD7C97D58B5513 (gemtype_id), INDEX IDX_CDCD7C97136DC1C2 (jewelrytype_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jewelrytype (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customerid INT NOT NULL, status VARCHAR(100) NOT NULL, amount NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orderitem (id INT AUTO_INCREMENT NOT NULL, orderid INT NOT NULL, quantity INT NOT NULL, jewelry_id INT DEFAULT NULL, customjewelry_id INT DEFAULT NULL, gembundle_id INT DEFAULT NULL, gem_id INT DEFAULT NULL, price_snapshot NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gem ADD CONSTRAINT FK_995086B0D58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id)');
        $this->addSql('ALTER TABLE jewelries ADD CONSTRAINT FK_CDCD7C97D58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id)');
        $this->addSql('ALTER TABLE jewelries ADD CONSTRAINT FK_CDCD7C97136DC1C2 FOREIGN KEY (jewelrytype_id) REFERENCES jewelrytype (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gem DROP FOREIGN KEY FK_995086B0D58B5513');
        $this->addSql('ALTER TABLE jewelries DROP FOREIGN KEY FK_CDCD7C97D58B5513');
        $this->addSql('ALTER TABLE jewelries DROP FOREIGN KEY FK_CDCD7C97136DC1C2');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE customjewelries');
        $this->addSql('DROP TABLE gem');
        $this->addSql('DROP TABLE gembundles');
        $this->addSql('DROP TABLE gemtype');
        $this->addSql('DROP TABLE jewelries');
        $this->addSql('DROP TABLE jewelrytype');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE orderitem');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
