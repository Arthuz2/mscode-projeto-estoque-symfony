<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241023215222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E1F400551');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251ECDBF150D');
        $this->addSql('ALTER TABLE carrinho_usuario DROP FOREIGN KEY FK_13E23D13D363F3C2');
        $this->addSql('ALTER TABLE carrinho_usuario DROP FOREIGN KEY FK_13E23D13DB38439E');
        $this->addSql('ALTER TABLE carrinho_cliente DROP FOREIGN KEY FK_C59B166BD363F3C2');
        $this->addSql('ALTER TABLE carrinho_cliente DROP FOREIGN KEY FK_C59B166BDE734E51');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE carrinho_usuario');
        $this->addSql('DROP TABLE carrinho_cliente');
        $this->addSql('DROP TABLE carrinho');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cpf VARCHAR(11) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, produto_id_id INT NOT NULL, carrinho_id_id INT NOT NULL, quantidade INT NOT NULL, valor INT NOT NULL, INDEX IDX_1F1B251E1F400551 (carrinho_id_id), INDEX IDX_1F1B251ECDBF150D (produto_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE carrinho_usuario (carrinho_id INT NOT NULL, usuario_id INT NOT NULL, INDEX IDX_13E23D13DB38439E (usuario_id), INDEX IDX_13E23D13D363F3C2 (carrinho_id), PRIMARY KEY(carrinho_id, usuario_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE carrinho_cliente (carrinho_id INT NOT NULL, cliente_id INT NOT NULL, INDEX IDX_C59B166BDE734E51 (cliente_id), INDEX IDX_C59B166BD363F3C2 (carrinho_id), PRIMARY KEY(carrinho_id, cliente_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE carrinho (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, valor_total INT NOT NULL, criado_em DATETIME NOT NULL, atualizado_em DATETIME NOT NULL, finalizado_em DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E1F400551 FOREIGN KEY (carrinho_id_id) REFERENCES carrinho (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251ECDBF150D FOREIGN KEY (produto_id_id) REFERENCES produto (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE carrinho_usuario ADD CONSTRAINT FK_13E23D13D363F3C2 FOREIGN KEY (carrinho_id) REFERENCES carrinho (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE carrinho_usuario ADD CONSTRAINT FK_13E23D13DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE carrinho_cliente ADD CONSTRAINT FK_C59B166BD363F3C2 FOREIGN KEY (carrinho_id) REFERENCES carrinho (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE carrinho_cliente ADD CONSTRAINT FK_C59B166BDE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
