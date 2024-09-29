<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240928212733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produto (id INT AUTO_INCREMENT NOT NULL, categoria_id_id INT DEFAULT NULL, nome VARCHAR(100) NOT NULL, descricao LONGTEXT DEFAULT NULL, data_cadastro DATETIME DEFAULT NULL, quantidade_inicial INT DEFAULT NULL, quantidade_disponivel INT DEFAULT NULL, valor INT DEFAULT NULL, INDEX IDX_5CAC49D77E735794 (categoria_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produto ADD CONSTRAINT FK_5CAC49D77E735794 FOREIGN KEY (categoria_id_id) REFERENCES categoria (id)');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_YES ON usuario');
        $this->addSql('ALTER TABLE usuario CHANGE yes email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON usuario (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produto DROP FOREIGN KEY FK_5CAC49D77E735794');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE produto');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL ON usuario');
        $this->addSql('ALTER TABLE usuario CHANGE email yes VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_YES ON usuario (yes)');
    }
}
