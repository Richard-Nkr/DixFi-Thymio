<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210313121609 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE help_user (help_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C819E3D2D3F165E7 (help_id), INDEX IDX_C819E3D2A76ED395 (user_id), PRIMARY KEY(help_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE help_user ADD CONSTRAINT FK_C819E3D2D3F165E7 FOREIGN KEY (help_id) REFERENCES help (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE help_user ADD CONSTRAINT FK_C819E3D2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE student_group_help');
        $this->addSql('DROP TABLE utilisation_indice');
        $this->addSql('ALTER TABLE help DROP FOREIGN KEY FK_8875CAC98A21AC6');
        $this->addSql('ALTER TABLE help ADD CONSTRAINT FK_8875CAC98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE public_challenge CHANGE update_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE status DROP comment');
        $this->addSql('ALTER TABLE teacher DROP progression');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE student_group_help (student_group_id INT NOT NULL, help_id INT NOT NULL, INDEX IDX_CC02EA3D4DDF95DC (student_group_id), INDEX IDX_CC02EA3DD3F165E7 (help_id), PRIMARY KEY(student_group_id, help_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE utilisation_indice (user_id INT NOT NULL, help_id INT NOT NULL, INDEX IDX_511A3DDBA76ED395 (user_id), INDEX IDX_511A3DDBD3F165E7 (help_id), PRIMARY KEY(user_id, help_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE student_group_help ADD CONSTRAINT FK_CC02EA3D4DDF95DC FOREIGN KEY (student_group_id) REFERENCES student_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_group_help ADD CONSTRAINT FK_CC02EA3DD3F165E7 FOREIGN KEY (help_id) REFERENCES help (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisation_indice ADD CONSTRAINT FK_511A3DDBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisation_indice ADD CONSTRAINT FK_511A3DDBD3F165E7 FOREIGN KEY (help_id) REFERENCES help (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE help_user');
        $this->addSql('ALTER TABLE help DROP FOREIGN KEY FK_8875CAC98A21AC6');
        $this->addSql('ALTER TABLE help ADD CONSTRAINT FK_8875CAC98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('ALTER TABLE public_challenge CHANGE updated_at update_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE status ADD comment LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `teacher` ADD progression TINYINT(1) DEFAULT NULL');
    }
}
