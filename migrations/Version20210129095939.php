<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210129095939 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE private_challenge ADD deleted_at DATETIME DEFAULT NULL, CHANGE id_teacher teacher_id INT NOT NULL');
        $this->addSql('ALTER TABLE private_challenge ADD CONSTRAINT FK_7FC9C0DB41807E1D FOREIGN KEY (teacher_id) REFERENCES `teacher` (id)');
        $this->addSql('CREATE INDEX IDX_7FC9C0DB41807E1D ON private_challenge (teacher_id)');
        $this->addSql('ALTER TABLE public_challenge ADD deleted_at DATETIME DEFAULT NULL, CHANGE id_teacher teacher_id INT NOT NULL');
        $this->addSql('ALTER TABLE public_challenge ADD CONSTRAINT FK_FA2E52D041807E1D FOREIGN KEY (teacher_id) REFERENCES `teacher` (id)');
        $this->addSql('CREATE INDEX IDX_FA2E52D041807E1D ON public_challenge (teacher_id)');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE private_challenge DROP FOREIGN KEY FK_7FC9C0DB41807E1D');
        $this->addSql('DROP INDEX IDX_7FC9C0DB41807E1D ON private_challenge');
        $this->addSql('ALTER TABLE private_challenge DROP deleted_at, CHANGE teacher_id id_teacher INT NOT NULL');
        $this->addSql('ALTER TABLE public_challenge DROP FOREIGN KEY FK_FA2E52D041807E1D');
        $this->addSql('DROP INDEX IDX_FA2E52D041807E1D ON public_challenge');
        $this->addSql('ALTER TABLE public_challenge DROP deleted_at, CHANGE teacher_id id_teacher INT NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP role');
    }
}
