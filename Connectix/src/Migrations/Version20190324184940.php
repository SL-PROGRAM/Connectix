<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190324184940 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE publicity_order (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, socity_id INT NOT NULL, turn INT NOT NULL, publicity_price INT NOT NULL, UNIQUE INDEX UNIQ_8204BEFB4584665A (product_id), INDEX IDX_8204BEFB302CE478 (socity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE publicity_order ADD CONSTRAINT FK_8204BEFB4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE publicity_order ADD CONSTRAINT FK_8204BEFB302CE478 FOREIGN KEY (socity_id) REFERENCES socity (id)');
        $this->addSql('ALTER TABLE production_unit CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE socity_id socity_id INT DEFAULT NULL, CHANGE game_id game_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE socity CHANGE game_id game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE human_resource CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE seasonality_id seasonality_id INT DEFAULT NULL, CHANGE buy_price buy_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE balance_sheet CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE loan CHANGE socity_id socity_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE publicity_order');
        $this->addSql('ALTER TABLE balance_sheet CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE human_resource CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE loan CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE seasonality_id seasonality_id INT DEFAULT NULL, CHANGE buy_price buy_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE production_unit CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE socity CHANGE game_id game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE socity_id socity_id INT DEFAULT NULL, CHANGE game_id game_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
