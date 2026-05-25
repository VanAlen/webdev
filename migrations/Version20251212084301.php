<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251212084301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE webdev_gembundles_gemtype (gembundles_id INT NOT NULL, gemtype_id INT NOT NULL, INDEX IDX_10FD6FC24C95F647 (gembundles_id), INDEX IDX_10FD6FC2D58B5513 (gemtype_id), PRIMARY KEY(gembundles_id, gemtype_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE webdev_gembundles_gemtype ADD CONSTRAINT FK_10FD6FC24C95F647 FOREIGN KEY (gembundles_id) REFERENCES gembundles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE webdev_gembundles_gemtype ADD CONSTRAINT FK_10FD6FC2D58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gembundles_gemtype DROP FOREIGN KEY FK_7FB3D31C4C95F647');
        $this->addSql('ALTER TABLE gembundles_gemtype DROP FOREIGN KEY FK_7FB3D31CD58B5513');
        $this->addSql('DROP TABLE gembundles_gemtype');
        $this->addSql('ALTER TABLE `order` CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B7384292CB6B');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B7384E8DFA851');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B73848D2E8B4C');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B7384FCDAEAAA');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B7384D1177FC9');
        $this->addSql('DROP INDEX IDX_112B7384D1177FC9 ON orderitem');
        $this->addSql('DROP INDEX UNIQ_112B7384FCDAEAAA ON orderitem');
        $this->addSql('DROP INDEX IDX_112B73848D2E8B4C ON orderitem');
        $this->addSql('DROP INDEX IDX_112B7384E8DFA851 ON orderitem');
        $this->addSql('DROP INDEX IDX_112B7384292CB6B ON orderitem');
        $this->addSql('ALTER TABLE orderitem ADD gem_id INT DEFAULT NULL, ADD jewelry_id INT DEFAULT NULL, ADD gembundles_id INT DEFAULT NULL, ADD customjewelries_id INT DEFAULT NULL, ADD order_id INT DEFAULT NULL, DROP gem_id_id, DROP jewelry_id_id, DROP gembundles_id_id, DROP cutomjewelries_id_id, DROP order_id_id');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B7384A5AD5580 FOREIGN KEY (gem_id) REFERENCES gem (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B73843FB34C55 FOREIGN KEY (jewelry_id) REFERENCES jewelries (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B73844C95F647 FOREIGN KEY (gembundles_id) REFERENCES gembundles (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B738490C3E44B FOREIGN KEY (customjewelries_id) REFERENCES customjewelries (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B73848D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_112B7384A5AD5580 ON orderitem (gem_id)');
        $this->addSql('CREATE INDEX IDX_112B73843FB34C55 ON orderitem (jewelry_id)');
        $this->addSql('CREATE INDEX IDX_112B73844C95F647 ON orderitem (gembundles_id)');
        $this->addSql('CREATE INDEX IDX_112B738490C3E44B ON orderitem (customjewelries_id)');
        $this->addSql('CREATE INDEX IDX_112B73848D9F6D38 ON orderitem (order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gembundles_gemtype (gembundles_id INT NOT NULL, gemtype_id INT NOT NULL, INDEX IDX_7FB3D31CD58B5513 (gemtype_id), INDEX IDX_7FB3D31C4C95F647 (gembundles_id), PRIMARY KEY(gembundles_id, gemtype_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE gembundles_gemtype ADD CONSTRAINT FK_7FB3D31C4C95F647 FOREIGN KEY (gembundles_id) REFERENCES gembundles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gembundles_gemtype ADD CONSTRAINT FK_7FB3D31CD58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE webdev_gembundles_gemtype DROP FOREIGN KEY FK_10FD6FC24C95F647');
        $this->addSql('ALTER TABLE webdev_gembundles_gemtype DROP FOREIGN KEY FK_10FD6FC2D58B5513');
        $this->addSql('DROP TABLE webdev_gembundles_gemtype');
        $this->addSql('ALTER TABLE `order` CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B7384A5AD5580');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B73843FB34C55');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B73844C95F647');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B738490C3E44B');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B73848D9F6D38');
        $this->addSql('DROP INDEX IDX_112B7384A5AD5580 ON orderitem');
        $this->addSql('DROP INDEX IDX_112B73843FB34C55 ON orderitem');
        $this->addSql('DROP INDEX IDX_112B73844C95F647 ON orderitem');
        $this->addSql('DROP INDEX IDX_112B738490C3E44B ON orderitem');
        $this->addSql('DROP INDEX IDX_112B73848D9F6D38 ON orderitem');
        $this->addSql('ALTER TABLE orderitem ADD gem_id_id INT DEFAULT NULL, ADD jewelry_id_id INT DEFAULT NULL, ADD gembundles_id_id INT DEFAULT NULL, ADD cutomjewelries_id_id INT DEFAULT NULL, ADD order_id_id INT DEFAULT NULL, DROP gem_id, DROP jewelry_id, DROP gembundles_id, DROP customjewelries_id, DROP order_id');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B7384292CB6B FOREIGN KEY (jewelry_id_id) REFERENCES jewelries (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B7384E8DFA851 FOREIGN KEY (gem_id_id) REFERENCES gem (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B73848D2E8B4C FOREIGN KEY (cutomjewelries_id_id) REFERENCES customjewelries (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B7384FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B7384D1177FC9 FOREIGN KEY (gembundles_id_id) REFERENCES gembundles (id)');
        $this->addSql('CREATE INDEX IDX_112B7384D1177FC9 ON orderitem (gembundles_id_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_112B7384FCDAEAAA ON orderitem (order_id_id)');
        $this->addSql('CREATE INDEX IDX_112B73848D2E8B4C ON orderitem (cutomjewelries_id_id)');
        $this->addSql('CREATE INDEX IDX_112B7384E8DFA851 ON orderitem (gem_id_id)');
        $this->addSql('CREATE INDEX IDX_112B7384292CB6B ON orderitem (jewelry_id_id)');
    }
}
