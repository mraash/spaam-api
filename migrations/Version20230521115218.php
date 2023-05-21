<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230521115218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'SET NULL SpamPanel.sender when deleting VkAccount';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE spam_panel DROP CONSTRAINT FK_61208608F624B39D');
        $this->addSql('ALTER TABLE spam_panel ADD CONSTRAINT FK_61208608F624B39D FOREIGN KEY (sender_id) REFERENCES vk_account (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE spam_panel DROP CONSTRAINT fk_61208608f624b39d');
        $this->addSql('ALTER TABLE spam_panel ADD CONSTRAINT fk_61208608f624b39d FOREIGN KEY (sender_id) REFERENCES vk_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
