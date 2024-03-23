<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240322072930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favori (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, idsite_id INT NOT NULL, ranking INT NOT NULL, INDEX IDX_EF85A2CCFB88E14F (utilisateur_id), INDEX IDX_EF85A2CC29B94428 (idsite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CCFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CC29B94428 FOREIGN KEY (idsite_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE site_utilisateur DROP FOREIGN KEY FK_F6325C03FB88E14F');
        $this->addSql('ALTER TABLE site_utilisateur DROP FOREIGN KEY FK_F6325C03F6BD1646');
        $this->addSql('DROP TABLE site_utilisateur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE site_utilisateur (site_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_F6325C03F6BD1646 (site_id), INDEX IDX_F6325C03FB88E14F (utilisateur_id), PRIMARY KEY(site_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE site_utilisateur ADD CONSTRAINT FK_F6325C03FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE site_utilisateur ADD CONSTRAINT FK_F6325C03F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CCFB88E14F');
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CC29B94428');
        $this->addSql('DROP TABLE favori');
    }
}
