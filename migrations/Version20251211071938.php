<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251211071938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orderitem ADD order_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B7384FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_112B7384FCDAEAAA ON orderitem (order_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B7384FCDAEAAA');
        $this->addSql('DROP INDEX UNIQ_112B7384FCDAEAAA ON orderitem');
        $this->addSql('ALTER TABLE orderitem DROP order_id_id');
    }
}
