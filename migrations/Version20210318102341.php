<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210318102341 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appartenir DROP FOREIGN KEY appartenir_ibfk_2');
        $this->addSql('ALTER TABLE creer DROP FOREIGN KEY creer_ibfk_1');
        $this->addSql('ALTER TABLE generer DROP FOREIGN KEY generer_ibfk_1');
        $this->addSql('ALTER TABLE appartenir DROP FOREIGN KEY appartenir_ibfk_1');
        $this->addSql('ALTER TABLE contenir DROP FOREIGN KEY contenir_ibfk_1');
        $this->addSql('ALTER TABLE incorporer DROP FOREIGN KEY incorporer_ibfk_2');
        $this->addSql('ALTER TABLE personnel DROP FOREIGN KEY personnel_ibfk_1');
        $this->addSql('ALTER TABLE effectuer DROP FOREIGN KEY effectuer_ibfk_1');
        $this->addSql('ALTER TABLE creer DROP FOREIGN KEY creer_ibfk_2');
        $this->addSql('ALTER TABLE effectuer DROP FOREIGN KEY effectuer_ibfk_2');
        $this->addSql('ALTER TABLE generer DROP FOREIGN KEY generer_ibfk_2');
        $this->addSql('DROP TABLE appartenir');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE contenir');
        $this->addSql('DROP TABLE creer');
        $this->addSql('DROP TABLE effectuer');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE generer');
        $this->addSql('DROP TABLE personnel');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vente');
        $this->addSql('DROP INDEX idProduit ON incorporer');
        $this->addSql('DROP INDEX idPanier ON incorporer');
        $this->addSql('DROP INDEX IDX_54CA1E32391C87D5 ON incorporer');
        $this->addSql('ALTER TABLE incorporer DROP idPanier, DROP idProduit');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appartenir (idProduit INT NOT NULL, Id_Categorie INT NOT NULL, INDEX Id_Categorie (Id_Categorie), INDEX IDX_A2A0D90C391C87D5 (idProduit), PRIMARY KEY(idProduit, Id_Categorie)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE categorie (Id_Categorie INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, libelle VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(Id_Categorie)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE contenir (id INT AUTO_INCREMENT NOT NULL, idProduit INT NOT NULL, idPanier INT NOT NULL, quantiter VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, UNIQUE INDEX idProduit (idProduit, idPanier), INDEX idPanier (idPanier), INDEX IDX_3C914DFD391C87D5 (idProduit), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE creer (idVente INT NOT NULL, Id_Facture INT NOT NULL, INDEX Id_Facture (Id_Facture), INDEX IDX_311B14AE9F4E6951 (idVente), PRIMARY KEY(idVente, Id_Facture)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE effectuer (id INT AUTO_INCREMENT NOT NULL, idUser INT NOT NULL, idVente INT NOT NULL, UNIQUE INDEX idUser (idUser, idVente), INDEX idVente (idVente), INDEX IDX_98528150FE6E88D7 (idUser), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE facture (Id_Facture INT AUTO_INCREMENT NOT NULL, numero_facture VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, montant_facture INT NOT NULL, facture_pdf BLOB NOT NULL, PRIMARY KEY(Id_Facture)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE generer (id INT AUTO_INCREMENT NOT NULL, idVente INT NOT NULL, idPersonnel INT NOT NULL, UNIQUE INDEX idVente (idVente, idPersonnel), INDEX idPersonnel (idPersonnel), INDEX IDX_504ACE2D9F4E6951 (idVente), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE personnel (id INT AUTO_INCREMENT NOT NULL, id_profil INT NOT NULL, nom VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, prenom VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, num_tel VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, UNIQUE INDEX id_profil (id_profil), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE produit (idProduit INT AUTO_INCREMENT NOT NULL, nom_produit VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, tarif_produit INT DEFAULT NULL, stock INT DEFAULT NULL, libelle VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, popularite INT DEFAULT NULL, date_apparition DATETIME DEFAULT NULL, image LONGBLOB DEFAULT NULL, PRIMARY KEY(idProduit)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE profil (idProfil INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, password VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, num_telephone VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, email VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, permission INT NOT NULL, PRIMARY KEY(idProfil)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles JSON NOT NULL, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, num_tel VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, pseudonyme VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE vente (idVente INT AUTO_INCREMENT NOT NULL, numero_commande VARCHAR(1024) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, date_vente DATE DEFAULT NULL, PRIMARY KEY(idVente)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE appartenir ADD CONSTRAINT appartenir_ibfk_1 FOREIGN KEY (idProduit) REFERENCES produit (idProduit)');
        $this->addSql('ALTER TABLE appartenir ADD CONSTRAINT appartenir_ibfk_2 FOREIGN KEY (Id_Categorie) REFERENCES categorie (Id_Categorie)');
        $this->addSql('ALTER TABLE contenir ADD CONSTRAINT contenir_ibfk_1 FOREIGN KEY (idProduit) REFERENCES produit (idProduit)');
        $this->addSql('ALTER TABLE contenir ADD CONSTRAINT contenir_ibfk_2 FOREIGN KEY (idPanier) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE creer ADD CONSTRAINT creer_ibfk_1 FOREIGN KEY (Id_Facture) REFERENCES facture (Id_Facture)');
        $this->addSql('ALTER TABLE creer ADD CONSTRAINT creer_ibfk_2 FOREIGN KEY (idVente) REFERENCES vente (idVente)');
        $this->addSql('ALTER TABLE effectuer ADD CONSTRAINT effectuer_ibfk_1 FOREIGN KEY (idUser) REFERENCES user (id)');
        $this->addSql('ALTER TABLE effectuer ADD CONSTRAINT effectuer_ibfk_2 FOREIGN KEY (idVente) REFERENCES vente (idVente)');
        $this->addSql('ALTER TABLE generer ADD CONSTRAINT generer_ibfk_1 FOREIGN KEY (idPersonnel) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE generer ADD CONSTRAINT generer_ibfk_2 FOREIGN KEY (idVente) REFERENCES vente (idVente)');
        $this->addSql('ALTER TABLE personnel ADD CONSTRAINT personnel_ibfk_1 FOREIGN KEY (id_profil) REFERENCES profil (idProfil)');
        $this->addSql('ALTER TABLE incorporer ADD idPanier INT NOT NULL, ADD idProduit INT NOT NULL');
        $this->addSql('ALTER TABLE incorporer ADD CONSTRAINT incorporer_ibfk_2 FOREIGN KEY (idProduit) REFERENCES produit (idProduit)');
        $this->addSql('CREATE UNIQUE INDEX idProduit ON incorporer (idProduit, idPanier)');
        $this->addSql('CREATE INDEX idPanier ON incorporer (idPanier)');
        $this->addSql('CREATE INDEX IDX_54CA1E32391C87D5 ON incorporer (idProduit)');
    }
}
