<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240317183841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, idemmeteur_id INT NOT NULL, idrecepteur_id INT NOT NULL, contenu VARCHAR(500) NOT NULL, INDEX IDX_C0B9F90FB4E1CD8E (idemmeteur_id), INDEX IDX_C0B9F90F7DE60724 (idrecepteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localisation (id INT AUTO_INCREMENT NOT NULL, codecommuneinsee INT NOT NULL, nomcommunepostal VARCHAR(50) NOT NULL, codepostal INT NOT NULL, libelleacheminement VARCHAR(50) NOT NULL, ligne5 VARCHAR(50) DEFAULT NULL, latitude VARCHAR(15) NOT NULL, longitude VARCHAR(15) NOT NULL, codecommune INT NOT NULL, article VARCHAR(4) DEFAULT NULL, nomcommune VARCHAR(50) NOT NULL, nomcommunecomplet VARCHAR(50) NOT NULL, codedepartement INT NOT NULL, nomdepartement VARCHAR(50) NOT NULL, coderegion INT NOT NULL, nomregion VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE preference (id INT AUTO_INCREMENT NOT NULL, idutilisateur_id INT NOT NULL, typepreference VARCHAR(11) NOT NULL, lieu VARCHAR(50) NOT NULL, INDEX IDX_5D69B053EAF07004 (idutilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, departement INT NOT NULL, commune VARCHAR(50) NOT NULL, lieuxdit VARCHAR(50) NOT NULL, interethistorique VARCHAR(50) NOT NULL, lien VARCHAR(250) DEFAULT NULL, timer TINYINT(1) NOT NULL, typetimer VARCHAR(5) DEFAULT NULL, tempsinitial VARCHAR(11) DEFAULT NULL, tempsrestant VARCHAR(11) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site_utilisateur (site_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_F6325C03F6BD1646 (site_id), INDEX IDX_F6325C03FB88E14F (utilisateur_id), PRIMARY KEY(site_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) DEFAULT NULL, prenom VARCHAR(50) DEFAULT NULL, sexe VARCHAR(5) DEFAULT NULL, datedenaissance DATE NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(50) NOT NULL, photodeprofil VARCHAR(100) DEFAULT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', datedecreationducompte DATE NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FB4E1CD8E FOREIGN KEY (idemmeteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F7DE60724 FOREIGN KEY (idrecepteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE preference ADD CONSTRAINT FK_5D69B053EAF07004 FOREIGN KEY (idutilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE site_utilisateur ADD CONSTRAINT FK_F6325C03F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE site_utilisateur ADD CONSTRAINT FK_F6325C03FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90FB4E1CD8E');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F7DE60724');
        $this->addSql('ALTER TABLE preference DROP FOREIGN KEY FK_5D69B053EAF07004');
        $this->addSql('ALTER TABLE site_utilisateur DROP FOREIGN KEY FK_F6325C03F6BD1646');
        $this->addSql('ALTER TABLE site_utilisateur DROP FOREIGN KEY FK_F6325C03FB88E14F');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE localisation');
        $this->addSql('DROP TABLE preference');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE site_utilisateur');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
