<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309224424 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisation_indice (user_id INT NOT NULL, help_id INT NOT NULL, INDEX IDX_511A3DDBA76ED395 (user_id), INDEX IDX_511A3DDBD3F165E7 (help_id), PRIMARY KEY(user_id, help_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisation_indice ADD CONSTRAINT FK_511A3DDBA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisation_indice ADD CONSTRAINT FK_511A3DDBD3F165E7 FOREIGN KEY (help_id) REFERENCES help (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE participations');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participations (user_id INT NOT NULL, help_id INT NOT NULL, INDEX IDX_FDC6C6E8A76ED395 (user_id), INDEX IDX_FDC6C6E8D3F165E7 (help_id), PRIMARY KEY(user_id, help_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE participations ADD CONSTRAINT FK_FDC6C6E8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participations ADD CONSTRAINT FK_FDC6C6E8D3F165E7 FOREIGN KEY (help_id) REFERENCES help (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE utilisation_indice');
    }
}
