<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Adjusted to fix FK names
 */
final class Version20251212093137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Replaces old order table with orders and fixes orderitem foreign key';
    }

    public function up(Schema $schema): void
    {
        // Drop the old order table and recreate as orders
        $this->addSql('CREATE TABLE orders (
            id INT AUTO_INCREMENT NOT NULL,
            customer_id INT NOT NULL,
            status VARCHAR(100) NOT NULL,
            amount NUMERIC(10, 2) NOT NULL,
            created_at DATETIME NOT NULL,
            INDEX IDX_E52FFDEE9395C3F3 (customer_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');

        // Drop old order table if it exists
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939876F04A3B');
        $this->addSql('DROP TABLE `order`');

        // Fix orderitem → orders relation
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_orderitem_orders FOREIGN KEY (order_id) REFERENCES orders (id)');
    }

    public function down(Schema $schema): void
    {
        // Rollback: restore old order table
        $this->addSql('CREATE TABLE `order` (
            id INT AUTO_INCREMENT NOT NULL,
            customerid_id INT DEFAULT NULL,
            status VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
            amount NUMERIC(10, 2) NOT NULL,
            created_at DATETIME NOT NULL,
            INDEX IDX_F529939876F04A3B (customerid_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939876F04A3B FOREIGN KEY (customerid_id) REFERENCES user (id)');

        // Drop new orders table
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE9395C3F3');
        $this->addSql('DROP TABLE orders');

        // Restore orderitem → order relation
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_orderitem_order FOREIGN KEY (order_id) REFERENCES `order` (id)');
    }
}
