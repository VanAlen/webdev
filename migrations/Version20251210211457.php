<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251210211457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product');
        $this->addSql('ALTER TABLE `order` ADD customerid_id INT DEFAULT NULL, DROP customerid');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939876F04A3B FOREIGN KEY (customerid_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F529939876F04A3B ON `order` (customerid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price DOUBLE PRECISION NOT NULL, image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939876F04A3B');
        $this->addSql('DROP INDEX IDX_F529939876F04A3B ON `order`');
        $this->addSql('ALTER TABLE `order` ADD customerid INT NOT NULL, DROP customerid_id');
    }
}
