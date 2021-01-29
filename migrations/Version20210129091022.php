<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210129091022 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE private_challenge ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE public_challenge ADD deleted_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE help CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE private_challenge DROP deleted_at');
        $this->addSql('ALTER TABLE public_challenge DROP deleted_at');
        $this->addSql('ALTER TABLE `teacher` CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE thymio_challenge CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
