<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190312135247 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE seasonality (id INT AUTO_INCREMENT NOT NULL, january DOUBLE PRECISION NOT NULL, february DOUBLE PRECISION NOT NULL, march DOUBLE PRECISION NOT NULL, april DOUBLE PRECISION NOT NULL, may DOUBLE PRECISION NOT NULL, june DOUBLE PRECISION NOT NULL, july DOUBLE PRECISION NOT NULL, august DOUBLE PRECISION NOT NULL, september DOUBLE PRECISION NOT NULL, october DOUBLE PRECISION NOT NULL, november DOUBLE PRECISION NOT NULL, december DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE balance_sheet (id INT AUTO_INCREMENT NOT NULL, socity_id INT DEFAULT NULL, turn INT NOT NULL, status INT NOT NULL, administation_activity_capacity INT NOT NULL, sales_activity_capacity INT NOT NULL, research_activity_capacity INT NOT NULL, sales_activity_professional_capacity INT NOT NULL, sales_activity_particular_capacity INT NOT NULL, production_activity_capacity INT NOT NULL, INDEX IDX_194A20B0302CE478 (socity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE environment (id INT AUTO_INCREMENT NOT NULL, inflation DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE loan (id INT AUTO_INCREMENT NOT NULL, socity_id INT DEFAULT NULL, borrow_amount INT NOT NULL, bank_interest INT NOT NULL, monthly_due_date INT NOT NULL, loan_duration INT NOT NULL, INDEX IDX_C5D30D03302CE478 (socity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE balance_sheet ADD CONSTRAINT FK_194A20B0302CE478 FOREIGN KEY (socity_id) REFERENCES socity (id)');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D03302CE478 FOREIGN KEY (socity_id) REFERENCES socity (id)');
        $this->addSql('ALTER TABLE product ADD seasonality_id INT DEFAULT NULL, CHANGE buy_price buy_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADC8DAFA57 FOREIGN KEY (seasonality_id) REFERENCES seasonality (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADC8DAFA57 ON product (seasonality_id)');
        $this->addSql('ALTER TABLE socity CHANGE game_id game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE production_unit CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD game_id INT DEFAULT NULL, CHANGE socity_id socity_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649E48FD905 ON user (game_id)');
        $this->addSql('ALTER TABLE human_resource CHANGE socity_id socity_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADC8DAFA57');
        $this->addSql('DROP TABLE seasonality');
        $this->addSql('DROP TABLE balance_sheet');
        $this->addSql('DROP TABLE environment');
        $this->addSql('DROP TABLE loan');
        $this->addSql('ALTER TABLE human_resource CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_D34A04ADC8DAFA57 ON product');
        $this->addSql('ALTER TABLE product DROP seasonality_id, CHANGE buy_price buy_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE production_unit CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE socity CHANGE game_id game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E48FD905');
        $this->addSql('DROP INDEX IDX_8D93D649E48FD905 ON user');
        $this->addSql('ALTER TABLE user DROP game_id, CHANGE socity_id socity_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
