<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312141100 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_guest_status (id INT AUTO_INCREMENT NOT NULL, user_guest_id INT NOT NULL, challenge_id INT NOT NULL, status_int INT NOT NULL, count_help INT DEFAULT NULL, need_help TINYINT(1) DEFAULT NULL, started_at DATETIME NOT NULL, finished_at DATETIME DEFAULT NULL, INDEX IDX_E10333F47AC74258 (user_guest_id), INDEX IDX_E10333F498A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_guest_status ADD CONSTRAINT FK_E10333F47AC74258 FOREIGN KEY (user_guest_id) REFERENCES `user_guest` (id)');
        $this->addSql('ALTER TABLE user_guest_status ADD CONSTRAINT FK_E10333F498A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_guest_status');
        $this->addSql('DROP TABLE youtube');
        $this->addSql('ALTER TABLE help CHANGE id id INT NOT NULL');
    }
}
