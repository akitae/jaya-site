<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180512002715 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pole_de_competence_parcours (id INT AUTO_INCREMENT NOT NULL, parcours_id INT DEFAULT NULL, matiere_id INT DEFAULT NULL, pole_de_competence_id INT DEFAULT NULL, nbrMatiereOptionnelle INT NOT NULL, INDEX IDX_C34812846E38C0DB (parcours_id), INDEX IDX_C3481284F46CD258 (matiere_id), INDEX IDX_C3481284C9E7CDE8 (pole_de_competence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pole_de_competence_parcours ADD CONSTRAINT FK_C34812846E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id)');
        $this->addSql('ALTER TABLE pole_de_competence_parcours ADD CONSTRAINT FK_C3481284F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE pole_de_competence_parcours ADD CONSTRAINT FK_C3481284C9E7CDE8 FOREIGN KEY (pole_de_competence_id) REFERENCES pole_de_competence (id)');
        $this->addSql('ALTER TABLE matiere CHANGE place_stagiare place_stagiare INT NOT NULL');
        $this->addSql('ALTER TABLE parcours CHANGE stagiare stagiare TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE semestre_parcours DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE semestre_parcours ADD PRIMARY KEY (parcours_id, semestre_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE pole_de_competence_parcours');
        $this->addSql('ALTER TABLE matiere CHANGE place_stagiare place_stagiare INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE parcours CHANGE stagiare stagiare TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE semestre_parcours DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE semestre_parcours ADD PRIMARY KEY (semestre_id, parcours_id)');
    }
}
