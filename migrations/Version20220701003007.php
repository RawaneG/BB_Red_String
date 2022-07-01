<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220701003007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE taille_boisson (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taille_boisson_boissons (taille_boisson_id INT NOT NULL, boissons_id INT NOT NULL, INDEX IDX_99F7FD08421F13F (taille_boisson_id), INDEX IDX_99F7FD07366CD21 (boissons_id), PRIMARY KEY(taille_boisson_id, boissons_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taille_boisson_menu (taille_boisson_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_860C40928421F13F (taille_boisson_id), INDEX IDX_860C4092CCD7E912 (menu_id), PRIMARY KEY(taille_boisson_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE taille_boisson_boissons ADD CONSTRAINT FK_99F7FD08421F13F FOREIGN KEY (taille_boisson_id) REFERENCES taille_boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille_boisson_boissons ADD CONSTRAINT FK_99F7FD07366CD21 FOREIGN KEY (boissons_id) REFERENCES boissons (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille_boisson_menu ADD CONSTRAINT FK_860C40928421F13F FOREIGN KEY (taille_boisson_id) REFERENCES taille_boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille_boisson_menu ADD CONSTRAINT FK_860C4092CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE boissons_menu');
        $this->addSql('ALTER TABLE boissons DROP type_boisson, DROP taille');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taille_boisson_boissons DROP FOREIGN KEY FK_99F7FD08421F13F');
        $this->addSql('ALTER TABLE taille_boisson_menu DROP FOREIGN KEY FK_860C40928421F13F');
        $this->addSql('CREATE TABLE boissons_menu (boissons_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_7D22F48D7366CD21 (boissons_id), INDEX IDX_7D22F48DCCD7E912 (menu_id), PRIMARY KEY(boissons_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE boissons_menu ADD CONSTRAINT FK_7D22F48DCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boissons_menu ADD CONSTRAINT FK_7D22F48D7366CD21 FOREIGN KEY (boissons_id) REFERENCES boissons (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE taille_boisson');
        $this->addSql('DROP TABLE taille_boisson_boissons');
        $this->addSql('DROP TABLE taille_boisson_menu');
        $this->addSql('ALTER TABLE boissons ADD type_boisson VARCHAR(255) NOT NULL, ADD taille VARCHAR(255) NOT NULL');
    }
}
