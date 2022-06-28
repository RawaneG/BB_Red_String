<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628204121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalogue_burger DROP FOREIGN KEY FK_539DC5654A7843DC');
        $this->addSql('ALTER TABLE catalogue_menu DROP FOREIGN KEY FK_D630FC444A7843DC');
        $this->addSql('ALTER TABLE menu_complement DROP FOREIGN KEY FK_D909AAE640D9D0AA');
        $this->addSql('DROP TABLE catalogue');
        $this->addSql('DROP TABLE catalogue_burger');
        $this->addSql('DROP TABLE catalogue_menu');
        $this->addSql('DROP TABLE complement');
        $this->addSql('DROP TABLE menu_complement');
        $this->addSql('ALTER TABLE boissons DROP FOREIGN KEY FK_13E865EEBF396750');
        $this->addSql('ALTER TABLE boissons CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE frites DROP FOREIGN KEY FK_282D392ABF396750');
        $this->addSql('ALTER TABLE frites CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE catalogue (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE catalogue_burger (catalogue_id INT NOT NULL, burger_id INT NOT NULL, INDEX IDX_539DC5654A7843DC (catalogue_id), INDEX IDX_539DC56517CE5090 (burger_id), PRIMARY KEY(catalogue_id, burger_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE catalogue_menu (catalogue_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_D630FC444A7843DC (catalogue_id), INDEX IDX_D630FC44CCD7E912 (menu_id), PRIMARY KEY(catalogue_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE complement (id INT NOT NULL, gestionnaire_id INT DEFAULT NULL, INDEX IDX_F8A41E346885AC1B (gestionnaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE menu_complement (menu_id INT NOT NULL, complement_id INT NOT NULL, INDEX IDX_D909AAE6CCD7E912 (menu_id), INDEX IDX_D909AAE640D9D0AA (complement_id), PRIMARY KEY(menu_id, complement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE catalogue_burger ADD CONSTRAINT FK_539DC56517CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE catalogue_burger ADD CONSTRAINT FK_539DC5654A7843DC FOREIGN KEY (catalogue_id) REFERENCES catalogue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE catalogue_menu ADD CONSTRAINT FK_D630FC444A7843DC FOREIGN KEY (catalogue_id) REFERENCES catalogue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE catalogue_menu ADD CONSTRAINT FK_D630FC44CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE complement ADD CONSTRAINT FK_F8A41E346885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('ALTER TABLE complement ADD CONSTRAINT FK_F8A41E34BF396750 FOREIGN KEY (id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_complement ADD CONSTRAINT FK_D909AAE640D9D0AA FOREIGN KEY (complement_id) REFERENCES complement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_complement ADD CONSTRAINT FK_D909AAE6CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boissons CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE boissons ADD CONSTRAINT FK_13E865EEBF396750 FOREIGN KEY (id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE frites CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE frites ADD CONSTRAINT FK_282D392ABF396750 FOREIGN KEY (id) REFERENCES produit (id) ON DELETE CASCADE');
    }
}
