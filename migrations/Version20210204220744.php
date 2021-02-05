<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210204220744 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE challenge (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, difficulty VARCHAR(30) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_student_group (challenge_id INT NOT NULL, student_group_id INT NOT NULL, INDEX IDX_6C91BFCB98A21AC6 (challenge_id), INDEX IDX_6C91BFCB4DDF95DC (student_group_id), PRIMARY KEY(challenge_id, student_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, UNIQUE INDEX UNIQ_659DF2AA41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE child (id INT AUTO_INCREMENT NOT NULL, group_child_id INT NOT NULL, name_child VARCHAR(30) NOT NULL, first_name_child VARCHAR(30) NOT NULL, INDEX IDX_22B35429D4528E64 (group_child_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, content_comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9474526C41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE help (id INT NOT NULL, challenge_id INT NOT NULL, content_help LONGTEXT NOT NULL, number_help INT NOT NULL, INDEX IDX_8875CAC98A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, chat_id INT NOT NULL, id_user INT NOT NULL, content_message INT NOT NULL, date_message DATETIME NOT NULL, INDEX IDX_B6BD307F1A9A7125 (chat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE private_challenge (id INT NOT NULL, teacher_id INT NOT NULL, created_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_7FC9C0DB41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE public_challenge (id INT NOT NULL, teacher_id INT NOT NULL, name_correction_pdf VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_FA2E52D041807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, group_status_id INT NOT NULL, challenge_id INT NOT NULL, status_int INT NOT NULL, count_help INT DEFAULT NULL, need_help TINYINT(1) NOT NULL, started_at DATETIME NOT NULL, finished_at DATETIME DEFAULT NULL, INDEX IDX_7B00651CAB445C5C (group_status_id), INDEX IDX_7B00651C98A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `student_group` (id INT NOT NULL, teacher_id INT NOT NULL, chat_id INT NOT NULL, count_succeed INT NOT NULL, INDEX IDX_E5F73D5841807E1D (teacher_id), INDEX IDX_E5F73D581A9A7125 (chat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_group_help (student_group_id INT NOT NULL, help_id INT NOT NULL, INDEX IDX_CC02EA3D4DDF95DC (student_group_id), INDEX IDX_CC02EA3DD3F165E7 (help_id), PRIMARY KEY(student_group_id, help_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `teacher` (id INT NOT NULL, chat_id INT DEFAULT NULL, mail_teacher VARCHAR(150) NOT NULL, name_teacher VARCHAR(100) NOT NULL, first_name_teacher VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_B0F6A6D51A9A7125 (chat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thymio_challenge (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, nickname VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, password VARCHAR(150) NOT NULL, role VARCHAR(50) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user_guest` (id INT AUTO_INCREMENT NOT NULL, mail VARCHAR(30) NOT NULL, name VARCHAR(30) NOT NULL, firstname VARCHAR(40) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE challenge_student_group ADD CONSTRAINT FK_6C91BFCB98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_student_group ADD CONSTRAINT FK_6C91BFCB4DDF95DC FOREIGN KEY (student_group_id) REFERENCES `student_group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA41807E1D FOREIGN KEY (teacher_id) REFERENCES `teacher` (id)');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B35429D4528E64 FOREIGN KEY (group_child_id) REFERENCES `student_group` (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C41807E1D FOREIGN KEY (teacher_id) REFERENCES `teacher` (id)');
        $this->addSql('ALTER TABLE help ADD CONSTRAINT FK_8875CAC98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('ALTER TABLE private_challenge ADD CONSTRAINT FK_7FC9C0DB41807E1D FOREIGN KEY (teacher_id) REFERENCES `teacher` (id)');
        $this->addSql('ALTER TABLE private_challenge ADD CONSTRAINT FK_7FC9C0DBBF396750 FOREIGN KEY (id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE public_challenge ADD CONSTRAINT FK_FA2E52D041807E1D FOREIGN KEY (teacher_id) REFERENCES `teacher` (id)');
        $this->addSql('ALTER TABLE public_challenge ADD CONSTRAINT FK_FA2E52D0BF396750 FOREIGN KEY (id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651CAB445C5C FOREIGN KEY (group_status_id) REFERENCES `student_group` (id)');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('ALTER TABLE `student_group` ADD CONSTRAINT FK_E5F73D5841807E1D FOREIGN KEY (teacher_id) REFERENCES `teacher` (id)');
        $this->addSql('ALTER TABLE `student_group` ADD CONSTRAINT FK_E5F73D581A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('ALTER TABLE `student_group` ADD CONSTRAINT FK_E5F73D58BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_group_help ADD CONSTRAINT FK_CC02EA3D4DDF95DC FOREIGN KEY (student_group_id) REFERENCES `student_group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_group_help ADD CONSTRAINT FK_CC02EA3DD3F165E7 FOREIGN KEY (help_id) REFERENCES help (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `teacher` ADD CONSTRAINT FK_B0F6A6D51A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('ALTER TABLE `teacher` ADD CONSTRAINT FK_B0F6A6D5BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thymio_challenge ADD CONSTRAINT FK_6875BFD7BF396750 FOREIGN KEY (id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user_guest` ADD CONSTRAINT FK_E5F73D58BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge_student_group DROP FOREIGN KEY FK_6C91BFCB98A21AC6');
        $this->addSql('ALTER TABLE help DROP FOREIGN KEY FK_8875CAC98A21AC6');
        $this->addSql('ALTER TABLE private_challenge DROP FOREIGN KEY FK_7FC9C0DBBF396750');
        $this->addSql('ALTER TABLE public_challenge DROP FOREIGN KEY FK_FA2E52D0BF396750');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651C98A21AC6');
        $this->addSql('ALTER TABLE thymio_challenge DROP FOREIGN KEY FK_6875BFD7BF396750');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1A9A7125');
        $this->addSql('ALTER TABLE `student_group` DROP FOREIGN KEY FK_E5F73D581A9A7125');
        $this->addSql('ALTER TABLE `teacher` DROP FOREIGN KEY FK_B0F6A6D51A9A7125');
        $this->addSql('ALTER TABLE student_group_help DROP FOREIGN KEY FK_CC02EA3DD3F165E7');
        $this->addSql('ALTER TABLE challenge_student_group DROP FOREIGN KEY FK_6C91BFCB4DDF95DC');
        $this->addSql('ALTER TABLE child DROP FOREIGN KEY FK_22B35429D4528E64');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651CAB445C5C');
        $this->addSql('ALTER TABLE student_group_help DROP FOREIGN KEY FK_CC02EA3D4DDF95DC');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AA41807E1D');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C41807E1D');
        $this->addSql('ALTER TABLE private_challenge DROP FOREIGN KEY FK_7FC9C0DB41807E1D');
        $this->addSql('ALTER TABLE public_challenge DROP FOREIGN KEY FK_FA2E52D041807E1D');
        $this->addSql('ALTER TABLE `student_group` DROP FOREIGN KEY FK_E5F73D5841807E1D');
        $this->addSql('ALTER TABLE `student_group` DROP FOREIGN KEY FK_E5F73D58BF396750');
        $this->addSql('ALTER TABLE `teacher` DROP FOREIGN KEY FK_B0F6A6D5BF396750');
        $this->addSql('DROP TABLE challenge');
        $this->addSql('DROP TABLE challenge_student_group');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE child');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE help');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE private_challenge');
        $this->addSql('DROP TABLE public_challenge');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE `student_group`');
        $this->addSql('DROP TABLE student_group_help');
        $this->addSql('DROP TABLE `teacher`');
        $this->addSql('DROP TABLE thymio_challenge');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE `user_guest`');
    }
}
