<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230115204308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FB281BE2E');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id_trick) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E3DA5256D');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E3DA5256D FOREIGN KEY (image_id) REFERENCES image (id_image) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E3DA5256D');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E3DA5256D FOREIGN KEY (image_id) REFERENCES image (id_image) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FB281BE2E');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id_trick) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
