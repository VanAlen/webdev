<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251017073909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gemtype_product DROP FOREIGN KEY FK_CFF3BF4D4584665A');
        $this->addSql('ALTER TABLE gemtype_product DROP FOREIGN KEY FK_CFF3BF4DD58B5513');
        $this->addSql('DROP TABLE gemtype_product');
        $this->addSql('ALTER TABLE product ADD gemtype_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADD58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADD58B5513 ON product (gemtype_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gemtype_product (gemtype_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_CFF3BF4D4584665A (product_id), INDEX IDX_CFF3BF4DD58B5513 (gemtype_id), PRIMARY KEY(gemtype_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE gemtype_product ADD CONSTRAINT FK_CFF3BF4D4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gemtype_product ADD CONSTRAINT FK_CFF3BF4DD58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADD58B5513');
        $this->addSql('DROP INDEX IDX_D34A04ADD58B5513 ON product');
        $this->addSql('ALTER TABLE product DROP gemtype_id');
    }
}
