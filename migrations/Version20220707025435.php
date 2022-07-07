<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707025435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD prix INT NOT NULL');
        // $this->addSql('ALTER TABLE ligne_de_commande DROP INDEX IDX_7982ACE6F347EFB, ADD UNIQUE INDEX UNIQ_7982ACE6F347EFB (produit_id)');
        // $this->addSql('DROP INDEX UNIQ_3FB920788421F13F ON menu_boissons');
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_3FB920788421F13F ON menu_boissons (taille_boisson_id)');
        // $this->addSql('DROP INDEX UNIQ_ED8B4D5217CE5090 ON menu_burgers');
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_ED8B4D5217CE5090 ON menu_burgers (burger_id)');
        // $this->addSql('DROP INDEX UNIQ_FB6A61F2BE00B4D9 ON menu_frites');
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_FB6A61F2BE00B4D9 ON menu_frites (frite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP prix');
        // $this->addSql('ALTER TABLE ligne_de_commande DROP INDEX UNIQ_7982ACE6F347EFB, ADD INDEX IDX_7982ACE6F347EFB (produit_id)');
        // $this->addSql('DROP INDEX UNIQ_3FB920788421F13F ON menu_boissons');
        // $this->addSql('CREATE INDEX UNIQ_3FB920788421F13F ON menu_boissons (taille_boisson_id)');
        // $this->addSql('DROP INDEX UNIQ_ED8B4D5217CE5090 ON menu_burgers');
        // $this->addSql('CREATE INDEX UNIQ_ED8B4D5217CE5090 ON menu_burgers (burger_id)');
        // $this->addSql('DROP INDEX UNIQ_FB6A61F2BE00B4D9 ON menu_frites');
        // $this->addSql('CREATE INDEX UNIQ_FB6A61F2BE00B4D9 ON menu_frites (frite_id)');
    }
}
