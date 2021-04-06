<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210318103035 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE personnel');
        $this->addSql('ALTER TABLE appartenir DROP FOREIGN KEY appartenir_ibfk_1');
        $this->addSql('DROP INDEX idProduit ON appartenir');
        $this->addSql('ALTER TABLE appartenir ADD PRIMARY KEY (idProduit, Id_Categorie)');
        $this->addSql('ALTER TABLE creer DROP FOREIGN KEY creer_ibfk_1');
        $this->addSql('ALTER TABLE creer DROP FOREIGN KEY creer_ibfk_2');
        $this->addSql('DROP INDEX idVente ON creer');
        $this->addSql('ALTER TABLE creer ADD PRIMARY KEY (idVente, Id_Facture)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personnel (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, prenom VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, num_tel VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, id_profil INT NOT NULL, UNIQUE INDEX id_profil (id_profil), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE appartenir DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE appartenir ADD CONSTRAINT appartenir_ibfk_1 FOREIGN KEY (idProduit) REFERENCES produit (idProduit)');
        $this->addSql('CREATE UNIQUE INDEX idProduit ON appartenir (idProduit)');
        $this->addSql('ALTER TABLE creer DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE creer ADD CONSTRAINT creer_ibfk_1 FOREIGN KEY (idVente) REFERENCES vente (idVente)');
        $this->addSql('ALTER TABLE creer ADD CONSTRAINT creer_ibfk_2 FOREIGN KEY (Id_Facture) REFERENCES facture (Id_Facture)');
        $this->addSql('CREATE UNIQUE INDEX idVente ON creer (idVente)');
    }
}
