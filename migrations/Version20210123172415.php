<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210123172415 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat ADD teacher_id INT NOT NULL');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA41807E1D FOREIGN KEY (teacher_id) REFERENCES `teacher` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_659DF2AA41807E1D ON chat (teacher_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AA41807E1D');
        $this->addSql('DROP INDEX UNIQ_659DF2AA41807E1D ON chat');
        $this->addSql('ALTER TABLE chat DROP teacher_id');
        $this->addSql('ALTER TABLE help CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE `teacher` CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE thymio_challenge CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
