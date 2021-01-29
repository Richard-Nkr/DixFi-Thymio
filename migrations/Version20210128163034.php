<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<< HEAD:migrations/Version20210128192842.php
final class Version20210128192842 extends AbstractMigration
=======
final class Version20210128163034 extends AbstractMigration
>>>>>>> 404a6ba0c58f9fda6f4eb1829582928d83509c63:migrations/Version20210128163034.php
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD role VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
<<<<<<< HEAD:migrations/Version20210128192842.php
        $this->addSql('ALTER TABLE help CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE `teacher` CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE thymio_challenge CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP role');
=======
        $this->addSql('ALTER TABLE `teacher` CHANGE chat_id chat_id INT NOT NULL');
>>>>>>> 404a6ba0c58f9fda6f4eb1829582928d83509c63:migrations/Version20210128163034.php
    }
}
