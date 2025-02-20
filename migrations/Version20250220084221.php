<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250220084221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user_id INTEGER NOT NULL, id_article_id INTEGER NOT NULL, CONSTRAINT FK_24CC0DF279F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_24CC0DF2D71E064B FOREIGN KEY (id_article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_24CC0DF279F37AE5 ON panier (id_user_id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF2D71E064B ON panier (id_article_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, nom, description, prix, date_publication, image FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, auteur_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, prix INTEGER NOT NULL, date_publication DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , image VARCHAR(255) NOT NULL, CONSTRAINT FK_23A0E6660BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, nom, description, prix, date_publication, image) SELECT id, nom, description, prix, date_publication, image FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE INDEX IDX_23A0E6660BB6FE6 ON article (auteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE panier');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, nom, description, prix, date_publication, image FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, prix INTEGER NOT NULL, date_publication DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , image VARCHAR(255) NOT NULL, auteur VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO article (id, nom, description, prix, date_publication, image) SELECT id, nom, description, prix, date_publication, image FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
    }
}
