<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406092706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add VkAccount::vkSlug, VkAccount::vkFullName.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vk_account ADD vk_slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE vk_account ADD vk_full_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE vk_account DROP vk_slug');
        $this->addSql('ALTER TABLE vk_account DROP vk_full_name');
    }
}
