<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241024022914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carrinho (id INT AUTO_INCREMENT NOT NULL, cliente_id INT DEFAULT NULL, usuario_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, valor_total INT NOT NULL, criado_em DATETIME NOT NULL, atualizado_em DATETIME DEFAULT NULL, finalizado_em DATETIME DEFAULT NULL, INDEX IDX_A731E3C0DE734E51 (cliente_id), INDEX IDX_A731E3C0DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(100) NOT NULL, cpf VARCHAR(11) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, produto_id INT DEFAULT NULL, carrinho_id INT DEFAULT NULL, valor INT NOT NULL, UNIQUE INDEX UNIQ_1F1B251E105CFD56 (produto_id), INDEX IDX_1F1B251ED363F3C2 (carrinho_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carrinho ADD CONSTRAINT FK_A731E3C0DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE carrinho ADD CONSTRAINT FK_A731E3C0DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251ED363F3C2 FOREIGN KEY (carrinho_id) REFERENCES carrinho (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carrinho DROP FOREIGN KEY FK_A731E3C0DE734E51');
        $this->addSql('ALTER TABLE carrinho DROP FOREIGN KEY FK_A731E3C0DB38439E');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E105CFD56');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251ED363F3C2');
        $this->addSql('DROP TABLE carrinho');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE item');
    }
}
