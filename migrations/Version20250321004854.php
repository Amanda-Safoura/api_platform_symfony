<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321004854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audit ADD agent_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF7946EAB62F FOREIGN KEY (agent_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9218FF7946EAB62F ON audit (agent_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audit DROP FOREIGN KEY FK_9218FF7946EAB62F');
        $this->addSql('DROP INDEX IDX_9218FF7946EAB62F ON audit');
        $this->addSql('ALTER TABLE audit DROP agent_id_id');
    }
}
