<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190304161731 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, technologic_level INT NOT NULL, buy_price INT NOT NULL, sale_price INT NOT NULL, quantity_discount INT NOT NULL, productior_activity_cost INT NOT NULL, research_cost INT NOT NULL, product_sale_type INT NOT NULL, product_max_number INT NOT NULL, price_discount INT NOT NULL, product_already_sales INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_life (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, cycle_life_number INT NOT NULL, product_cycle_life_number_max INT NOT NULL, cycle_duration INT NOT NULL, price_coeficient INT NOT NULL, publicity_coeficient INT NOT NULL, price_min_publicity_impact INT NOT NULL, price_max_publicity_impact INT NOT NULL, quality INT NOT NULL, INDEX IDX_94251C5F4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, tva INT NOT NULL, maxturn INT NOT NULL, turn INT NOT NULL, socity_number INT NOT NULL, smic INT NOT NULL, creat_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_life ADD CONSTRAINT FK_94251C5F4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product_life DROP FOREIGN KEY FK_94251C5F4584665A');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_life');
        $this->addSql('DROP TABLE game');
    }
}
