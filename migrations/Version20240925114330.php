<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240925114330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, src, name FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER NOT NULL, src VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_C53D045FBF396750 FOREIGN KEY (id) REFERENCES element (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO image (id, src, name) SELECT id, src, name FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
        $this->addSql('CREATE TEMPORARY TABLE __temp__qr_code AS SELECT id, text FROM qr_code');
        $this->addSql('DROP TABLE qr_code');
        $this->addSql('CREATE TABLE qr_code (id INTEGER NOT NULL, text VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_7D8B1FB5BF396750 FOREIGN KEY (id) REFERENCES element (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO qr_code (id, text) SELECT id, text FROM __temp__qr_code');
        $this->addSql('DROP TABLE __temp__qr_code');
        $this->addSql('ALTER TABLE template ADD COLUMN created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE template ADD COLUMN updated_at DATETIME NOT NULL');
        $this->addSql('CREATE TEMPORARY TABLE __temp__text AS SELECT id, text_color, background_color, placeholder, align, bold, italic, font_size FROM text');
        $this->addSql('DROP TABLE text');
        $this->addSql('CREATE TABLE text (id INTEGER NOT NULL, text_color VARCHAR(255) NOT NULL, background_color VARCHAR(255) NOT NULL, placeholder VARCHAR(255) NOT NULL, align VARCHAR(255) NOT NULL, bold BOOLEAN NOT NULL, italic BOOLEAN NOT NULL, font_size DOUBLE PRECISION NOT NULL, font_family VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_3B8BA7C7BF396750 FOREIGN KEY (id) REFERENCES element (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO text (id, text_color, background_color, placeholder, align, bold, italic, font_size) SELECT id, text_color, background_color, placeholder, align, bold, italic, font_size FROM __temp__text');
        $this->addSql('DROP TABLE __temp__text');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, src, name FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, src VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT FK_C53D045FBF396750 FOREIGN KEY (id) REFERENCES element (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO image (id, src, name) SELECT id, src, name FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
        $this->addSql('CREATE TEMPORARY TABLE __temp__qr_code AS SELECT id, text FROM qr_code');
        $this->addSql('DROP TABLE qr_code');
        $this->addSql('CREATE TABLE qr_code (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text VARCHAR(255) NOT NULL, CONSTRAINT FK_7D8B1FB5BF396750 FOREIGN KEY (id) REFERENCES element (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO qr_code (id, text) SELECT id, text FROM __temp__qr_code');
        $this->addSql('DROP TABLE __temp__qr_code');
        $this->addSql('CREATE TEMPORARY TABLE __temp__template AS SELECT id, name, width, height FROM template');
        $this->addSql('DROP TABLE template');
        $this->addSql('CREATE TABLE template (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, width DOUBLE PRECISION NOT NULL, height DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO template (id, name, width, height) SELECT id, name, width, height FROM __temp__template');
        $this->addSql('DROP TABLE __temp__template');
        $this->addSql('CREATE TEMPORARY TABLE __temp__text AS SELECT id, text_color, background_color, placeholder, align, bold, italic, font_size FROM text');
        $this->addSql('DROP TABLE text');
        $this->addSql('CREATE TABLE text (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text_color VARCHAR(255) NOT NULL, background_color VARCHAR(255) NOT NULL, placeholder VARCHAR(255) NOT NULL, align VARCHAR(255) NOT NULL, bold BOOLEAN NOT NULL, italic BOOLEAN NOT NULL, font_size DOUBLE PRECISION NOT NULL, CONSTRAINT FK_3B8BA7C7BF396750 FOREIGN KEY (id) REFERENCES element (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO text (id, text_color, background_color, placeholder, align, bold, italic, font_size) SELECT id, text_color, background_color, placeholder, align, bold, italic, font_size FROM __temp__text');
        $this->addSql('DROP TABLE __temp__text');
    }
}
