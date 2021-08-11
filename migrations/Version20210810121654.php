<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210810121654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD products_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C16C8A81A9 FOREIGN KEY (products_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_64C19C16C8A81A9 ON category (products_id)');
        $this->addSql('ALTER TABLE product ADD favoris TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C16C8A81A9');
        $this->addSql('DROP INDEX IDX_64C19C16C8A81A9 ON category');
        $this->addSql('ALTER TABLE category DROP products_id');
        $this->addSql('ALTER TABLE product DROP favoris');
    }
}
