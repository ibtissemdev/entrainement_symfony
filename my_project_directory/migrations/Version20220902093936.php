<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220902093936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE url_statistic (id INT AUTO_INCREMENT NOT NULL, url_id INT NOT NULL, INDEX IDX_F09D1D7681CFDAE7 (url_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE url_statistic ADD CONSTRAINT FK_F09D1D7681CFDAE7 FOREIGN KEY (url_id) REFERENCES url (id)');
        $this->addSql('ALTER TABLE url CHANGE created_ad created_ad DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url_statistic DROP FOREIGN KEY FK_F09D1D7681CFDAE7');
        $this->addSql('DROP TABLE url_statistic');
        $this->addSql('ALTER TABLE url CHANGE created_ad created_ad DATETIME NOT NULL');
    }
}
