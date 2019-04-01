<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190401120432 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game ADD production_lign_annual_product_time INT NOT NULL, ADD production_lign_total_life_product_time INT NOT NULL');
        $this->addSql('ALTER TABLE human_resource CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE balance_sheet CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE seasonality_id seasonality_id INT DEFAULT NULL, CHANGE buy_price buy_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE socity CHANGE game_id game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE loan CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE socity_id socity_id INT DEFAULT NULL, CHANGE game_id game_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE balance_sheet CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game DROP production_lign_annual_product_time, DROP production_lign_total_life_product_time');
        $this->addSql('ALTER TABLE human_resource CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE loan CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE seasonality_id seasonality_id INT DEFAULT NULL, CHANGE buy_price buy_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE socity CHANGE game_id game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE socity_id socity_id INT DEFAULT NULL, CHANGE game_id game_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
