<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190312115521 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE production_unit (id INT AUTO_INCREMENT NOT NULL, socity_id INT DEFAULT NULL, turn_creation INT NOT NULL, creation_cost INT NOT NULL, maintenance_cost INT NOT NULL, administration_cost INT NOT NULL, amortization_turn INT NOT NULL, dtype VARCHAR(255) NOT NULL, INDEX IDX_7AB4747302CE478 (socity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE production_lign (id INT NOT NULL, factory_id INT NOT NULL, INDEX IDX_4C149D23C7AF27D2 (factory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, socity_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649302CE478 (socity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE socity (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, money_start INT NOT NULL, price_min_publicicy_impact INT NOT NULL, price_max_publicity_impact INT NOT NULL, INDEX IDX_2B09E378E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE human_resource (id INT AUTO_INCREMENT NOT NULL, socity_id INT DEFAULT NULL, salary INT NOT NULL, formation INT NOT NULL, exprience INT NOT NULL, productivity INT NOT NULL, administration_activity_cost INT NOT NULL, coeficient_salary INT NOT NULL, dtype VARCHAR(255) NOT NULL, INDEX IDX_5535924A302CE478 (socity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE administration (id INT NOT NULL, administation_activity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE factory (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales_man (id INT NOT NULL, commission INT NOT NULL, sales_activity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales_man_professional (id INT NOT NULL, sales_activity_professional INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, name VARCHAR(255) NOT NULL, technologic_level INT NOT NULL, buy_price INT DEFAULT NULL, sale_price INT NOT NULL, quantity_discount INT NOT NULL, productior_activity_cost INT NOT NULL, research_cost INT NOT NULL, product_sale_type INT NOT NULL, product_max_number INT NOT NULL, price_discount INT NOT NULL, product_already_sales INT NOT NULL, INDEX IDX_D34A04ADE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_life (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, cycle_life_number INT NOT NULL, product_cycle_life_number_max INT NOT NULL, cycle_duration INT NOT NULL, price_coeficient INT NOT NULL, publicity_coeficient INT NOT NULL, price_min_publicity_impact INT NOT NULL, price_max_publicity_impact INT NOT NULL, quality INT NOT NULL, INDEX IDX_94251C5F4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, tva INT NOT NULL, maxturn INT NOT NULL, turn INT NOT NULL, socity_number INT NOT NULL, smic INT NOT NULL, creat_at DATETIME NOT NULL, sales_price_min_lvl1 INT NOT NULL, sales_price_max_lvl1 INT NOT NULL, sales_price_min_lvl2 INT NOT NULL, sales_price_min_lvl3 INT NOT NULL, sales_price_min_lvl4 INT NOT NULL, sales_price_max_lvl2 INT NOT NULL, sales_price_max_lvl3 INT NOT NULL, sales_price_max_lvl4 INT NOT NULL, product_number_min_lvl1 INT NOT NULL, product_number_min_lvl2 INT NOT NULL, product_number_min_lvl3 INT NOT NULL, product_number_min_lvl4 INT NOT NULL, product_number_max_lvl1 INT NOT NULL, product_number_max_lvl2 INT NOT NULL, product_number_max_lvl3 INT NOT NULL, product_number_max_lvl4 INT NOT NULL, percent_product_available_min_cycle_life1 INT NOT NULL, percent_product_available_min_cycle_life2 INT NOT NULL, percent_product_available_min_cycle_life3 INT NOT NULL, percent_product_available_min_cycle_life4 INT NOT NULL, percent_product_available_max_cycle_life1 INT NOT NULL, percent_product_available_max_cycle_life2 INT NOT NULL, percent_product_available_max_cycle_life3 INT NOT NULL, percent_product_available_max_cycle_life4 INT NOT NULL, product_quality_min_cycle_life1 INT NOT NULL, product_quality_min_cycle_life2 INT NOT NULL, product_quality_min_cycle_life3 INT NOT NULL, product_quality_min_cycle_life4 INT NOT NULL, product_quality_max_cycle_life1 INT NOT NULL, product_quality_max_cycle_life2 INT NOT NULL, product_quality_max_cycle_life3 INT NOT NULL, product_quality_max_cycle_life4 INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE researcher (id INT NOT NULL, research_activity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE production (id INT NOT NULL, production_activity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE production_cadre (id INT NOT NULL, administration_activity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE production_director (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales_man_director (id INT NOT NULL, administration_activity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technician (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_man (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE researcher_director (id INT NOT NULL, administration_activity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales_man_particular (id INT NOT NULL, sales_activity_particular INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE production_unit ADD CONSTRAINT FK_7AB4747302CE478 FOREIGN KEY (socity_id) REFERENCES socity (id)');
        $this->addSql('ALTER TABLE production_lign ADD CONSTRAINT FK_4C149D23C7AF27D2 FOREIGN KEY (factory_id) REFERENCES factory (id)');
        $this->addSql('ALTER TABLE production_lign ADD CONSTRAINT FK_4C149D23BF396750 FOREIGN KEY (id) REFERENCES production_unit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649302CE478 FOREIGN KEY (socity_id) REFERENCES socity (id)');
        $this->addSql('ALTER TABLE socity ADD CONSTRAINT FK_2B09E378E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE human_resource ADD CONSTRAINT FK_5535924A302CE478 FOREIGN KEY (socity_id) REFERENCES socity (id)');
        $this->addSql('ALTER TABLE administration ADD CONSTRAINT FK_9FDD0D18BF396750 FOREIGN KEY (id) REFERENCES human_resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE factory ADD CONSTRAINT FK_FB361EF9BF396750 FOREIGN KEY (id) REFERENCES production_unit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sales_man ADD CONSTRAINT FK_9CB638C2BF396750 FOREIGN KEY (id) REFERENCES human_resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sales_man_professional ADD CONSTRAINT FK_EAD98CA9BF396750 FOREIGN KEY (id) REFERENCES human_resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE product_life ADD CONSTRAINT FK_94251C5F4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE researcher ADD CONSTRAINT FK_75FF2EDEBF396750 FOREIGN KEY (id) REFERENCES human_resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE production ADD CONSTRAINT FK_D3EDB1E0BF396750 FOREIGN KEY (id) REFERENCES human_resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE production_cadre ADD CONSTRAINT FK_EE24438FBF396750 FOREIGN KEY (id) REFERENCES human_resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE production_director ADD CONSTRAINT FK_E6E76814BF396750 FOREIGN KEY (id) REFERENCES human_resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sales_man_director ADD CONSTRAINT FK_D9485934BF396750 FOREIGN KEY (id) REFERENCES human_resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE technician ADD CONSTRAINT FK_F244E948BF396750 FOREIGN KEY (id) REFERENCES human_resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE work_man ADD CONSTRAINT FK_13CCC044BF396750 FOREIGN KEY (id) REFERENCES human_resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE researcher_director ADD CONSTRAINT FK_C9B0AA1DBF396750 FOREIGN KEY (id) REFERENCES human_resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sales_man_particular ADD CONSTRAINT FK_24DADE63BF396750 FOREIGN KEY (id) REFERENCES human_resource (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE production_lign DROP FOREIGN KEY FK_4C149D23BF396750');
        $this->addSql('ALTER TABLE factory DROP FOREIGN KEY FK_FB361EF9BF396750');
        $this->addSql('ALTER TABLE production_unit DROP FOREIGN KEY FK_7AB4747302CE478');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649302CE478');
        $this->addSql('ALTER TABLE human_resource DROP FOREIGN KEY FK_5535924A302CE478');
        $this->addSql('ALTER TABLE administration DROP FOREIGN KEY FK_9FDD0D18BF396750');
        $this->addSql('ALTER TABLE sales_man DROP FOREIGN KEY FK_9CB638C2BF396750');
        $this->addSql('ALTER TABLE sales_man_professional DROP FOREIGN KEY FK_EAD98CA9BF396750');
        $this->addSql('ALTER TABLE researcher DROP FOREIGN KEY FK_75FF2EDEBF396750');
        $this->addSql('ALTER TABLE production DROP FOREIGN KEY FK_D3EDB1E0BF396750');
        $this->addSql('ALTER TABLE production_cadre DROP FOREIGN KEY FK_EE24438FBF396750');
        $this->addSql('ALTER TABLE production_director DROP FOREIGN KEY FK_E6E76814BF396750');
        $this->addSql('ALTER TABLE sales_man_director DROP FOREIGN KEY FK_D9485934BF396750');
        $this->addSql('ALTER TABLE technician DROP FOREIGN KEY FK_F244E948BF396750');
        $this->addSql('ALTER TABLE work_man DROP FOREIGN KEY FK_13CCC044BF396750');
        $this->addSql('ALTER TABLE researcher_director DROP FOREIGN KEY FK_C9B0AA1DBF396750');
        $this->addSql('ALTER TABLE sales_man_particular DROP FOREIGN KEY FK_24DADE63BF396750');
        $this->addSql('ALTER TABLE production_lign DROP FOREIGN KEY FK_4C149D23C7AF27D2');
        $this->addSql('ALTER TABLE product_life DROP FOREIGN KEY FK_94251C5F4584665A');
        $this->addSql('ALTER TABLE socity DROP FOREIGN KEY FK_2B09E378E48FD905');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADE48FD905');
        $this->addSql('DROP TABLE production_unit');
        $this->addSql('DROP TABLE production_lign');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE socity');
        $this->addSql('DROP TABLE human_resource');
        $this->addSql('DROP TABLE administration');
        $this->addSql('DROP TABLE factory');
        $this->addSql('DROP TABLE sales_man');
        $this->addSql('DROP TABLE sales_man_professional');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_life');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE researcher');
        $this->addSql('DROP TABLE production');
        $this->addSql('DROP TABLE production_cadre');
        $this->addSql('DROP TABLE production_director');
        $this->addSql('DROP TABLE sales_man_director');
        $this->addSql('DROP TABLE technician');
        $this->addSql('DROP TABLE work_man');
        $this->addSql('DROP TABLE researcher_director');
        $this->addSql('DROP TABLE sales_man_particular');
    }
}
