<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180412174652 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE parcours_pole_de_competence');
        $this->addSql('DROP TABLE pole_de_competence_parcours');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE parcours_pole_de_competence (parcours_id INT NOT NULL, pole_de_competence_id INT NOT NULL, INDEX IDX_D5EE4A4A6E38C0DB (parcours_id), INDEX IDX_D5EE4A4AC9E7CDE8 (pole_de_competence_id), PRIMARY KEY(parcours_id, pole_de_competence_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pole_de_competence_parcours (pole_de_competence_id INT NOT NULL, parcours_id INT NOT NULL, INDEX IDX_C3481284C9E7CDE8 (pole_de_competence_id), INDEX IDX_C34812846E38C0DB (parcours_id), PRIMARY KEY(pole_de_competence_id, parcours_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parcours_pole_de_competence ADD CONSTRAINT FK_D5EE4A4A6E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parcours_pole_de_competence ADD CONSTRAINT FK_D5EE4A4AC9E7CDE8 FOREIGN KEY (pole_de_competence_id) REFERENCES pole_de_competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pole_de_competence_parcours ADD CONSTRAINT FK_C34812846E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pole_de_competence_parcours ADD CONSTRAINT FK_C3481284C9E7CDE8 FOREIGN KEY (pole_de_competence_id) REFERENCES pole_de_competence (id) ON DELETE CASCADE');
    }
}
