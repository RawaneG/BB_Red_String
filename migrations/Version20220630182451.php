<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630182451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boissons CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE boissons ADD CONSTRAINT FK_13E865EEBF396750 FOREIGN KEY (id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE frites CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE frites ADD CONSTRAINT FK_282D392ABF396750 FOREIGN KEY (id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A936885AC1B');
        $this->addSql('DROP INDEX IDX_7D053A936885AC1B ON menu');
        $this->addSql('ALTER TABLE menu DROP gestionnaire_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boissons DROP FOREIGN KEY FK_13E865EEBF396750');
        $this->addSql('ALTER TABLE boissons CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE frites DROP FOREIGN KEY FK_282D392ABF396750');
        $this->addSql('ALTER TABLE frites CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE menu ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A936885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_7D053A936885AC1B ON menu (gestionnaire_id)');
    }
}
