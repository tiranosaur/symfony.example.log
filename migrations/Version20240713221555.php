<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240713221555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entity_b ADD a_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entity_b ADD CONSTRAINT FK_3D3391E3BDE5358 FOREIGN KEY (a_id) REFERENCES entity_a (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3D3391E3BDE5358 ON entity_b (a_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entity_b DROP FOREIGN KEY FK_3D3391E3BDE5358');
        $this->addSql('DROP INDEX UNIQ_3D3391E3BDE5358 ON entity_b');
        $this->addSql('ALTER TABLE entity_b DROP a_id');
    }
}
