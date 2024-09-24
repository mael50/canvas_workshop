<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924124913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, code_hexa VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE element (id INT AUTO_INCREMENT NOT NULL, template_id INT DEFAULT NULL, pos_x DOUBLE PRECISION NOT NULL, pos_y DOUBLE PRECISION NOT NULL, width DOUBLE PRECISION NOT NULL, height DOUBLE PRECISION NOT NULL, input_associe VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_41405E395DA0FB8 (template_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT NOT NULL, src VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qr_code (id INT NOT NULL, text VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE template (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, width DOUBLE PRECISION NOT NULL, height DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE template_color (template_id INT NOT NULL, color_id INT NOT NULL, INDEX IDX_55809B265DA0FB8 (template_id), INDEX IDX_55809B267ADA1FB5 (color_id), PRIMARY KEY(template_id, color_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE text (id INT NOT NULL, text_color VARCHAR(255) NOT NULL, background_color VARCHAR(255) NOT NULL, placeholder VARCHAR(255) NOT NULL, align VARCHAR(255) NOT NULL, bold TINYINT(1) NOT NULL, italic TINYINT(1) NOT NULL, font_size DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE element ADD CONSTRAINT FK_41405E395DA0FB8 FOREIGN KEY (template_id) REFERENCES template (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FBF396750 FOREIGN KEY (id) REFERENCES element (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE qr_code ADD CONSTRAINT FK_7D8B1FB5BF396750 FOREIGN KEY (id) REFERENCES element (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE template_color ADD CONSTRAINT FK_55809B265DA0FB8 FOREIGN KEY (template_id) REFERENCES template (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE template_color ADD CONSTRAINT FK_55809B267ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE text ADD CONSTRAINT FK_3B8BA7C7BF396750 FOREIGN KEY (id) REFERENCES element (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE element DROP FOREIGN KEY FK_41405E395DA0FB8');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FBF396750');
        $this->addSql('ALTER TABLE qr_code DROP FOREIGN KEY FK_7D8B1FB5BF396750');
        $this->addSql('ALTER TABLE template_color DROP FOREIGN KEY FK_55809B265DA0FB8');
        $this->addSql('ALTER TABLE template_color DROP FOREIGN KEY FK_55809B267ADA1FB5');
        $this->addSql('ALTER TABLE text DROP FOREIGN KEY FK_3B8BA7C7BF396750');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE element');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE qr_code');
        $this->addSql('DROP TABLE template');
        $this->addSql('DROP TABLE template_color');
        $this->addSql('DROP TABLE text');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
