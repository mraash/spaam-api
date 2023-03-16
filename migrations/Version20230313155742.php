<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230313155742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create SpamPanel.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE spam_panel_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE spam_panel (id INT NOT NULL, owner_id INT NOT NULL, sender_id INT NOT NULL, recipient VARCHAR(255) NOT NULL, texts JSON NOT NULL, timers JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_612086087E3C61F9 ON spam_panel (owner_id)');
        $this->addSql('CREATE INDEX IDX_61208608F624B39D ON spam_panel (sender_id)');
        $this->addSql('ALTER TABLE spam_panel ADD CONSTRAINT FK_612086087E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE spam_panel ADD CONSTRAINT FK_61208608F624B39D FOREIGN KEY (sender_id) REFERENCES vk_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE spam_panel_id_seq CASCADE');
        $this->addSql('ALTER TABLE spam_panel DROP CONSTRAINT FK_612086087E3C61F9');
        $this->addSql('ALTER TABLE spam_panel DROP CONSTRAINT FK_61208608F624B39D');
        $this->addSql('DROP TABLE spam_panel');
    }
}
