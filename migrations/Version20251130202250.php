<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251130202250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customjewelries DROP FOREIGN KEY FK_6DFDE939395C3F3');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY fk_order_user');
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_6DFDE939395C3F3 ON customjewelries');
        $this->addSql('ALTER TABLE customjewelries DROP customer_id');
        $this->addSql('ALTER TABLE gem DROP FOREIGN KEY FK_D34A04ADD58B5513');
        $this->addSql('ALTER TABLE gem CHANGE price price NUMERIC(10, 2) NOT NULL');
        $this->addSql('DROP INDEX idx_d34a04add58b5513 ON gem');
        $this->addSql('CREATE INDEX IDX_995086B0D58B5513 ON gem (gemtype_id)');
        $this->addSql('ALTER TABLE gem ADD CONSTRAINT FK_D34A04ADD58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id)');
        $this->addSql('DROP INDEX fk_order_user ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE status status VARCHAR(100) NOT NULL, CHANGE amount amount NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY fk_orderitem_gembundle');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY fk_orderitem_customjewelry');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY fk_orderitem_jewelry');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY fk_orderitem_gem');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY fk_orderitem_order');
        $this->addSql('DROP INDEX fk_orderitem_gembundle ON orderitem');
        $this->addSql('DROP INDEX fk_orderitem_order ON orderitem');
        $this->addSql('DROP INDEX fk_orderitem_gem ON orderitem');
        $this->addSql('DROP INDEX fk_orderitem_jewelry ON orderitem');
        $this->addSql('DROP INDEX fk_orderitem_customjewelry ON orderitem');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE admin');
        $this->addSql('ALTER TABLE customjewelries ADD customer_id INT NOT NULL');
        $this->addSql('ALTER TABLE customjewelries ADD CONSTRAINT FK_6DFDE939395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6DFDE939395C3F3 ON customjewelries (customer_id)');
        $this->addSql('ALTER TABLE gem DROP FOREIGN KEY FK_995086B0D58B5513');
        $this->addSql('ALTER TABLE gem CHANGE price price NUMERIC(10, 0) NOT NULL');
        $this->addSql('DROP INDEX idx_995086b0d58b5513 ON gem');
        $this->addSql('CREATE INDEX IDX_D34A04ADD58B5513 ON gem (gemtype_id)');
        $this->addSql('ALTER TABLE gem ADD CONSTRAINT FK_995086B0D58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id)');
        $this->addSql('ALTER TABLE `order` CHANGE status status VARCHAR(255) NOT NULL, CHANGE amount amount NUMERIC(10, 0) NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT fk_order_user FOREIGN KEY (customerid) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX fk_order_user ON `order` (customerid)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT fk_orderitem_gembundle FOREIGN KEY (gembundle_id) REFERENCES gembundles (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT fk_orderitem_customjewelry FOREIGN KEY (customjewelry_id) REFERENCES customjewelries (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT fk_orderitem_jewelry FOREIGN KEY (jewelry_id) REFERENCES jewelries (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT fk_orderitem_gem FOREIGN KEY (gem_id) REFERENCES gem (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT fk_orderitem_order FOREIGN KEY (orderid) REFERENCES `order` (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX fk_orderitem_gembundle ON orderitem (gembundle_id)');
        $this->addSql('CREATE INDEX fk_orderitem_order ON orderitem (orderid)');
        $this->addSql('CREATE INDEX fk_orderitem_gem ON orderitem (gem_id)');
        $this->addSql('CREATE INDEX fk_orderitem_jewelry ON orderitem (jewelry_id)');
        $this->addSql('CREATE INDEX fk_orderitem_customjewelry ON orderitem (customjewelry_id)');
    }
}
