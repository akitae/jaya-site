<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180509152657 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE parcours_semestre');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE parcours_semestre (parcours_id INT NOT NULL, semestre_id INT NOT NULL, INDEX IDX_F3EF10436E38C0DB (parcours_id), INDEX IDX_F3EF10435577AFDB (semestre_id), PRIMARY KEY(parcours_id, semestre_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parcours_semestre ADD CONSTRAINT FK_F3EF10435577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parcours_semestre ADD CONSTRAINT FK_F3EF10436E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id) ON DELETE CASCADE');
    }
}
