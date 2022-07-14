<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713114009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ligne_boisson (id INT AUTO_INCREMENT NOT NULL, taille_boisson_id INT DEFAULT NULL, menu_id INT DEFAULT NULL, quantite INT NOT NULL, prix INT NOT NULL, UNIQUE INDEX UNIQ_140EF6748421F13F (taille_boisson_id), INDEX IDX_140EF674CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ligne_boisson ADD CONSTRAINT FK_140EF6748421F13F FOREIGN KEY (taille_boisson_id) REFERENCES taille_boisson (id)');
        $this->addSql('ALTER TABLE ligne_boisson ADD CONSTRAINT FK_140EF674CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        // $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE6F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_7982ACE6F347EFB ON ligne_de_commande (produit_id)');
        // $this->addSql('DROP INDEX UNIQ_3FB920788421F13F ON menu_boissons');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3FB920788421F13F ON menu_boissons (taille_boisson_id)');
        // $this->addSql('DROP INDEX UNIQ_ED8B4D5217CE5090 ON menu_burgers');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ED8B4D5217CE5090 ON menu_burgers (burger_id)');
        // $this->addSql('DROP INDEX UNIQ_FB6A61F2BE00B4D9 ON menu_frites');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FB6A61F2BE00B4D9 ON menu_frites (frite_id)');
        // $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC276885AC1B');
        // $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC276885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('DROP TABLE ligne_boisson');
        // $this->addSql('ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE6F347EFB');
        // $this->addSql('DROP INDEX UNIQ_7982ACE6F347EFB ON ligne_de_commande');
        // $this->addSql('DROP INDEX UNIQ_3FB920788421F13F ON menu_boissons');
        $this->addSql('CREATE INDEX UNIQ_3FB920788421F13F ON menu_boissons (taille_boisson_id)');
        // $this->addSql('DROP INDEX UNIQ_ED8B4D5217CE5090 ON menu_burgers');
        $this->addSql('CREATE INDEX UNIQ_ED8B4D5217CE5090 ON menu_burgers (burger_id)');
        // $this->addSql('DROP INDEX UNIQ_FB6A61F2BE00B4D9 ON menu_frites');
        $this->addSql('CREATE INDEX UNIQ_FB6A61F2BE00B4D9 ON menu_frites (frite_id)');
        // $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC276885AC1B');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC276885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
