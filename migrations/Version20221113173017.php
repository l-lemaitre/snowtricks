<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221113173017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_7CC7DA2CF47645AE ON video');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7CC7DA2CB281BE2EF47645AE ON video (trick_id, url)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_7CC7DA2CB281BE2EF47645AE ON video');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7CC7DA2CF47645AE ON video (url)');
    }
}
