<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250318175809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audit ADD company_id INT NOT NULL');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF79979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_9218FF79979B1AD6 ON audit (company_id)');
        $this->addSql('ALTER TABLE audit_report ADD audit_id INT NOT NULL');
        $this->addSql('ALTER TABLE audit_report ADD CONSTRAINT FK_E7F15B5FBD29F359 FOREIGN KEY (audit_id) REFERENCES audit (id)');
        $this->addSql('CREATE INDEX IDX_E7F15B5FBD29F359 ON audit_report (audit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audit DROP FOREIGN KEY FK_9218FF79979B1AD6');
        $this->addSql('DROP INDEX IDX_9218FF79979B1AD6 ON audit');
        $this->addSql('ALTER TABLE audit DROP company_id');
        $this->addSql('ALTER TABLE audit_report DROP FOREIGN KEY FK_E7F15B5FBD29F359');
        $this->addSql('DROP INDEX IDX_E7F15B5FBD29F359 ON audit_report');
        $this->addSql('ALTER TABLE audit_report DROP audit_id');
    }
}
