<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321014037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE audit (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, agent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9218FF79979B1AD6 (company_id), INDEX IDX_9218FF793414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE audit_report (id INT AUTO_INCREMENT NOT NULL, audit_subsection_id INT NOT NULL, report_message LONGTEXT DEFAULT NULL, report_proof VARCHAR(255) DEFAULT NULL, is_okey TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_E7F15B5FDA5A57C3 (audit_subsection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE audit_section (id INT AUTO_INCREMENT NOT NULL, audit_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3C51AF9FBD29F359 (audit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE audit_subsection (id INT AUTO_INCREMENT NOT NULL, audit_section_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1BCFCADFA5FDFB85 (audit_section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF79979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF793414710B FOREIGN KEY (agent_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE audit_report ADD CONSTRAINT FK_E7F15B5FDA5A57C3 FOREIGN KEY (audit_subsection_id) REFERENCES audit_subsection (id)');
        $this->addSql('ALTER TABLE audit_section ADD CONSTRAINT FK_3C51AF9FBD29F359 FOREIGN KEY (audit_id) REFERENCES audit (id)');
        $this->addSql('ALTER TABLE audit_subsection ADD CONSTRAINT FK_1BCFCADFA5FDFB85 FOREIGN KEY (audit_section_id) REFERENCES audit_section (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audit DROP FOREIGN KEY FK_9218FF79979B1AD6');
        $this->addSql('ALTER TABLE audit DROP FOREIGN KEY FK_9218FF793414710B');
        $this->addSql('ALTER TABLE audit_report DROP FOREIGN KEY FK_E7F15B5FDA5A57C3');
        $this->addSql('ALTER TABLE audit_section DROP FOREIGN KEY FK_3C51AF9FBD29F359');
        $this->addSql('ALTER TABLE audit_subsection DROP FOREIGN KEY FK_1BCFCADFA5FDFB85');
        $this->addSql('DROP TABLE audit');
        $this->addSql('DROP TABLE audit_report');
        $this->addSql('DROP TABLE audit_section');
        $this->addSql('DROP TABLE audit_subsection');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE user');
    }
}
