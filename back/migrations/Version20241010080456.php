<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241010080456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE secondary_effect_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE medicine_medicine (medicine_source INT NOT NULL, medicine_target INT NOT NULL, PRIMARY KEY(medicine_source, medicine_target))');
        $this->addSql('CREATE INDEX IDX_A234EC99C9975FF9 ON medicine_medicine (medicine_source)');
        $this->addSql('CREATE INDEX IDX_A234EC99D0720F76 ON medicine_medicine (medicine_target)');
        $this->addSql('CREATE TABLE secondary_effect (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, severity VARCHAR(255) DEFAULT NULL, severity_score INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE secondary_effect_molecule (secondary_effect_id INT NOT NULL, molecule_id INT NOT NULL, PRIMARY KEY(secondary_effect_id, molecule_id))');
        $this->addSql('CREATE INDEX IDX_A501C8336ACDFD42 ON secondary_effect_molecule (secondary_effect_id)');
        $this->addSql('CREATE INDEX IDX_A501C833DAFCA214 ON secondary_effect_molecule (molecule_id)');
        $this->addSql('ALTER TABLE medicine_medicine ADD CONSTRAINT FK_A234EC99C9975FF9 FOREIGN KEY (medicine_source) REFERENCES medicine (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE medicine_medicine ADD CONSTRAINT FK_A234EC99D0720F76 FOREIGN KEY (medicine_target) REFERENCES medicine (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE secondary_effect_molecule ADD CONSTRAINT FK_A501C8336ACDFD42 FOREIGN KEY (secondary_effect_id) REFERENCES secondary_effect (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE secondary_effect_molecule ADD CONSTRAINT FK_A501C833DAFCA214 FOREIGN KEY (molecule_id) REFERENCES molecule (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE medicine ALTER specific_conditions TYPE JSON');
        $this->addSql('COMMENT ON COLUMN medicine.specific_conditions IS NULL');
        $this->addSql('ALTER TABLE molecule ADD allergies VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE secondary_effect_id_seq CASCADE');
        $this->addSql('ALTER TABLE medicine_medicine DROP CONSTRAINT FK_A234EC99C9975FF9');
        $this->addSql('ALTER TABLE medicine_medicine DROP CONSTRAINT FK_A234EC99D0720F76');
        $this->addSql('ALTER TABLE secondary_effect_molecule DROP CONSTRAINT FK_A501C8336ACDFD42');
        $this->addSql('ALTER TABLE secondary_effect_molecule DROP CONSTRAINT FK_A501C833DAFCA214');
        $this->addSql('DROP TABLE medicine_medicine');
        $this->addSql('DROP TABLE secondary_effect');
        $this->addSql('DROP TABLE secondary_effect_molecule');
        $this->addSql('ALTER TABLE medicine ALTER specific_conditions TYPE TEXT');
        $this->addSql('COMMENT ON COLUMN medicine.specific_conditions IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE molecule DROP allergies');
    }
}
