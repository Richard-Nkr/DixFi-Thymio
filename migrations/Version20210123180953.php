<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210123180953 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE challenge_student_group (challenge_id INT NOT NULL, student_group_id INT NOT NULL, INDEX IDX_6C91BFCB98A21AC6 (challenge_id), INDEX IDX_6C91BFCB4DDF95DC (student_group_id), PRIMARY KEY(challenge_id, student_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE child (id INT AUTO_INCREMENT NOT NULL, group_child_id INT NOT NULL, name_child VARCHAR(30) NOT NULL, first_name_child VARCHAR(30) NOT NULL, INDEX IDX_22B35429D4528E64 (group_child_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE help (id INT NOT NULL, challenge_id INT NOT NULL, content_help LONGTEXT NOT NULL, number_help INT NOT NULL, INDEX IDX_8875CAC98A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `student_group` (id INT NOT NULL, teacher_id INT NOT NULL, chat_id INT NOT NULL, count_succeed INT NOT NULL, INDEX IDX_E5F73D5841807E1D (teacher_id), INDEX IDX_E5F73D581A9A7125 (chat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_group_help (student_group_id INT NOT NULL, help_id INT NOT NULL, INDEX IDX_CC02EA3D4DDF95DC (student_group_id), INDEX IDX_CC02EA3DD3F165E7 (help_id), PRIMARY KEY(student_group_id, help_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `teacher` (id INT NOT NULL, chat_id INT NOT NULL, mail_teacher VARCHAR(150) NOT NULL, name_teacher VARCHAR(100) NOT NULL, first_name_teacher VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_B0F6A6D51A9A7125 (chat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE challenge_student_group ADD CONSTRAINT FK_6C91BFCB98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_student_group ADD CONSTRAINT FK_6C91BFCB4DDF95DC FOREIGN KEY (student_group_id) REFERENCES `student_group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B35429D4528E64 FOREIGN KEY (group_child_id) REFERENCES `student_group` (id)');
        $this->addSql('ALTER TABLE help ADD CONSTRAINT FK_8875CAC98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('ALTER TABLE `student_group` ADD CONSTRAINT FK_E5F73D5841807E1D FOREIGN KEY (teacher_id) REFERENCES `teacher` (id)');
        $this->addSql('ALTER TABLE `student_group` ADD CONSTRAINT FK_E5F73D581A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('ALTER TABLE `student_group` ADD CONSTRAINT FK_E5F73D58BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_group_help ADD CONSTRAINT FK_CC02EA3D4DDF95DC FOREIGN KEY (student_group_id) REFERENCES `student_group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_group_help ADD CONSTRAINT FK_CC02EA3DD3F165E7 FOREIGN KEY (help_id) REFERENCES help (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `teacher` ADD CONSTRAINT FK_B0F6A6D51A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('ALTER TABLE `teacher` ADD CONSTRAINT FK_B0F6A6D5BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE children');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('ALTER TABLE challenge ADD type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE chat CHANGE id_teacher teacher_id INT NOT NULL');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA41807E1D FOREIGN KEY (teacher_id) REFERENCES `teacher` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_659DF2AA41807E1D ON chat (teacher_id)');
        $this->addSql('ALTER TABLE comment ADD teacher_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C41807E1D FOREIGN KEY (teacher_id) REFERENCES `teacher` (id)');
        $this->addSql('CREATE INDEX IDX_9474526C41807E1D ON comment (teacher_id)');
        $this->addSql('ALTER TABLE message CHANGE content_message content_message INT NOT NULL, CHANGE id_chat chat_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F1A9A7125 ON message (chat_id)');
        $this->addSql('ALTER TABLE private_challenge CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE private_challenge ADD CONSTRAINT FK_7FC9C0DBBF396750 FOREIGN KEY (id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE public_challenge ADD id_teacher INT NOT NULL, ADD created_at DATETIME NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE public_challenge ADD CONSTRAINT FK_FA2E52D0BF396750 FOREIGN KEY (id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE status ADD group_status_id INT NOT NULL, ADD challenge_id INT NOT NULL, DROP id_group, DROP id_challenge');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651CAB445C5C FOREIGN KEY (group_status_id) REFERENCES `student_group` (id)');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('CREATE INDEX IDX_7B00651CAB445C5C ON status (group_status_id)');
        $this->addSql('CREATE INDEX IDX_7B00651C98A21AC6 ON status (challenge_id)');
        $this->addSql('ALTER TABLE thymio_challenge CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE thymio_challenge ADD CONSTRAINT FK_6875BFD7BF396750 FOREIGN KEY (id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student_group_help DROP FOREIGN KEY FK_CC02EA3DD3F165E7');
        $this->addSql('ALTER TABLE challenge_student_group DROP FOREIGN KEY FK_6C91BFCB4DDF95DC');
        $this->addSql('ALTER TABLE child DROP FOREIGN KEY FK_22B35429D4528E64');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651CAB445C5C');
        $this->addSql('ALTER TABLE student_group_help DROP FOREIGN KEY FK_CC02EA3D4DDF95DC');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AA41807E1D');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C41807E1D');
        $this->addSql('ALTER TABLE `student_group` DROP FOREIGN KEY FK_E5F73D5841807E1D');
        $this->addSql('CREATE TABLE children (id INT AUTO_INCREMENT NOT NULL, name_child VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, teacher VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name_teacher VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, first_name_teacher VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE `group` (id_teacher INT AUTO_INCREMENT NOT NULL, count_succeed INT NOT NULL, PRIMARY KEY(id_teacher)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE challenge_student_group');
        $this->addSql('DROP TABLE child');
        $this->addSql('DROP TABLE help');
        $this->addSql('DROP TABLE `student_group`');
        $this->addSql('DROP TABLE student_group_help');
        $this->addSql('DROP TABLE `teacher`');
        $this->addSql('ALTER TABLE challenge DROP type');
        $this->addSql('DROP INDEX UNIQ_659DF2AA41807E1D ON chat');
        $this->addSql('ALTER TABLE chat CHANGE teacher_id id_teacher INT NOT NULL');
        $this->addSql('DROP INDEX IDX_9474526C41807E1D ON comment');
        $this->addSql('ALTER TABLE comment DROP teacher_id');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1A9A7125');
        $this->addSql('DROP INDEX IDX_B6BD307F1A9A7125 ON message');
        $this->addSql('ALTER TABLE message CHANGE content_message content_message LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE chat_id id_chat INT NOT NULL');
        $this->addSql('ALTER TABLE private_challenge DROP FOREIGN KEY FK_7FC9C0DBBF396750');
        $this->addSql('ALTER TABLE private_challenge CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE public_challenge DROP FOREIGN KEY FK_FA2E52D0BF396750');
        $this->addSql('ALTER TABLE public_challenge DROP id_teacher, DROP created_at, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651C98A21AC6');
        $this->addSql('DROP INDEX IDX_7B00651CAB445C5C ON status');
        $this->addSql('DROP INDEX IDX_7B00651C98A21AC6 ON status');
        $this->addSql('ALTER TABLE status ADD id_group INT NOT NULL, ADD id_challenge INT NOT NULL, DROP group_status_id, DROP challenge_id');
        $this->addSql('ALTER TABLE thymio_challenge DROP FOREIGN KEY FK_6875BFD7BF396750');
        $this->addSql('ALTER TABLE thymio_challenge CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP type');
    }
}
