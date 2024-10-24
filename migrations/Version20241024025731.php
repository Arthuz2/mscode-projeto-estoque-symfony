<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241024025731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categoria CHANGE atualizado_em atualizado_em DATETIME DEFAULT NULL, CHANGE criado_em criado_em DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE produto CHANGE atualizado_em atualizado_em DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produto CHANGE atualizado_em atualizado_em DATETIME NOT NULL');
        $this->addSql('ALTER TABLE categoria CHANGE atualizado_em atualizado_em DATETIME NOT NULL, CHANGE criado_em criado_em DATETIME NOT NULL');
    }
}
