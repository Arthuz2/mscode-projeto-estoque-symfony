<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241125014807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP INDEX UNIQ_1F1B251E105CFD56, ADD INDEX IDX_1F1B251E105CFD56 (produto_id)');
        $this->addSql('ALTER TABLE item CHANGE produto_id produto_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP INDEX IDX_1F1B251E105CFD56, ADD UNIQUE INDEX UNIQ_1F1B251E105CFD56 (produto_id)');
        $this->addSql('ALTER TABLE item CHANGE produto_id produto_id INT DEFAULT NULL');
    }
}
