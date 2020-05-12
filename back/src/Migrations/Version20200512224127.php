<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200512224127 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE example (id INT AUTO_INCREMENT NOT NULL, from_language LONGTEXT NOT NULL, from_text LONGTEXT NOT NULL, to_language LONGTEXT NOT NULL, to_text LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE word_object (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, version INT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, text VARCHAR(255) NOT NULL, language VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_DA747F62F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE word_translations (word_id INT NOT NULL, translation_id INT NOT NULL, INDEX IDX_92513C9BE357438D (word_id), UNIQUE INDEX UNIQ_92513C9B9CAA2B25 (translation_id), PRIMARY KEY(word_id, translation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(254) NOT NULL, is_active TINYINT(1) NOT NULL, token VARCHAR(64) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE search (id INT AUTO_INCREMENT NOT NULL, text VARCHAR(255) NOT NULL, count INT NOT NULL, from_language VARCHAR(255) DEFAULT NULL, to_language VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translation (id INT AUTO_INCREMENT NOT NULL, text VARCHAR(255) NOT NULL, language VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translation_examples (translations_id INT NOT NULL, example_id INT NOT NULL, INDEX IDX_28C2328CACE9C349 (translations_id), UNIQUE INDEX UNIQ_28C2328CAB07C711 (example_id), PRIMARY KEY(translations_id, example_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oauth2_access_token (identifier CHAR(80) NOT NULL, client VARCHAR(32) NOT NULL, expiry DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', user_identifier VARCHAR(128) DEFAULT NULL, scopes TEXT DEFAULT NULL COMMENT \'(DC2Type:oauth2_scope)\', revoked TINYINT(1) NOT NULL, INDEX IDX_454D9673C7440455 (client), PRIMARY KEY(identifier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oauth2_client (identifier VARCHAR(32) NOT NULL, secret VARCHAR(128) DEFAULT NULL, redirect_uris TEXT DEFAULT NULL COMMENT \'(DC2Type:oauth2_redirect_uri)\', grants TEXT DEFAULT NULL COMMENT \'(DC2Type:oauth2_grant)\', scopes TEXT DEFAULT NULL COMMENT \'(DC2Type:oauth2_scope)\', active TINYINT(1) NOT NULL, allow_plain_text_pkce TINYINT(1) DEFAULT \'0\' NOT NULL, PRIMARY KEY(identifier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oauth2_authorization_code (identifier CHAR(80) NOT NULL, client VARCHAR(32) NOT NULL, expiry DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', user_identifier VARCHAR(128) DEFAULT NULL, scopes TEXT DEFAULT NULL COMMENT \'(DC2Type:oauth2_scope)\', revoked TINYINT(1) NOT NULL, INDEX IDX_509FEF5FC7440455 (client), PRIMARY KEY(identifier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oauth2_refresh_token (identifier CHAR(80) NOT NULL, access_token CHAR(80) DEFAULT NULL, expiry DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', revoked TINYINT(1) NOT NULL, INDEX IDX_4DD90732B6A2DD68 (access_token), PRIMARY KEY(identifier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE word_object ADD CONSTRAINT FK_DA747F62F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE word_translations ADD CONSTRAINT FK_92513C9BE357438D FOREIGN KEY (word_id) REFERENCES word_object (id)');
        $this->addSql('ALTER TABLE word_translations ADD CONSTRAINT FK_92513C9B9CAA2B25 FOREIGN KEY (translation_id) REFERENCES translation (id)');
        $this->addSql('ALTER TABLE translation_examples ADD CONSTRAINT FK_28C2328CACE9C349 FOREIGN KEY (translations_id) REFERENCES translation (id)');
        $this->addSql('ALTER TABLE translation_examples ADD CONSTRAINT FK_28C2328CAB07C711 FOREIGN KEY (example_id) REFERENCES example (id)');
        $this->addSql('ALTER TABLE oauth2_access_token ADD CONSTRAINT FK_454D9673C7440455 FOREIGN KEY (client) REFERENCES oauth2_client (identifier) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oauth2_authorization_code ADD CONSTRAINT FK_509FEF5FC7440455 FOREIGN KEY (client) REFERENCES oauth2_client (identifier)');
        $this->addSql('ALTER TABLE oauth2_refresh_token ADD CONSTRAINT FK_4DD90732B6A2DD68 FOREIGN KEY (access_token) REFERENCES oauth2_access_token (identifier) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE translation_examples DROP FOREIGN KEY FK_28C2328CAB07C711');
        $this->addSql('ALTER TABLE word_translations DROP FOREIGN KEY FK_92513C9BE357438D');
        $this->addSql('ALTER TABLE word_object DROP FOREIGN KEY FK_DA747F62F675F31B');
        $this->addSql('ALTER TABLE word_translations DROP FOREIGN KEY FK_92513C9B9CAA2B25');
        $this->addSql('ALTER TABLE translation_examples DROP FOREIGN KEY FK_28C2328CACE9C349');
        $this->addSql('ALTER TABLE oauth2_refresh_token DROP FOREIGN KEY FK_4DD90732B6A2DD68');
        $this->addSql('ALTER TABLE oauth2_access_token DROP FOREIGN KEY FK_454D9673C7440455');
        $this->addSql('ALTER TABLE oauth2_authorization_code DROP FOREIGN KEY FK_509FEF5FC7440455');
        $this->addSql('DROP TABLE example');
        $this->addSql('DROP TABLE word_object');
        $this->addSql('DROP TABLE word_translations');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE search');
        $this->addSql('DROP TABLE translation');
        $this->addSql('DROP TABLE translation_examples');
        $this->addSql('DROP TABLE oauth2_access_token');
        $this->addSql('DROP TABLE oauth2_client');
        $this->addSql('DROP TABLE oauth2_authorization_code');
        $this->addSql('DROP TABLE oauth2_refresh_token');
    }
}
