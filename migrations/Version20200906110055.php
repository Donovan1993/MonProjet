<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200906110055 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles_categories (articles_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_DE004A0E1EBAF6CC (articles_id), INDEX IDX_DE004A0EA21214B7 (categories_id), PRIMARY KEY(articles_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_mots_cles (articles_id INT NOT NULL, mots_cles_id INT NOT NULL, INDEX IDX_2927AB461EBAF6CC (articles_id), INDEX IDX_2927AB46C0BE80DB (mots_cles_id), PRIMARY KEY(articles_id, mots_cles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, articles_id INT NOT NULL, pseudo VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, actif TINYINT(1) NOT NULL, rgpd TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_D9BEC0C41EBAF6CC (articles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mots_cles (id INT AUTO_INCREMENT NOT NULL, mot_cle VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_D4E4C6CA989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles_categories ADD CONSTRAINT FK_DE004A0E1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_categories ADD CONSTRAINT FK_DE004A0EA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_mots_cles ADD CONSTRAINT FK_2927AB461EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_mots_cles ADD CONSTRAINT FK_2927AB46C0BE80DB FOREIGN KEY (mots_cles_id) REFERENCES mots_cles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C41EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE logement CHANGE updated_at updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles_categories DROP FOREIGN KEY FK_DE004A0EA21214B7');
        $this->addSql('ALTER TABLE articles_mots_cles DROP FOREIGN KEY FK_2927AB46C0BE80DB');
        $this->addSql('DROP TABLE articles_categories');
        $this->addSql('DROP TABLE articles_mots_cles');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE mots_cles');
        $this->addSql('ALTER TABLE logement CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
