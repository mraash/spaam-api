<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230302203658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create VkAccount.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE vk_account_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE vk_account (id INT NOT NULL, owner_id INT NOT NULL, vk_id INT NOT NULL, vk_access_token VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AAB7EA607E3C61F9 ON vk_account (owner_id)');
        $this->addSql('ALTER TABLE vk_account ADD CONSTRAINT FK_AAB7EA607E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE vk_account_id_seq CASCADE');
        $this->addSql('ALTER TABLE vk_account DROP CONSTRAINT FK_AAB7EA607E3C61F9');
        $this->addSql('DROP TABLE vk_account');
    }
}
