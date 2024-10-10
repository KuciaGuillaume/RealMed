<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241010024050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE secondary_effect_molecule (secondary_effect_id INT NOT NULL, molecule_id INT NOT NULL, PRIMARY KEY(secondary_effect_id, molecule_id))');
        $this->addSql('CREATE INDEX IDX_A501C8336ACDFD42 ON secondary_effect_molecule (secondary_effect_id)');
        $this->addSql('CREATE INDEX IDX_A501C833DAFCA214 ON secondary_effect_molecule (molecule_id)');
        $this->addSql('ALTER TABLE secondary_effect_molecule ADD CONSTRAINT FK_A501C8336ACDFD42 FOREIGN KEY (secondary_effect_id) REFERENCES secondary_effect (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE secondary_effect_molecule ADD CONSTRAINT FK_A501C833DAFCA214 FOREIGN KEY (molecule_id) REFERENCES molecule (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE medicine ADD image_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE medicine ADD description VARCHAR(1600) DEFAULT NULL');
        $this->addSql('ALTER TABLE molecule ADD allergies VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE secondary_effect_molecule DROP CONSTRAINT FK_A501C8336ACDFD42');
        $this->addSql('ALTER TABLE secondary_effect_molecule DROP CONSTRAINT FK_A501C833DAFCA214');
        $this->addSql('DROP TABLE secondary_effect_molecule');
        $this->addSql('ALTER TABLE medicine DROP image_url');
        $this->addSql('ALTER TABLE medicine DROP description');
        $this->addSql('ALTER TABLE molecule DROP allergies');
    }
}
