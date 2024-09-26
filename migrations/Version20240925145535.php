<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240925145535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE color (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, code_hexa VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE element (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, template_id INTEGER DEFAULT NULL, pos_x DOUBLE PRECISION NOT NULL, pos_y DOUBLE PRECISION NOT NULL, width DOUBLE PRECISION NOT NULL, height DOUBLE PRECISION NOT NULL, input_associe VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, CONSTRAINT FK_41405E395DA0FB8 FOREIGN KEY (template_id) REFERENCES template (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_41405E395DA0FB8 ON element (template_id)');
        $this->addSql('CREATE TABLE image (id INTEGER NOT NULL, src VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_C53D045FBF396750 FOREIGN KEY (id) REFERENCES element (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE TABLE qr_code (id INTEGER NOT NULL, text VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_7D8B1FB5BF396750 FOREIGN KEY (id) REFERENCES element (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE TABLE template (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, width DOUBLE PRECISION NOT NULL, height DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE template_color (template_id INTEGER NOT NULL, color_id INTEGER NOT NULL, PRIMARY KEY(template_id, color_id), CONSTRAINT FK_55809B265DA0FB8 FOREIGN KEY (template_id) REFERENCES template (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_55809B267ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_55809B265DA0FB8 ON template_color (template_id)');
        $this->addSql('CREATE INDEX IDX_55809B267ADA1FB5 ON template_color (color_id)');
        $this->addSql('CREATE TABLE text (id INTEGER NOT NULL, text_color VARCHAR(255) NOT NULL, background_color VARCHAR(255) NOT NULL, placeholder VARCHAR(255) NOT NULL, align VARCHAR(255) NOT NULL, bold BOOLEAN NOT NULL, italic BOOLEAN NOT NULL, font_size DOUBLE PRECISION NOT NULL, font_family VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_3B8BA7C7BF396750 FOREIGN KEY (id) REFERENCES element (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE element');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE qr_code');
        $this->addSql('DROP TABLE template');
        $this->addSql('DROP TABLE template_color');
        $this->addSql('DROP TABLE text');
    }
}
