<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200426173236 extends AbstractMigration
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
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, confirmation_token VARCHAR(255) NOT NULL, password_requested_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE word (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, text VARCHAR(255) NOT NULL, language VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, version INT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C3F17511F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE word_translations (word_id INT NOT NULL, translation_id INT NOT NULL, INDEX IDX_92513C9BE357438D (word_id), UNIQUE INDEX UNIQ_92513C9B9CAA2B25 (translation_id), PRIMARY KEY(word_id, translation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translation (id INT AUTO_INCREMENT NOT NULL, text VARCHAR(255) NOT NULL, language VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translation_examples (translations_id INT NOT NULL, example_id INT NOT NULL, INDEX IDX_28C2328CACE9C349 (translations_id), UNIQUE INDEX UNIQ_28C2328CAB07C711 (example_id), PRIMARY KEY(translations_id, example_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE word ADD CONSTRAINT FK_C3F17511F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE word_translations ADD CONSTRAINT FK_92513C9BE357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE word_translations ADD CONSTRAINT FK_92513C9B9CAA2B25 FOREIGN KEY (translation_id) REFERENCES translation (id)');
        $this->addSql('ALTER TABLE translation_examples ADD CONSTRAINT FK_28C2328CACE9C349 FOREIGN KEY (translations_id) REFERENCES translation (id)');
        $this->addSql('ALTER TABLE translation_examples ADD CONSTRAINT FK_28C2328CAB07C711 FOREIGN KEY (example_id) REFERENCES example (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE translation_examples DROP FOREIGN KEY FK_28C2328CAB07C711');
        $this->addSql('ALTER TABLE word DROP FOREIGN KEY FK_C3F17511F675F31B');
        $this->addSql('ALTER TABLE word_translations DROP FOREIGN KEY FK_92513C9BE357438D');
        $this->addSql('ALTER TABLE word_translations DROP FOREIGN KEY FK_92513C9B9CAA2B25');
        $this->addSql('ALTER TABLE translation_examples DROP FOREIGN KEY FK_28C2328CACE9C349');
        $this->addSql('DROP TABLE example');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE word');
        $this->addSql('DROP TABLE word_translations');
        $this->addSql('DROP TABLE translation');
        $this->addSql('DROP TABLE translation_examples');
    }
}
