<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240322114550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preference DROP FOREIGN KEY FK_5D69B053EAF07004');
        $this->addSql('DROP INDEX IDX_5D69B053EAF07004 ON preference');
        $this->addSql('ALTER TABLE preference CHANGE idutilisateur_id utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE preference ADD CONSTRAINT FK_5D69B053FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_5D69B053FB88E14F ON preference (utilisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preference DROP FOREIGN KEY FK_5D69B053FB88E14F');
        $this->addSql('DROP INDEX IDX_5D69B053FB88E14F ON preference');
        $this->addSql('ALTER TABLE preference CHANGE utilisateur_id idutilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE preference ADD CONSTRAINT FK_5D69B053EAF07004 FOREIGN KEY (idutilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_5D69B053EAF07004 ON preference (idutilisateur_id)');
    }
}
