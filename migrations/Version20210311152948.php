<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210311152948 extends AbstractMigration
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
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP INDEX IDX_E5F73D581A9A7125 ON student_group');
        $this->addSql('ALTER TABLE student_group DROP chat_id');
        $this->addSql('DROP INDEX UNIQ_B0F6A6D51A9A7125 ON teacher');
        $this->addSql('ALTER TABLE teacher DROP chat_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, UNIQUE INDEX UNIQ_659DF2AA41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, chat_id INT NOT NULL, id_user INT NOT NULL, content_message INT NOT NULL, date_message DATETIME NOT NULL, INDEX IDX_B6BD307F1A9A7125 (chat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('DROP TABLE youtube');
        $this->addSql('ALTER TABLE help CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE public_challenge CHANGE name_correction name_correction VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `student_group` ADD chat_id INT NOT NULL');
        $this->addSql('ALTER TABLE `student_group` ADD CONSTRAINT FK_E5F73D581A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('CREATE INDEX IDX_E5F73D581A9A7125 ON `student_group` (chat_id)');
        $this->addSql('ALTER TABLE `teacher` ADD chat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `teacher` ADD CONSTRAINT FK_B0F6A6D51A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B0F6A6D51A9A7125 ON `teacher` (chat_id)');
        $this->addSql('ALTER TABLE thymio_challenge DROP file');
        $this->addSql('ALTER TABLE `user_guest` CHANGE mail mail VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
