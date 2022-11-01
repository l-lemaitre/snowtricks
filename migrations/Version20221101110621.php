<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221101110621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE video (id_video INT AUTO_INCREMENT NOT NULL, trick_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7CC7DA2CF47645AE (url), INDEX IDX_7CC7DA2CB281BE2E (trick_id), PRIMARY KEY(id_video)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id_trick)');
        $this->addSql('ALTER TABLE trick ADD video_id INT NULL AFTER image_id');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E29C1004E FOREIGN KEY (video_id) REFERENCES video (id_video)');
        $this->addSql('CREATE INDEX IDX_D8F0A91E29C1004E ON trick (video_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E29C1004E');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CB281BE2E');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP INDEX IDX_D8F0A91E29C1004E ON trick');
        $this->addSql('ALTER TABLE trick DROP video_id');
    }
}
