<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220701095235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taille_boisson ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE taille_boisson ADD CONSTRAINT FK_59FAC2686885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_59FAC2686885AC1B ON taille_boisson (gestionnaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taille_boisson DROP FOREIGN KEY FK_59FAC2686885AC1B');
        $this->addSql('DROP INDEX IDX_59FAC2686885AC1B ON taille_boisson');
        $this->addSql('ALTER TABLE taille_boisson DROP gestionnaire_id');
    }
}
