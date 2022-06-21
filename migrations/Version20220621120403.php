<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220621120403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movie_genre (movie_id INTEGER NOT NULL, genre_id INTEGER NOT NULL, PRIMARY KEY(movie_id, genre_id))');
        $this->addSql('CREATE INDEX IDX_FD1229648F93B6FC ON movie_genre (movie_id)');
        $this->addSql('CREATE INDEX IDX_FD1229644296D31F ON movie_genre (genre_id)');
        $this->addSql('DROP INDEX IDX_9474526C16A2B381');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, book_id, title, message FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, book_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, message CLOB NOT NULL, CONSTRAINT FK_9474526C16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, book_id, title, message) SELECT id, book_id, title, message FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C16A2B381 ON comment (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE movie_genre');
        $this->addSql('DROP INDEX IDX_9474526C16A2B381');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, book_id, title, message FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, book_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, message CLOB NOT NULL)');
        $this->addSql('INSERT INTO comment (id, book_id, title, message) SELECT id, book_id, title, message FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C16A2B381 ON comment (book_id)');
    }
}
