<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628222943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boissons_menu (boissons_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_7D22F48D7366CD21 (boissons_id), INDEX IDX_7D22F48DCCD7E912 (menu_id), PRIMARY KEY(boissons_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE frites_menu (frites_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_4BBAB11F18C0D7E1 (frites_id), INDEX IDX_4BBAB11FCCD7E912 (menu_id), PRIMARY KEY(frites_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boissons_menu ADD CONSTRAINT FK_7D22F48D7366CD21 FOREIGN KEY (boissons_id) REFERENCES boissons (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boissons_menu ADD CONSTRAINT FK_7D22F48DCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE frites_menu ADD CONSTRAINT FK_4BBAB11F18C0D7E1 FOREIGN KEY (frites_id) REFERENCES frites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE frites_menu ADD CONSTRAINT FK_4BBAB11FCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boissons ADD taille VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE boissons_menu');
        $this->addSql('DROP TABLE frites_menu');
        $this->addSql('ALTER TABLE boissons DROP taille');
    }
}
