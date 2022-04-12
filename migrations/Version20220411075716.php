<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220411075716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidate (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, phone VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C8B28E44E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidate_category (candidate_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_A7125B1291BD8781 (candidate_id), INDEX IDX_A7125B1212469DE2 (category_id), PRIMARY KEY(candidate_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidate_contract_type (candidate_id INT NOT NULL, contract_type_id INT NOT NULL, INDEX IDX_CADD026C91BD8781 (candidate_id), INDEX IDX_CADD026CCD1DF15B (contract_type_id), PRIMARY KEY(candidate_id, contract_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidate_offres (candidate_id INT NOT NULL, offres_id INT NOT NULL, INDEX IDX_729F6B9891BD8781 (candidate_id), INDEX IDX_729F6B986C83CD9F (offres_id), PRIMARY KEY(candidate_id, offres_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contract_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cv (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, diplome LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', etablissement VARCHAR(255) NOT NULL, poste VARCHAR(255) NOT NULL, entreprise VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_B66FFE92F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offres (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, contract_type_id INT NOT NULL, name VARCHAR(255) NOT NULL, place VARCHAR(255) NOT NULL, salary INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_C6AC3544F675F31B (author_id), INDEX IDX_C6AC3544CD1DF15B (contract_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offres_category (offres_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_216517006C83CD9F (offres_id), INDEX IDX_2165170012469DE2 (category_id), PRIMARY KEY(offres_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, phone VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidate_category ADD CONSTRAINT FK_A7125B1291BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidate_category ADD CONSTRAINT FK_A7125B1212469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidate_contract_type ADD CONSTRAINT FK_CADD026C91BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidate_contract_type ADD CONSTRAINT FK_CADD026CCD1DF15B FOREIGN KEY (contract_type_id) REFERENCES contract_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidate_offres ADD CONSTRAINT FK_729F6B9891BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidate_offres ADD CONSTRAINT FK_729F6B986C83CD9F FOREIGN KEY (offres_id) REFERENCES offres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE92F675F31B FOREIGN KEY (author_id) REFERENCES candidate (id)');
        $this->addSql('ALTER TABLE offres ADD CONSTRAINT FK_C6AC3544F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offres ADD CONSTRAINT FK_C6AC3544CD1DF15B FOREIGN KEY (contract_type_id) REFERENCES contract_type (id)');
        $this->addSql('ALTER TABLE offres_category ADD CONSTRAINT FK_216517006C83CD9F FOREIGN KEY (offres_id) REFERENCES offres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offres_category ADD CONSTRAINT FK_2165170012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidate_category DROP FOREIGN KEY FK_A7125B1291BD8781');
        $this->addSql('ALTER TABLE candidate_contract_type DROP FOREIGN KEY FK_CADD026C91BD8781');
        $this->addSql('ALTER TABLE candidate_offres DROP FOREIGN KEY FK_729F6B9891BD8781');
        $this->addSql('ALTER TABLE cv DROP FOREIGN KEY FK_B66FFE92F675F31B');
        $this->addSql('ALTER TABLE candidate_category DROP FOREIGN KEY FK_A7125B1212469DE2');
        $this->addSql('ALTER TABLE offres_category DROP FOREIGN KEY FK_2165170012469DE2');
        $this->addSql('ALTER TABLE candidate_contract_type DROP FOREIGN KEY FK_CADD026CCD1DF15B');
        $this->addSql('ALTER TABLE offres DROP FOREIGN KEY FK_C6AC3544CD1DF15B');
        $this->addSql('ALTER TABLE candidate_offres DROP FOREIGN KEY FK_729F6B986C83CD9F');
        $this->addSql('ALTER TABLE offres_category DROP FOREIGN KEY FK_216517006C83CD9F');
        $this->addSql('ALTER TABLE offres DROP FOREIGN KEY FK_C6AC3544F675F31B');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE candidate');
        $this->addSql('DROP TABLE candidate_category');
        $this->addSql('DROP TABLE candidate_contract_type');
        $this->addSql('DROP TABLE candidate_offres');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE contract_type');
        $this->addSql('DROP TABLE cv');
        $this->addSql('DROP TABLE offres');
        $this->addSql('DROP TABLE offres_category');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
