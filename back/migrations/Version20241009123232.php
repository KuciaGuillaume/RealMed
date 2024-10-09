<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009123232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE contraindication_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE medicine_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE molecule_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE contraindication (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE contraindication_user (contraindication_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(contraindication_id, user_id))');
        $this->addSql('CREATE INDEX IDX_D4EFF91817EA8266 ON contraindication_user (contraindication_id)');
        $this->addSql('CREATE INDEX IDX_D4EFF918A76ED395 ON contraindication_user (user_id)');
        $this->addSql('CREATE TABLE medicine (id INT NOT NULL, molecule_id INT DEFAULT NULL, dosage VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT NULL, efficiency_time VARCHAR(255) DEFAULT NULL, aspect VARCHAR(255) DEFAULT NULL, size VARCHAR(255) DEFAULT NULL, conditionning VARCHAR(255) DEFAULT NULL, secondary_effects VARCHAR(255) DEFAULT NULL, format VARCHAR(255) DEFAULT NULL, administration VARCHAR(255) DEFAULT NULL, duration_time VARCHAR(255) DEFAULT NULL, specific_conditions TEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_58362A8DDAFCA214 ON medicine (molecule_id)');
        $this->addSql('COMMENT ON COLUMN medicine.specific_conditions IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE medicine_contraindication (medicine_id INT NOT NULL, contraindication_id INT NOT NULL, PRIMARY KEY(medicine_id, contraindication_id))');
        $this->addSql('CREATE INDEX IDX_A40E1F402F7D140A ON medicine_contraindication (medicine_id)');
        $this->addSql('CREATE INDEX IDX_A40E1F4017EA8266 ON medicine_contraindication (contraindication_id)');
        $this->addSql('CREATE TABLE molecule (id INT NOT NULL, name VARCHAR(255) NOT NULL, common_affliction VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('CREATE TABLE user_medicine (user_id INT NOT NULL, medicine_id INT NOT NULL, PRIMARY KEY(user_id, medicine_id))');
        $this->addSql('CREATE INDEX IDX_B8BBCE8DA76ED395 ON user_medicine (user_id)');
        $this->addSql('CREATE INDEX IDX_B8BBCE8D2F7D140A ON user_medicine (medicine_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE contraindication_user ADD CONSTRAINT FK_D4EFF91817EA8266 FOREIGN KEY (contraindication_id) REFERENCES contraindication (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contraindication_user ADD CONSTRAINT FK_D4EFF918A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE medicine ADD CONSTRAINT FK_58362A8DDAFCA214 FOREIGN KEY (molecule_id) REFERENCES molecule (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE medicine_contraindication ADD CONSTRAINT FK_A40E1F402F7D140A FOREIGN KEY (medicine_id) REFERENCES medicine (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE medicine_contraindication ADD CONSTRAINT FK_A40E1F4017EA8266 FOREIGN KEY (contraindication_id) REFERENCES contraindication (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_medicine ADD CONSTRAINT FK_B8BBCE8DA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_medicine ADD CONSTRAINT FK_B8BBCE8D2F7D140A FOREIGN KEY (medicine_id) REFERENCES medicine (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE contraindication_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE medicine_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE molecule_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE contraindication_user DROP CONSTRAINT FK_D4EFF91817EA8266');
        $this->addSql('ALTER TABLE contraindication_user DROP CONSTRAINT FK_D4EFF918A76ED395');
        $this->addSql('ALTER TABLE medicine DROP CONSTRAINT FK_58362A8DDAFCA214');
        $this->addSql('ALTER TABLE medicine_contraindication DROP CONSTRAINT FK_A40E1F402F7D140A');
        $this->addSql('ALTER TABLE medicine_contraindication DROP CONSTRAINT FK_A40E1F4017EA8266');
        $this->addSql('ALTER TABLE user_medicine DROP CONSTRAINT FK_B8BBCE8DA76ED395');
        $this->addSql('ALTER TABLE user_medicine DROP CONSTRAINT FK_B8BBCE8D2F7D140A');
        $this->addSql('DROP TABLE contraindication');
        $this->addSql('DROP TABLE contraindication_user');
        $this->addSql('DROP TABLE medicine');
        $this->addSql('DROP TABLE medicine_contraindication');
        $this->addSql('DROP TABLE molecule');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_medicine');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
