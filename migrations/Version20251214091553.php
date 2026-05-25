<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251214091553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activitylog DROP FOREIGN KEY FK_68BECD63A76ED395');
        $this->addSql('ALTER TABLE activitylog CHANGE role_id roleId INT NOT NULL, CHANGE target_data targetData VARCHAR(255) DEFAULT NULL, CHANGE date_time dateTime DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP INDEX idx_68becd63a76ed395 ON activitylog');
        $this->addSql('CREATE INDEX IDX_EE2242B4A76ED395 ON activitylog (user_id)');
        $this->addSql('ALTER TABLE activitylog ADD CONSTRAINT FK_68BECD63A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE customjewelries DROP FOREIGN KEY FK_6DFDE93136DC1C2');
        $this->addSql('ALTER TABLE customjewelries DROP FOREIGN KEY FK_6DFDE93D58B5513');
        $this->addSql('DROP INDEX idx_6dfde93d58b5513 ON customjewelries');
        $this->addSql('CREATE INDEX IDX_8E1AE00DD58B5513 ON customjewelries (gemtype_id)');
        $this->addSql('DROP INDEX idx_6dfde93136dc1c2 ON customjewelries');
        $this->addSql('CREATE INDEX IDX_8E1AE00D136DC1C2 ON customjewelries (jewelrytype_id)');
        $this->addSql('ALTER TABLE customjewelries ADD CONSTRAINT FK_6DFDE93136DC1C2 FOREIGN KEY (jewelrytype_id) REFERENCES jewelrytype (id)');
        $this->addSql('ALTER TABLE customjewelries ADD CONSTRAINT FK_6DFDE93D58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id)');
        $this->addSql('ALTER TABLE gem DROP FOREIGN KEY FK_995086B0D58B5513');
        $this->addSql('DROP INDEX idx_995086b0d58b5513 ON gem');
        $this->addSql('CREATE INDEX IDX_A11DC050D58B5513 ON gem (gemtype_id)');
        $this->addSql('ALTER TABLE gem ADD CONSTRAINT FK_995086B0D58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id)');
        $this->addSql('ALTER TABLE jewelries DROP FOREIGN KEY FK_CDCD7C97136DC1C2');
        $this->addSql('ALTER TABLE jewelries DROP FOREIGN KEY FK_CDCD7C97D58B5513');
        $this->addSql('DROP INDEX idx_cdcd7c97d58b5513 ON jewelries');
        $this->addSql('CREATE INDEX IDX_4F3CFE34D58B5513 ON jewelries (gemtype_id)');
        $this->addSql('DROP INDEX idx_cdcd7c97136dc1c2 ON jewelries');
        $this->addSql('CREATE INDEX IDX_4F3CFE34136DC1C2 ON jewelries (jewelrytype_id)');
        $this->addSql('ALTER TABLE jewelries ADD CONSTRAINT FK_CDCD7C97136DC1C2 FOREIGN KEY (jewelrytype_id) REFERENCES jewelrytype (id)');
        $this->addSql('ALTER TABLE jewelries ADD CONSTRAINT FK_CDCD7C97D58B5513 FOREIGN KEY (gemtype_id) REFERENCES gemtype (id)');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B73843FB34C55');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B738490C3E44B');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B73844C95F647');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B7384A5AD5580');
        $this->addSql('ALTER TABLE orderitem DROP FOREIGN KEY FK_112B73848D9F6D38');
        $this->addSql('DROP INDEX idx_112b7384a5ad5580 ON orderitem');
        $this->addSql('CREATE INDEX IDX_93DAF127A5AD5580 ON orderitem (gem_id)');
        $this->addSql('DROP INDEX idx_112b73843fb34c55 ON orderitem');
        $this->addSql('CREATE INDEX IDX_93DAF1273FB34C55 ON orderitem (jewelry_id)');
        $this->addSql('DROP INDEX idx_112b73844c95f647 ON orderitem');
        $this->addSql('CREATE INDEX IDX_93DAF1274C95F647 ON orderitem (gembundles_id)');
        $this->addSql('DROP INDEX idx_112b738490c3e44b ON orderitem');
        $this->addSql('CREATE INDEX IDX_93DAF12790C3E44B ON orderitem (customjewelries_id)');
        $this->addSql('DROP INDEX idx_112b73848d9f6d38 ON orderitem');
        $this->addSql('CREATE INDEX IDX_93DAF1278D9F6D38 ON orderitem (order_id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B73843FB34C55 FOREIGN KEY (jewelry_id) REFERENCES jewelries (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B738490C3E44B FOREIGN KEY (customjewelries_id) REFERENCES customjewelries (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B73844C95F647 FOREIGN KEY (gembundles_id) REFERENCES gembundles (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B7384A5AD5580 FOREIGN KEY (gem_id) REFERENCES gem (id)');
        $this->addSql('ALTER TABLE orderitem ADD CONSTRAINT FK_112B73848D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE user CHANGE date_created dateCreated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Activitylog DROP FOREIGN KEY FK_EE2242B4A76ED395');
        $this->addSql('ALTER TABLE Activitylog CHANGE targetData target_data VARCHAR(255) DEFAULT NULL, CHANGE dateTime date_time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE roleId role_id INT NOT NULL');
        $this->addSql('DROP INDEX idx_ee2242b4a76ed395 ON Activitylog');
        $this->addSql('CREATE INDEX IDX_68BECD63A76ED395 ON Activitylog (user_id)');
        $this->addSql('ALTER TABLE Activitylog ADD CONSTRAINT FK_EE2242B4A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Customjewelries DROP FOREIGN KEY FK_8E1AE00DD58B5513');
        $this->addSql('ALTER TABLE Customjewelries DROP FOREIGN KEY FK_8E1AE00D136DC1C2');
        $this->addSql('DROP INDEX idx_8e1ae00dd58b5513 ON Customjewelries');
        $this->addSql('CREATE INDEX IDX_6DFDE93D58B5513 ON Customjewelries (gemtype_id)');
        $this->addSql('DROP INDEX idx_8e1ae00d136dc1c2 ON Customjewelries');
        $this->addSql('CREATE INDEX IDX_6DFDE93136DC1C2 ON Customjewelries (jewelrytype_id)');
        $this->addSql('ALTER TABLE Customjewelries ADD CONSTRAINT FK_8E1AE00DD58B5513 FOREIGN KEY (gemtype_id) REFERENCES Gemtype (id)');
        $this->addSql('ALTER TABLE Customjewelries ADD CONSTRAINT FK_8E1AE00D136DC1C2 FOREIGN KEY (jewelrytype_id) REFERENCES Jewelrytype (id)');
        $this->addSql('ALTER TABLE Gem DROP FOREIGN KEY FK_A11DC050D58B5513');
        $this->addSql('DROP INDEX idx_a11dc050d58b5513 ON Gem');
        $this->addSql('CREATE INDEX IDX_995086B0D58B5513 ON Gem (gemtype_id)');
        $this->addSql('ALTER TABLE Gem ADD CONSTRAINT FK_A11DC050D58B5513 FOREIGN KEY (gemtype_id) REFERENCES Gemtype (id)');
        $this->addSql('ALTER TABLE Jewelries DROP FOREIGN KEY FK_4F3CFE34D58B5513');
        $this->addSql('ALTER TABLE Jewelries DROP FOREIGN KEY FK_4F3CFE34136DC1C2');
        $this->addSql('DROP INDEX idx_4f3cfe34136dc1c2 ON Jewelries');
        $this->addSql('CREATE INDEX IDX_CDCD7C97136DC1C2 ON Jewelries (jewelrytype_id)');
        $this->addSql('DROP INDEX idx_4f3cfe34d58b5513 ON Jewelries');
        $this->addSql('CREATE INDEX IDX_CDCD7C97D58B5513 ON Jewelries (gemtype_id)');
        $this->addSql('ALTER TABLE Jewelries ADD CONSTRAINT FK_4F3CFE34D58B5513 FOREIGN KEY (gemtype_id) REFERENCES Gemtype (id)');
        $this->addSql('ALTER TABLE Jewelries ADD CONSTRAINT FK_4F3CFE34136DC1C2 FOREIGN KEY (jewelrytype_id) REFERENCES Jewelrytype (id)');
        $this->addSql('ALTER TABLE Orderitem DROP FOREIGN KEY FK_93DAF127A5AD5580');
        $this->addSql('ALTER TABLE Orderitem DROP FOREIGN KEY FK_93DAF1273FB34C55');
        $this->addSql('ALTER TABLE Orderitem DROP FOREIGN KEY FK_93DAF1274C95F647');
        $this->addSql('ALTER TABLE Orderitem DROP FOREIGN KEY FK_93DAF12790C3E44B');
        $this->addSql('ALTER TABLE Orderitem DROP FOREIGN KEY FK_93DAF1278D9F6D38');
        $this->addSql('DROP INDEX idx_93daf12790c3e44b ON Orderitem');
        $this->addSql('CREATE INDEX IDX_112B738490C3E44B ON Orderitem (customjewelries_id)');
        $this->addSql('DROP INDEX idx_93daf127a5ad5580 ON Orderitem');
        $this->addSql('CREATE INDEX IDX_112B7384A5AD5580 ON Orderitem (gem_id)');
        $this->addSql('DROP INDEX idx_93daf1278d9f6d38 ON Orderitem');
        $this->addSql('CREATE INDEX IDX_112B73848D9F6D38 ON Orderitem (order_id)');
        $this->addSql('DROP INDEX idx_93daf1273fb34c55 ON Orderitem');
        $this->addSql('CREATE INDEX IDX_112B73843FB34C55 ON Orderitem (jewelry_id)');
        $this->addSql('DROP INDEX idx_93daf1274c95f647 ON Orderitem');
        $this->addSql('CREATE INDEX IDX_112B73844C95F647 ON Orderitem (gembundles_id)');
        $this->addSql('ALTER TABLE Orderitem ADD CONSTRAINT FK_93DAF127A5AD5580 FOREIGN KEY (gem_id) REFERENCES Gem (id)');
        $this->addSql('ALTER TABLE Orderitem ADD CONSTRAINT FK_93DAF1273FB34C55 FOREIGN KEY (jewelry_id) REFERENCES Jewelries (id)');
        $this->addSql('ALTER TABLE Orderitem ADD CONSTRAINT FK_93DAF1274C95F647 FOREIGN KEY (gembundles_id) REFERENCES Gembundles (id)');
        $this->addSql('ALTER TABLE Orderitem ADD CONSTRAINT FK_93DAF12790C3E44B FOREIGN KEY (customjewelries_id) REFERENCES Customjewelries (id)');
        $this->addSql('ALTER TABLE Orderitem ADD CONSTRAINT FK_93DAF1278D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE User CHANGE dateCreated date_created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
