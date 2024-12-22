<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241222133225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chapter DROP CONSTRAINT FK_F981B52E89366B7B');
        $this->addSql('ALTER TABLE chapter ALTER tutorial_id SET NOT NULL');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52E89366B7B FOREIGN KEY (tutorial_id) REFERENCES tutorial (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chapter DROP CONSTRAINT fk_f981b52e89366b7b');
        $this->addSql('ALTER TABLE chapter ALTER tutorial_id DROP NOT NULL');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT fk_f981b52e89366b7b FOREIGN KEY (tutorial_id) REFERENCES tutorial (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
