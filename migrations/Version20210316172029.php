<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210316172029 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1A9A7125');
        $this->addSql('ALTER TABLE student_group DROP FOREIGN KEY FK_E5F73D581A9A7125');
        $this->addSql('ALTER TABLE teacher DROP FOREIGN KEY FK_B0F6A6D51A9A7125');
        $this->addSql('CREATE TABLE student_group_help (student_group_id INT NOT NULL, help_id INT NOT NULL, INDEX IDX_CC02EA3D4DDF95DC (student_group_id), INDEX IDX_CC02EA3DD3F165E7 (help_id), PRIMARY KEY(student_group_id, help_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student_group_help ADD CONSTRAINT FK_CC02EA3D4DDF95DC FOREIGN KEY (student_group_id) REFERENCES `student_group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_group_help ADD CONSTRAINT FK_CC02EA3DD3F165E7 FOREIGN KEY (help_id) REFERENCES help (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE help_user');
        $this->addSql('DROP TABLE message');
        $this->addSql('ALTER TABLE help DROP FOREIGN KEY FK_8875CAC98A21AC6');
        $this->addSql('ALTER TABLE help ADD CONSTRAINT FK_8875CAC98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('ALTER TABLE status ADD comment LONGTEXT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_E5F73D581A9A7125 ON student_group');
        $this->addSql('ALTER TABLE student_group DROP chat_id');
        $this->addSql('DROP INDEX UNIQ_B0F6A6D51A9A7125 ON teacher');
        $this->addSql('ALTER TABLE teacher ADD progression TINYINT(1) DEFAULT NULL, DROP chat_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, UNIQUE INDEX UNIQ_659DF2AA41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE help_user (help_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C819E3D2D3F165E7 (help_id), INDEX IDX_C819E3D2A76ED395 (user_id), PRIMARY KEY(help_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, chat_id INT NOT NULL, id_user INT NOT NULL, content_message INT NOT NULL, date_message DATETIME NOT NULL, INDEX IDX_B6BD307F1A9A7125 (chat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE help_user ADD CONSTRAINT FK_C819E3D2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE help_user ADD CONSTRAINT FK_C819E3D2D3F165E7 FOREIGN KEY (help_id) REFERENCES help (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('DROP TABLE student_group_help');
        $this->addSql('ALTER TABLE help DROP FOREIGN KEY FK_8875CAC98A21AC6');
        $this->addSql('ALTER TABLE help ADD CONSTRAINT FK_8875CAC98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE status DROP comment');
        $this->addSql('ALTER TABLE `student_group` ADD chat_id INT NOT NULL');
        $this->addSql('ALTER TABLE `student_group` ADD CONSTRAINT FK_E5F73D581A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('CREATE INDEX IDX_E5F73D581A9A7125 ON `student_group` (chat_id)');
        $this->addSql('ALTER TABLE `teacher` ADD chat_id INT DEFAULT NULL, DROP progression');
        $this->addSql('ALTER TABLE `teacher` ADD CONSTRAINT FK_B0F6A6D51A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B0F6A6D51A9A7125 ON `teacher` (chat_id)');
    }
}
