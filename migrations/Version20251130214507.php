<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251130214507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adjust gem price column';
    }

    public function up(Schema $schema): void
    {
        // Adjust price column only
        $this->addSql('ALTER TABLE gem CHANGE price price NUMERIC(10, 0) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // Revert price column
        $this->addSql('ALTER TABLE gem CHANGE price price NUMERIC(10, 2) NOT NULL');
    }
}
