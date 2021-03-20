<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210317211330 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE youtube (id INT AUTO_INCREMENT NOT NULL, request VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE student_group_help');
        $this->addSql('ALTER TABLE help CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE public_challenge CHANGE name_correction name_correction VARCHAR(30) DEFAULT NULL');
        $this->addSql('ALTER TABLE thymio_challenge CHANGE file file VARCHAR(100) NOT NULL, CHANGE path_video path_video VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user_guest CHANGE mail mail VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, content_comment LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, INDEX IDX_9474526C41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE student_group_help (student_group_id INT NOT NULL, help_id INT NOT NULL, INDEX IDX_CC02EA3D4DDF95DC (student_group_id), INDEX IDX_CC02EA3DD3F165E7 (help_id), PRIMARY KEY(student_group_id, help_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE student_group_help ADD CONSTRAINT FK_CC02EA3D4DDF95DC FOREIGN KEY (student_group_id) REFERENCES student_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_group_help ADD CONSTRAINT FK_CC02EA3DD3F165E7 FOREIGN KEY (help_id) REFERENCES help (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE youtube');
        $this->addSql('ALTER TABLE help CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE public_challenge CHANGE name_correction name_correction VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE thymio_challenge CHANGE file file VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE path_video path_video VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `user_guest` CHANGE mail mail VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
