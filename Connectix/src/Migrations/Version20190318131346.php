<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190318131346 extends AbstractMigration
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
        $this->addSql('ALTER TABLE user CHANGE socity_id socity_id INT DEFAULT NULL, CHANGE game_id game_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE socity DROP money_start, CHANGE game_id game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE human_resource CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD row_material_cost INT NOT NULL, ADD manpower_cost INT NOT NULL, ADD productior_time_cost INT NOT NULL, CHANGE seasonality_id seasonality_id INT DEFAULT NULL, CHANGE buy_price buy_price INT DEFAULT NULL, CHANGE productior_activity_cost production_activity_cost INT NOT NULL');
        $this->addSql('ALTER TABLE balance_sheet CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD tax_turnover INT NOT NULL, ADD employer_contributions INT NOT NULL, ADD pay_tax INT NOT NULL, ADD variable_external_charges INT NOT NULL, ADD row_material_cost INT NOT NULL, ADD raw_material_min INT NOT NULL, ADD raw_material_max INT NOT NULL, ADD man_power_min INT NOT NULL, ADD man_power_max INT NOT NULL, ADD production_time_min INT NOT NULL, ADD production_time_max INT NOT NULL, ADD tax_rate INT NOT NULL, ADD employee_participation INT NOT NULL, ADD socity_start_share_capital INT NOT NULL, ADD socity_start_loan_amount INT NOT NULL, ADD socity_start_loan_duration INT NOT NULL, ADD socity_start_loan_interest_rate INT NOT NULL, ADD annual_hours_work INT NOT NULL, CHANGE smic smic DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE loan ADD delay_loan_repayment INT NOT NULL, CHANGE socity_id socity_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE balance_sheet CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game DROP tax_turnover, DROP employer_contributions, DROP pay_tax, DROP variable_external_charges, DROP row_material_cost, DROP raw_material_min, DROP raw_material_max, DROP man_power_min, DROP man_power_max, DROP production_time_min, DROP production_time_max, DROP tax_rate, DROP employee_participation, DROP socity_start_share_capital, DROP socity_start_loan_amount, DROP socity_start_loan_duration, DROP socity_start_loan_interest_rate, DROP annual_hours_work, CHANGE smic smic INT NOT NULL');
        $this->addSql('ALTER TABLE human_resource CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE loan DROP delay_loan_repayment, CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD productior_activity_cost INT NOT NULL, DROP production_activity_cost, DROP row_material_cost, DROP manpower_cost, DROP productior_time_cost, CHANGE seasonality_id seasonality_id INT DEFAULT NULL, CHANGE buy_price buy_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE production_unit CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE socity ADD money_start INT NOT NULL, CHANGE game_id game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE socity_id socity_id INT DEFAULT NULL, CHANGE game_id game_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
