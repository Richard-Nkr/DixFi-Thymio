<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210317200711 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_guest_status (id INT AUTO_INCREMENT NOT NULL, user_guest_id INT NOT NULL, challenge_id INT NOT NULL, status_int INT NOT NULL, count_help INT DEFAULT NULL, need_help TINYINT(1) DEFAULT NULL, started_at DATETIME NOT NULL, finished_at DATETIME DEFAULT NULL, INDEX IDX_E10333F47AC74258 (user_guest_id), INDEX IDX_E10333F498A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE youtube (id INT AUTO_INCREMENT NOT NULL, request VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_guest_status ADD CONSTRAINT FK_E10333F47AC74258 FOREIGN KEY (user_guest_id) REFERENCES `user_guest` (id)');
        $this->addSql('ALTER TABLE user_guest_status ADD CONSTRAINT FK_E10333F498A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('DROP TABLE help_user');
        $this->addSql('DROP TABLE student_group_help');
        $this->addSql('ALTER TABLE child DROP FOREIGN KEY FK_22B35429D4528E64');
        $this->addSql('DROP INDEX IDX_22B35429D4528E64 ON child');
        $this->addSql('ALTER TABLE child CHANGE group_child_id student_group_id INT NOT NULL');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B354294DDF95DC FOREIGN KEY (student_group_id) REFERENCES `student_group` (id)');
        $this->addSql('CREATE INDEX IDX_22B354294DDF95DC ON child (student_group_id)');
        $this->addSql('ALTER TABLE private_challenge ADD file VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE thymio_challenge ADD path_video VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE help_user (help_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C819E3D2D3F165E7 (help_id), INDEX IDX_C819E3D2A76ED395 (user_id), PRIMARY KEY(help_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE student_group_help (student_group_id INT NOT NULL, help_id INT NOT NULL, INDEX IDX_CC02EA3D4DDF95DC (student_group_id), INDEX IDX_CC02EA3DD3F165E7 (help_id), PRIMARY KEY(student_group_id, help_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE help_user ADD CONSTRAINT FK_C819E3D2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE help_user ADD CONSTRAINT FK_C819E3D2D3F165E7 FOREIGN KEY (help_id) REFERENCES help (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_group_help ADD CONSTRAINT FK_CC02EA3D4DDF95DC FOREIGN KEY (student_group_id) REFERENCES student_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_group_help ADD CONSTRAINT FK_CC02EA3DD3F165E7 FOREIGN KEY (help_id) REFERENCES help (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user_guest_status');
        $this->addSql('DROP TABLE youtube');
        $this->addSql('ALTER TABLE child DROP FOREIGN KEY FK_22B354294DDF95DC');
        $this->addSql('DROP INDEX IDX_22B354294DDF95DC ON child');
        $this->addSql('ALTER TABLE child CHANGE student_group_id group_child_id INT NOT NULL');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B35429D4528E64 FOREIGN KEY (group_child_id) REFERENCES student_group (id)');
        $this->addSql('CREATE INDEX IDX_22B35429D4528E64 ON child (group_child_id)');
        $this->addSql('ALTER TABLE private_challenge DROP file');
        $this->addSql('ALTER TABLE thymio_challenge DROP path_video');
    }
}
