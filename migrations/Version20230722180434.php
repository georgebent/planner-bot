<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230722180434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE interval_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE job_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE receiver_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_receiver_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE interval (id INT NOT NULL, name VARCHAR(255) NOT NULL, pattern VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE job (id INT NOT NULL, user_receiver_id INT NOT NULL, interval_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, sent_times INT NOT NULL, max_times INT NOT NULL, last_sent_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, send_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FBD8E0F864482423 ON job (user_receiver_id)');
        $this->addSql('CREATE INDEX IDX_FBD8E0F8505A342E ON job (interval_id)');
        $this->addSql('COMMENT ON COLUMN job.last_sent_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN job.send_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE receiver (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_receiver (id INT NOT NULL, receiver_id INT NOT NULL, author_id INT NOT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DD356896CD53EDB6 ON user_receiver (receiver_id)');
        $this->addSql('CREATE INDEX IDX_DD356896F675F31B ON user_receiver (author_id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F864482423 FOREIGN KEY (user_receiver_id) REFERENCES user_receiver (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8505A342E FOREIGN KEY (interval_id) REFERENCES interval (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_receiver ADD CONSTRAINT FK_DD356896CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES receiver (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_receiver ADD CONSTRAINT FK_DD356896F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE interval_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE job_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE receiver_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_receiver_id_seq CASCADE');
        $this->addSql('ALTER TABLE job DROP CONSTRAINT FK_FBD8E0F864482423');
        $this->addSql('ALTER TABLE job DROP CONSTRAINT FK_FBD8E0F8505A342E');
        $this->addSql('ALTER TABLE user_receiver DROP CONSTRAINT FK_DD356896CD53EDB6');
        $this->addSql('ALTER TABLE user_receiver DROP CONSTRAINT FK_DD356896F675F31B');
        $this->addSql('DROP TABLE interval');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE receiver');
        $this->addSql('DROP TABLE user_receiver');
    }
}
