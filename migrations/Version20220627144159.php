<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220627144159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0D6885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_EFE35A0D6885AC1B ON burger (gestionnaire_id)');
        $this->addSql('ALTER TABLE commande ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D6885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D6885AC1B ON commande (gestionnaire_id)');
        $this->addSql('ALTER TABLE complement ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE complement ADD CONSTRAINT FK_F8A41E346885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_F8A41E346885AC1B ON complement (gestionnaire_id)');
        $this->addSql('ALTER TABLE gestionnaire ADD livreur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gestionnaire ADD CONSTRAINT FK_F4461B20F8646701 FOREIGN KEY (livreur_id) REFERENCES livreur (id)');
        $this->addSql('CREATE INDEX IDX_F4461B20F8646701 ON gestionnaire (livreur_id)');
        $this->addSql('ALTER TABLE livraison ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F6885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_A60C9F1F6885AC1B ON livraison (gestionnaire_id)');
        $this->addSql('ALTER TABLE menu ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A936885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_7D053A936885AC1B ON menu (gestionnaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0D6885AC1B');
        $this->addSql('DROP INDEX IDX_EFE35A0D6885AC1B ON burger');
        $this->addSql('ALTER TABLE burger DROP gestionnaire_id');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D6885AC1B');
        $this->addSql('DROP INDEX IDX_6EEAA67D6885AC1B ON commande');
        $this->addSql('ALTER TABLE commande DROP gestionnaire_id');
        $this->addSql('ALTER TABLE complement DROP FOREIGN KEY FK_F8A41E346885AC1B');
        $this->addSql('DROP INDEX IDX_F8A41E346885AC1B ON complement');
        $this->addSql('ALTER TABLE complement DROP gestionnaire_id');
        $this->addSql('ALTER TABLE gestionnaire DROP FOREIGN KEY FK_F4461B20F8646701');
        $this->addSql('DROP INDEX IDX_F4461B20F8646701 ON gestionnaire');
        $this->addSql('ALTER TABLE gestionnaire DROP livreur_id');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F6885AC1B');
        $this->addSql('DROP INDEX IDX_A60C9F1F6885AC1B ON livraison');
        $this->addSql('ALTER TABLE livraison DROP gestionnaire_id');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A936885AC1B');
        $this->addSql('DROP INDEX IDX_7D053A936885AC1B ON menu');
        $this->addSql('ALTER TABLE menu DROP gestionnaire_id');
    }
}
