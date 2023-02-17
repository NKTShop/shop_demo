<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215103945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD categorys_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA96778EC FOREIGN KEY (categorys_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADA96778EC ON product (categorys_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA96778EC');
        $this->addSql('DROP INDEX IDX_D34A04ADA96778EC ON product');
        $this->addSql('ALTER TABLE product DROP categorys_id');
    }
}
