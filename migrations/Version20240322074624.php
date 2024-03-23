<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240322074624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CC29B94428');
        $this->addSql('DROP INDEX IDX_EF85A2CC29B94428 ON favori');
        $this->addSql('ALTER TABLE favori CHANGE idsite_id site_id INT NOT NULL');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CCF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('CREATE INDEX IDX_EF85A2CCF6BD1646 ON favori (site_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CCF6BD1646');
        $this->addSql('DROP INDEX IDX_EF85A2CCF6BD1646 ON favori');
        $this->addSql('ALTER TABLE favori CHANGE site_id idsite_id INT NOT NULL');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CC29B94428 FOREIGN KEY (idsite_id) REFERENCES site (id)');
        $this->addSql('CREATE INDEX IDX_EF85A2CC29B94428 ON favori (idsite_id)');
    }
}
