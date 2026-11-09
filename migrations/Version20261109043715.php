<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20261109043715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE pin_generation.pin_generation_layer ADD migration_status INT DEFAULT NULL');
        $this->addSql('CREATE INDEX idx_pin_generation_layer_migration_status ON pin_generation.pin_generation_layer (migration_status)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX pin_generation.idx_pin_generation_layer_migration_status');
        $this->addSql('ALTER TABLE pin_generation.pin_generation_layer DROP migration_status');
    }
}
