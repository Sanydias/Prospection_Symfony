<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240205154138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F18880D5F');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F6A3270D6');
        $this->addSql('DROP INDEX IDX_C0B9F90F6A3270D6 ON discussion');
        $this->addSql('DROP INDEX IDX_C0B9F90F18880D5F ON discussion');
        $this->addSql('ALTER TABLE discussion ADD idemmeteur_id INT NOT NULL, ADD idrecepteur_id INT NOT NULL, DROP id_emmeteur_id, DROP id_recepteur_id');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FB4E1CD8E FOREIGN KEY (idemmeteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F7DE60724 FOREIGN KEY (idrecepteur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_C0B9F90FB4E1CD8E ON discussion (idemmeteur_id)');
        $this->addSql('CREATE INDEX IDX_C0B9F90F7DE60724 ON discussion (idrecepteur_id)');
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CCBA82E7D0');
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CC2820BF36');
        $this->addSql('DROP INDEX IDX_EF85A2CC2820BF36 ON favori');
        $this->addSql('DROP INDEX IDX_EF85A2CCBA82E7D0 ON favori');
        $this->addSql('ALTER TABLE favori ADD idutlisateur_id INT NOT NULL, ADD idsite_id INT NOT NULL, DROP id_utlisateur_id, DROP id_site_id');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CC7D30216E FOREIGN KEY (idutlisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CC29B94428 FOREIGN KEY (idsite_id) REFERENCES site (id)');
        $this->addSql('CREATE INDEX IDX_EF85A2CC7D30216E ON favori (idutlisateur_id)');
        $this->addSql('CREATE INDEX IDX_EF85A2CC29B94428 ON favori (idsite_id)');
        $this->addSql('ALTER TABLE localisation ADD codecommuneinsee INT NOT NULL, ADD nomcommunepostal VARCHAR(50) NOT NULL, ADD codepostal INT NOT NULL, ADD libelleacheminement VARCHAR(50) NOT NULL, ADD codecommune INT NOT NULL, ADD nomcommune VARCHAR(50) NOT NULL, ADD nomcommunecomplet VARCHAR(50) NOT NULL, ADD codedepartement INT NOT NULL, ADD nomdepartement VARCHAR(50) NOT NULL, ADD coderegion INT NOT NULL, ADD nomregion VARCHAR(50) NOT NULL, DROP code_commune_insee, DROP nom_commune_postal, DROP code_postal, DROP libelle_acheminement, DROP code_commune, DROP nom_commune, DROP nom_commune_complet, DROP code_departement, DROP nom_departement, DROP code_region, DROP nom_region, CHANGE ligne_5 ligne5 VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE preference DROP FOREIGN KEY FK_5D69B053C6EE5C49');
        $this->addSql('DROP INDEX IDX_5D69B053C6EE5C49 ON preference');
        $this->addSql('ALTER TABLE preference CHANGE id_utilisateur_id idutilisateur_id INT NOT NULL, CHANGE type_preference typepreference VARCHAR(11) NOT NULL');
        $this->addSql('ALTER TABLE preference ADD CONSTRAINT FK_5D69B053EAF07004 FOREIGN KEY (idutilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_5D69B053EAF07004 ON preference (idutilisateur_id)');
        $this->addSql('ALTER TABLE site ADD tempsinitial VARCHAR(11) DEFAULT NULL, ADD tempsrestant VARCHAR(11) DEFAULT NULL, DROP temps_initial, DROP temps_restant, CHANGE timer timer TINYINT(1) NOT NULL, CHANGE type_timer typetimer VARCHAR(5) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90FB4E1CD8E');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F7DE60724');
        $this->addSql('DROP INDEX IDX_C0B9F90FB4E1CD8E ON discussion');
        $this->addSql('DROP INDEX IDX_C0B9F90F7DE60724 ON discussion');
        $this->addSql('ALTER TABLE discussion ADD id_emmeteur_id INT NOT NULL, ADD id_recepteur_id INT NOT NULL, DROP idemmeteur_id, DROP idrecepteur_id');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F18880D5F FOREIGN KEY (id_recepteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F6A3270D6 FOREIGN KEY (id_emmeteur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_C0B9F90F6A3270D6 ON discussion (id_emmeteur_id)');
        $this->addSql('CREATE INDEX IDX_C0B9F90F18880D5F ON discussion (id_recepteur_id)');
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CC7D30216E');
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CC29B94428');
        $this->addSql('DROP INDEX IDX_EF85A2CC7D30216E ON favori');
        $this->addSql('DROP INDEX IDX_EF85A2CC29B94428 ON favori');
        $this->addSql('ALTER TABLE favori ADD id_utlisateur_id INT NOT NULL, ADD id_site_id INT NOT NULL, DROP idutlisateur_id, DROP idsite_id');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CCBA82E7D0 FOREIGN KEY (id_utlisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CC2820BF36 FOREIGN KEY (id_site_id) REFERENCES site (id)');
        $this->addSql('CREATE INDEX IDX_EF85A2CC2820BF36 ON favori (id_site_id)');
        $this->addSql('CREATE INDEX IDX_EF85A2CCBA82E7D0 ON favori (id_utlisateur_id)');
        $this->addSql('ALTER TABLE localisation ADD code_commune_insee INT NOT NULL, ADD nom_commune_postal VARCHAR(50) NOT NULL, ADD code_postal INT NOT NULL, ADD libelle_acheminement VARCHAR(50) NOT NULL, ADD code_commune INT NOT NULL, ADD nom_commune VARCHAR(50) NOT NULL, ADD nom_commune_complet VARCHAR(50) NOT NULL, ADD code_departement INT NOT NULL, ADD nom_departement VARCHAR(50) NOT NULL, ADD code_region INT NOT NULL, ADD nom_region VARCHAR(50) NOT NULL, DROP codecommuneinsee, DROP nomcommunepostal, DROP codepostal, DROP libelleacheminement, DROP codecommune, DROP nomcommune, DROP nomcommunecomplet, DROP codedepartement, DROP nomdepartement, DROP coderegion, DROP nomregion, CHANGE ligne5 ligne_5 VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE preference DROP FOREIGN KEY FK_5D69B053EAF07004');
        $this->addSql('DROP INDEX IDX_5D69B053EAF07004 ON preference');
        $this->addSql('ALTER TABLE preference CHANGE idutilisateur_id id_utilisateur_id INT NOT NULL, CHANGE typepreference type_preference VARCHAR(11) NOT NULL');
        $this->addSql('ALTER TABLE preference ADD CONSTRAINT FK_5D69B053C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_5D69B053C6EE5C49 ON preference (id_utilisateur_id)');
        $this->addSql('ALTER TABLE site ADD temps_initial VARCHAR(11) DEFAULT NULL, ADD temps_restant VARCHAR(11) DEFAULT NULL, DROP tempsinitial, DROP tempsrestant, CHANGE timer timer SMALLINT NOT NULL, CHANGE typetimer type_timer VARCHAR(5) DEFAULT NULL');
    }
}
