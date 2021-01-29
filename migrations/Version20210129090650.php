<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210129090650 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE private_challenge DROP id_teacher');
        $this->addSql('ALTER TABLE public_challenge DROP id_teacher');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE help CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE private_challenge ADD id_teacher INT NOT NULL');
        $this->addSql('ALTER TABLE public_challenge ADD id_teacher INT NOT NULL');
        $this->addSql('ALTER TABLE `teacher` CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE thymio_challenge CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
