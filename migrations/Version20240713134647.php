<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240713134647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entity_a (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entity_b (id INT AUTO_INCREMENT NOT NULL, a_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_3D3391E3BDE5358 (a_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entity_b ADD CONSTRAINT FK_3D3391E3BDE5358 FOREIGN KEY (a_id) REFERENCES entity_a (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entity_b DROP FOREIGN KEY FK_3D3391E3BDE5358');
        $this->addSql('DROP TABLE entity_a');
        $this->addSql('DROP TABLE entity_b');
    }
}
