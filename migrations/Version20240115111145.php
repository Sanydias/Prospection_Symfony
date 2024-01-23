<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240115111145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, id_emmeteur_id INT NOT NULL, id_recepteur_id INT NOT NULL, contenu VARCHAR(500) NOT NULL, INDEX IDX_C0B9F90F6A3270D6 (id_emmeteur_id), INDEX IDX_C0B9F90F18880D5F (id_recepteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favori (id INT AUTO_INCREMENT NOT NULL, id_utlisateur_id INT NOT NULL, id_site_id INT NOT NULL, INDEX IDX_EF85A2CCBA82E7D0 (id_utlisateur_id), INDEX IDX_EF85A2CC2820BF36 (id_site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localisation (id INT AUTO_INCREMENT NOT NULL, code_commune_insee INT NOT NULL, nom_commune_postal VARCHAR(50) NOT NULL, code_postal INT NOT NULL, libelle_acheminement VARCHAR(50) NOT NULL, ligne_5 VARCHAR(50) DEFAULT NULL, latitude VARCHAR(15) NOT NULL, longitude VARCHAR(15) NOT NULL, code_commune INT NOT NULL, article VARCHAR(4) DEFAULT NULL, nom_commune VARCHAR(50) NOT NULL, nom_commune_complet VARCHAR(50) NOT NULL, code_departement INT NOT NULL, nom_departement VARCHAR(50) NOT NULL, code_region INT NOT NULL, nom_region VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE preference (id INT AUTO_INCREMENT NOT NULL, id_utilisateur_id INT NOT NULL, type_preference VARCHAR(11) NOT NULL, lieu VARCHAR(50) NOT NULL, INDEX IDX_5D69B053C6EE5C49 (id_utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, departement INT NOT NULL, commune VARCHAR(50) NOT NULL, lieuxdit VARCHAR(50) NOT NULL, interethistorique VARCHAR(50) NOT NULL, lien VARCHAR(250) DEFAULT NULL, timer SMALLINT NOT NULL, type_timer VARCHAR(5) DEFAULT NULL, temps_initial VARCHAR(11) DEFAULT NULL, temps_restant VARCHAR(11) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) DEFAULT NULL, prenom VARCHAR(50) DEFAULT NULL, sexe VARCHAR(5) NOT NULL, datedenaissance DATE NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(50) NOT NULL, photodeprofil VARCHAR(100) DEFAULT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', datedecreationducompte DATE NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F6A3270D6 FOREIGN KEY (id_emmeteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F18880D5F FOREIGN KEY (id_recepteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CCBA82E7D0 FOREIGN KEY (id_utlisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CC2820BF36 FOREIGN KEY (id_site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE preference ADD CONSTRAINT FK_5D69B053C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F6A3270D6');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F18880D5F');
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CCBA82E7D0');
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CC2820BF36');
        $this->addSql('ALTER TABLE preference DROP FOREIGN KEY FK_5D69B053C6EE5C49');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE favori');
        $this->addSql('DROP TABLE localisation');
        $this->addSql('DROP TABLE preference');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
