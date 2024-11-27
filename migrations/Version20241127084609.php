<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241127084609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout relation entre rappel et categorie';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rappel ADD categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE rappel ADD CONSTRAINT FK_303A29C9BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_303A29C9BCF5E72D ON rappel (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rappel DROP FOREIGN KEY FK_303A29C9BCF5E72D');
        $this->addSql('DROP INDEX IDX_303A29C9BCF5E72D ON rappel');
        $this->addSql('ALTER TABLE rappel DROP categorie_id');
    }
}
