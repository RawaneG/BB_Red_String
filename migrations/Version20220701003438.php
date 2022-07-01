<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220701003438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gestionnaire DROP FOREIGN KEY FK_F4461B20F8646701');
        $this->addSql('DROP INDEX IDX_F4461B20F8646701 ON gestionnaire');
        $this->addSql('ALTER TABLE gestionnaire DROP livreur_id');
        $this->addSql('ALTER TABLE livreur ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livreur ADD CONSTRAINT FK_EB7A4E6D6885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_EB7A4E6D6885AC1B ON livreur (gestionnaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gestionnaire ADD livreur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gestionnaire ADD CONSTRAINT FK_F4461B20F8646701 FOREIGN KEY (livreur_id) REFERENCES livreur (id)');
        $this->addSql('CREATE INDEX IDX_F4461B20F8646701 ON gestionnaire (livreur_id)');
        $this->addSql('ALTER TABLE livreur DROP FOREIGN KEY FK_EB7A4E6D6885AC1B');
        $this->addSql('DROP INDEX IDX_EB7A4E6D6885AC1B ON livreur');
        $this->addSql('ALTER TABLE livreur DROP gestionnaire_id');
    }
}
