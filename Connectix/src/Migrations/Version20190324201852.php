<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190324201852 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE production_unit CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE production_lign ADD annual_product_time INT NOT NULL, ADD total_life_product_time INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE socity_id socity_id INT DEFAULT NULL, CHANGE game_id game_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE production_order DROP FOREIGN KEY FK_EF2857AE827F1DEF');
        $this->addSql('DROP INDEX IDX_EF2857AE827F1DEF ON production_order');
        $this->addSql('ALTER TABLE production_order DROP production_lign_id');
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

        $this->addSql('ALTER TABLE balance_sheet CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE human_resource CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE loan CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE seasonality_id seasonality_id INT DEFAULT NULL, CHANGE buy_price buy_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE production_lign DROP annual_product_time, DROP total_life_product_time');
        $this->addSql('ALTER TABLE production_order ADD production_lign_id INT NOT NULL');
        $this->addSql('ALTER TABLE production_order ADD CONSTRAINT FK_EF2857AE827F1DEF FOREIGN KEY (production_lign_id) REFERENCES production_lign (id)');
        $this->addSql('CREATE INDEX IDX_EF2857AE827F1DEF ON production_order (production_lign_id)');
        $this->addSql('ALTER TABLE production_unit CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE socity CHANGE game_id game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE socity_id socity_id INT DEFAULT NULL, CHANGE game_id game_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
