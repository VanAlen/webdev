<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251212212115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activitylog ADD role_id INT NOT NULL, DROP username, DROP role, CHANGE target_data target_data VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE activitylog ADD CONSTRAINT FK_68BECD63A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_68BECD63A76ED395 ON activitylog (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activitylog DROP FOREIGN KEY FK_68BECD63A76ED395');
        $this->addSql('DROP INDEX IDX_68BECD63A76ED395 ON activitylog');
        $this->addSql('ALTER TABLE activitylog ADD username VARCHAR(255) NOT NULL, ADD role VARCHAR(255) NOT NULL, DROP role_id, CHANGE target_data target_data VARCHAR(255) NOT NULL');
    }
}
