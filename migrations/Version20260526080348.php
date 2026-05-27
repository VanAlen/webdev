<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260526080348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity_log (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, username VARCHAR(180) DEFAULT NULL, userRole VARCHAR(50) DEFAULT NULL, action VARCHAR(255) NOT NULL, targetData LONGTEXT DEFAULT NULL, dateTime DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_FD06F647A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customjewelries (id INT AUTO_INCREMENT NOT NULL, gemtype_id INT DEFAULT NULL, jewelrytype_id INT DEFAULT NULL, customer_id INT NOT NULL, notes LONGTEXT NOT NULL, imagepath VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6DFDE93D58B5513 (gemtype_id), INDEX IDX_6DFDE93136DC1C2 (jewelrytype_id), INDEX IDX_6DFDE939395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gem (id INT AUTO_INCREMENT NOT NULL, gemtype_id INT DEFAULT NULL, carat DOUBLE PRECISION NOT NULL, size VARCHAR(100) NOT NULL, cut VARCHAR(100) NOT NULL, color VARCHAR(100) NOT NULL, clarity VARCHAR(255) NOT NULL, origin VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, stock INT NOT NULL, price NUMERIC(10, 2) NOT NULL, imagepath VARCHAR(255) DEFAULT NULL, INDEX IDX_995086B0D58B5513 (gemtype_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gembundles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, stock INT NOT NULL, price INT NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE webdev_gembundles_gemtype (gembundles_id INT NOT NULL, gemtype_id INT NOT NULL, INDEX IDX_10FD6FC24C95F647 (gembundles_id), INDEX IDX_10FD6FC2D58B5513 (gemtype_id), PRIMARY KEY(gembundles_id, gemtype_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gemtype (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jewelries (id INT AUTO_INCREMENT NOT NULL, gemtype_id INT DEFAULT NULL, jewelrytype_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, stock INT NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_CDCD7C97D58B5513 (gemtype_id), INDEX IDX_CDCD7C97136DC1C2 (jewelrytype_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jewelrytype (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orderitem (id INT AUTO_INCREMENT NOT NULL, gem_id INT DEFAULT NULL, jewelry_id INT DEFAULT NULL, gembundles_id INT DEFAULT NULL, customjewelries_id INT DEFAULT NULL, order_id INT DEFAULT NULL, quantity INT NOT NULL, price_snapshot NUMERIC(10, 2) NOT NULL, INDEX IDX_112B7384A5AD5580 (gem_id), INDEX IDX_112B73843FB34C55 (jewelry_id), INDEX IDX_112B73844C95F647 (gembundles_id), INDEX IDX_112B738490C3E44B (customjewelries_id), INDEX IDX_112B73848D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, created_by_id INT DEFAULT NULL, status VARCHAR(100) NOT NULL, amount NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_E52FFDEE9395C3F3 (customer_id), INDEX IDX_E52FFDEEB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity_log ADD CONSTRAINT FK_FD06F647A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE customjewelries ADD CONSTRAINT FK_6DFDE93D58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id)');
        $this->addSql('ALTER TABLE customjewelries ADD CONSTRAINT FK_6DFDE93136DC1C2 FOREIGN KEY (jewelrytype_id) REFERENCES jewelrytype (id)');
        $this->addSql('ALTER TABLE customjewelries ADD CONSTRAINT FK_6DFDE939395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE gem ADD CONSTRAINT FK_995086B0D58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id)');
        $this->addSql('ALTER TABLE webdev_gembundles_gemtype ADD CONSTRAINT FK_10FD6FC24C95F647 FOREIGN KEY (gembundles_id) REFERENCES gembundles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE webdev_gembundles_gemtype ADD CONSTRAINT FK_10FD6FC2D58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE jewelries ADD CONSTRAINT FK_CDCD7C97D58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id)');
        $this->addSql('ALTER TABLE jewelries ADD CONSTRAINT FK_CDCD7C97136DC1C2 FOREIGN KEY (jewelrytype_id) REFERENCES jewelrytype (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B7384A5AD5580 FOREIGN KEY (gem_id) REFERENCES gem (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B73843FB34C55 FOREIGN KEY (jewelry_id) REFERENCES jewelries (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B73844C95F647 FOREIGN KEY (gembundles_id) REFERENCES gembundles (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B738490C3E44B FOREIGN KEY (customjewelries_id) REFERENCES customjewelries (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B73848D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD dateCreated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD status VARCHAR(20) NOT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD isVerified TINYINT(1) NOT NULL, ADD verificationToken VARCHAR(255) DEFAULT NULL, ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) DEFAULT NULL, ADD age INT DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD profile_image VARCHAR(255) DEFAULT NULL, CHANGE username username VARCHAR(180) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity_log DROP FOREIGN KEY FK_FD06F647A76ED395');
        $this->addSql('ALTER TABLE customjewelries DROP FOREIGN KEY FK_6DFDE93D58B5513');
        $this->addSql('ALTER TABLE customjewelries DROP FOREIGN KEY FK_6DFDE93136DC1C2');
        $this->addSql('ALTER TABLE customjewelries DROP FOREIGN KEY FK_6DFDE939395C3F3');
        $this->addSql('ALTER TABLE gem DROP FOREIGN KEY FK_995086B0D58B5513');
        $this->addSql('ALTER TABLE webdev_gembundles_gemtype DROP FOREIGN KEY FK_10FD6FC24C95F647');
        $this->addSql('ALTER TABLE webdev_gembundles_gemtype DROP FOREIGN KEY FK_10FD6FC2D58B5513');
        $this->addSql('ALTER TABLE jewelries DROP FOREIGN KEY FK_CDCD7C97D58B5513');
        $this->addSql('ALTER TABLE jewelries DROP FOREIGN KEY FK_CDCD7C97136DC1C2');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B7384A5AD5580');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B73843FB34C55');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B73844C95F647');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B738490C3E44B');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B73848D9F6D38');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE9395C3F3');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEB03A8386');
        $this->addSql('DROP TABLE activity_log');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE customjewelries');
        $this->addSql('DROP TABLE gem');
        $this->addSql('DROP TABLE gembundles');
        $this->addSql('DROP TABLE webdev_gembundles_gemtype');
        $this->addSql('DROP TABLE gemtype');
        $this->addSql('DROP TABLE jewelries');
        $this->addSql('DROP TABLE jewelrytype');
        $this->addSql('DROP TABLE orderitem');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_USERNAME ON user');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL ON user');
        $this->addSql('ALTER TABLE user DROP dateCreated, DROP status, DROP email, DROP isVerified, DROP verificationToken, DROP first_name, DROP last_name, DROP age, DROP address, DROP profile_image, CHANGE username username VARCHAR(100) NOT NULL, CHANGE password password VARCHAR(100) NOT NULL');
    }
}
