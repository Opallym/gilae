<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250703043931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE contenu (id INT AUTO_INCREMENT NOT NULL, cle VARCHAR(100) NOT NULL, texte LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_89C2003F41401D17 (cle), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE faq (id INT AUTO_INCREMENT NOT NULL, cle VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, locale VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE mention (id INT AUTO_INCREMENT NOT NULL, cle VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, locale VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, local VARCHAR(5) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE contenu
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE faq
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE mention
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE service
        SQL);
    }
}
