<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190327105143 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE socity_id socity_id INT DEFAULT NULL, CHANGE game_id game_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE socity CHANGE game_id game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE human_resource CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE seasonality_id seasonality_id INT DEFAULT NULL, CHANGE buy_price buy_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE balance_sheet ADD marchendise_sales INT NOT NULL, ADD production_sales INT NOT NULL, ADD production_stock INT NOT NULL, ADD merchandise_stock INT NOT NULL, ADD total_salary INT NOT NULL, ADD raw_purchase INT NOT NULL, ADD marchendise_purchase INT NOT NULL, ADD other_purchase INT NOT NULL, ADD depreciation_amortization INT NOT NULL, ADD taxes INT NOT NULL, ADD repayment_on_depreciation_and_provisions INT NOT NULL, ADD provisions INT NOT NULL, ADD provision_on_current_asset INT NOT NULL, ADD other_expenses INT NOT NULL, ADD interest_and_similar_product INT NOT NULL, ADD interest_and_similar_expenses INT NOT NULL, ADD capital_exceptional_operating_product INT NOT NULL, ADD capital_exceptional_expense INT NOT NULL, ADD research_and_development_cost INT NOT NULL, ADD concession_patents_and_similar INT NOT NULL, ADD grounds INT NOT NULL, ADD constructions INT NOT NULL, ADD technical_installations_equipment INT NOT NULL, ADD customers_and_related_accounts INT NOT NULL, ADD other_receivables INT NOT NULL, ADD availability INT NOT NULL, ADD share_capital_or_individual INT NOT NULL, ADD premium_issue_merger_contribution INT NOT NULL, ADD legal_reserve INT NOT NULL, ADD statutory_or_contractual_reserves INT NOT NULL, ADD other_reserves INT NOT NULL, ADD report_again INT NOT NULL, ADD loan_and_debts_wih_credit_institutions INT NOT NULL, ADD trade_payable_and_related_accounts INT NOT NULL, ADD tax_and_social_debts INT NOT NULL, ADD other_debts INT NOT NULL, CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE loan CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sales_order DROP sales_type');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE balance_sheet DROP marchendise_sales, DROP production_sales, DROP production_stock, DROP merchandise_stock, DROP total_salary, DROP raw_purchase, DROP marchendise_purchase, DROP other_purchase, DROP depreciation_amortization, DROP taxes, DROP repayment_on_depreciation_and_provisions, DROP provisions, DROP provision_on_current_asset, DROP other_expenses, DROP interest_and_similar_product, DROP interest_and_similar_expenses, DROP capital_exceptional_operating_product, DROP capital_exceptional_expense, DROP research_and_development_cost, DROP concession_patents_and_similar, DROP grounds, DROP constructions, DROP technical_installations_equipment, DROP customers_and_related_accounts, DROP other_receivables, DROP availability, DROP share_capital_or_individual, DROP premium_issue_merger_contribution, DROP legal_reserve, DROP statutory_or_contractual_reserves, DROP other_reserves, DROP report_again, DROP loan_and_debts_wih_credit_institutions, DROP trade_payable_and_related_accounts, DROP tax_and_social_debts, DROP other_debts, CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE human_resource CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE loan CHANGE socity_id socity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE seasonality_id seasonality_id INT DEFAULT NULL, CHANGE buy_price buy_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sales_order ADD sales_type INT NOT NULL');
        $this->addSql('ALTER TABLE socity CHANGE game_id game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE socity_id socity_id INT DEFAULT NULL, CHANGE game_id game_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
