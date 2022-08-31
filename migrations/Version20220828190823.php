<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220828190823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD code INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE6F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7982ACE6F347EFB ON ligne_de_commande (produit_id)');
        $this->addSql('CREATE INDEX IDX_7982ACE682EA2E54 ON ligne_de_commande (commande_id)');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ED8B4D5217CE5090 ON menu_burgers (burger_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FB6A61F2BE00B4D9 ON menu_frites (frite_id)');
        $this->addSql('ALTER TABLE taille_boisson ADD CONSTRAINT FK_59FAC2686885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE commande DROP code');
        $this->addSql('CREATE INDEX FK_7982ACE682EA2E54 ON ligne_de_commande (commande_id)');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX UNIQ_ED8B4D5217CE5090 ON menu_burgers (burger_id)');
        $this->addSql('CREATE INDEX UNIQ_FB6A61F2BE00B4D9 ON menu_frites (frite_id)');
        $this->addSql('ALTER TABLE taille_boisson ADD CONSTRAINT FK_59FAC2686885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
