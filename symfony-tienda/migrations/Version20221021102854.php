<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221021102854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producto ADD tienda_id INT NOT NULL');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB061519BA6D46 FOREIGN KEY (tienda_id) REFERENCES tienda (id)');
        $this->addSql('CREATE INDEX IDX_A7BB061519BA6D46 ON producto (tienda_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB061519BA6D46');
        $this->addSql('DROP INDEX IDX_A7BB061519BA6D46 ON producto');
        $this->addSql('ALTER TABLE producto DROP tienda_id');
    }
}
