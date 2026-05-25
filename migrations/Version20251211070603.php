<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251211070603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gembundles_gemtype (gembundles_id INT NOT NULL, gemtype_id INT NOT NULL, INDEX IDX_7FB3D31C4C95F647 (gembundles_id), INDEX IDX_7FB3D31CD58B5513 (gemtype_id), PRIMARY KEY(gembundles_id, gemtype_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gembundles_gemtype ADD CONSTRAINT FK_7FB3D31C4C95F647 FOREIGN KEY (gembundles_id) REFERENCES gembundles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gembundles_gemtype ADD CONSTRAINT FK_7FB3D31CD58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orderitem ADD gem_id_id INT DEFAULT NULL, ADD jewelry_id_id INT DEFAULT NULL, ADD gembundles_id_id INT DEFAULT NULL, ADD cutomjewelries_id_id INT DEFAULT NULL, DROP orderid, DROP jewelry_id, DROP customjewelry_id, DROP gembundle_id, DROP gem_id');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B7384E8DFA851 FOREIGN KEY (gem_id_id) REFERENCES gem (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B7384292CB6B FOREIGN KEY (jewelry_id_id) REFERENCES jewelries (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B7384D1177FC9 FOREIGN KEY (gembundles_id_id) REFERENCES gembundles (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B73848D2E8B4C FOREIGN KEY (cutomjewelries_id_id) REFERENCES customjewelries (id)');
        $this->addSql('CREATE INDEX IDX_112B7384E8DFA851 ON orderitem (gem_id_id)');
        $this->addSql('CREATE INDEX IDX_112B7384292CB6B ON orderitem (jewelry_id_id)');
        $this->addSql('CREATE INDEX IDX_112B7384D1177FC9 ON orderitem (gembundles_id_id)');
        $this->addSql('CREATE INDEX IDX_112B73848D2E8B4C ON orderitem (cutomjewelries_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gembundles_gemtype DROP FOREIGN KEY FK_7FB3D31C4C95F647');
        $this->addSql('ALTER TABLE gembundles_gemtype DROP FOREIGN KEY FK_7FB3D31CD58B5513');
        $this->addSql('DROP TABLE gembundles_gemtype');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B7384E8DFA851');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B7384292CB6B');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B7384D1177FC9');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B73848D2E8B4C');
        $this->addSql('DROP INDEX IDX_112B7384E8DFA851 ON orderitem');
        $this->addSql('DROP INDEX IDX_112B7384292CB6B ON orderitem');
        $this->addSql('DROP INDEX IDX_112B7384D1177FC9 ON orderitem');
        $this->addSql('DROP INDEX IDX_112B73848D2E8B4C ON orderitem');
        $this->addSql('ALTER TABLE orderitem ADD orderid INT NOT NULL, ADD jewelry_id INT DEFAULT NULL, ADD customjewelry_id INT DEFAULT NULL, ADD gembundle_id INT DEFAULT NULL, ADD gem_id INT DEFAULT NULL, DROP gem_id_id, DROP jewelry_id_id, DROP gembundles_id_id, DROP cutomjewelries_id_id');
    }
}
