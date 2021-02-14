<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210214130251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge ADD role VARCHAR(20) NOT NULL, ADD solution_path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651CAB445C5C');
        $this->addSql('DROP INDEX IDX_7B00651CAB445C5C ON status');
        $this->addSql('ALTER TABLE status ADD submitted_at DATETIME DEFAULT NULL, CHANGE group_status_id student_group_id INT NOT NULL');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C4DDF95DC FOREIGN KEY (student_group_id) REFERENCES `student_group` (id)');
        $this->addSql('CREATE INDEX IDX_7B00651C4DDF95DC ON status (student_group_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge DROP role, DROP solution_path');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651C4DDF95DC');
        $this->addSql('DROP INDEX IDX_7B00651C4DDF95DC ON status');
        $this->addSql('ALTER TABLE status DROP submitted_at, CHANGE student_group_id group_status_id INT NOT NULL');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651CAB445C5C FOREIGN KEY (group_status_id) REFERENCES student_group (id)');
        $this->addSql('CREATE INDEX IDX_7B00651CAB445C5C ON status (group_status_id)');
    }
}
