<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210321125219 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comment');
        $this->addSql('ALTER TABLE private_challenge CHANGE deleted_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE public_challenge DROP deleted_at');
        $this->addSql('ALTER TABLE status DROP count_help, DROP need_help');
        $this->addSql('ALTER TABLE user DROP deleted_at');
        $this->addSql('ALTER TABLE user_guest ADD count_succeed INT NOT NULL');
        $this->addSql('ALTER TABLE user_guest_status DROP count_help, DROP need_help');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, content_comment LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, INDEX IDX_9474526C41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE private_challenge CHANGE updated_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE public_challenge ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE status ADD count_help INT DEFAULT NULL, ADD need_help TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE `user` ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE `user_guest` DROP count_succeed');
        $this->addSql('ALTER TABLE user_guest_status ADD count_help INT DEFAULT NULL, ADD need_help TINYINT(1) DEFAULT NULL');
    }
}
