<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180509071006 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE matiere_pole_de_competence');
        $this->addSql('DROP TABLE pole_de_competence_matiere');
        $this->addSql('ALTER TABLE matiere ADD pole_de_competence_id INT');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574AC9E7CDE8 FOREIGN KEY (pole_de_competence_id) REFERENCES pole_de_competence (id)');
        $this->addSql('CREATE INDEX IDX_9014574AC9E7CDE8 ON matiere (pole_de_competence_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE matiere_pole_de_competence (matiere_id INT NOT NULL, pole_de_competence_id INT NOT NULL, INDEX IDX_5CAA9CFFF46CD258 (matiere_id), INDEX IDX_5CAA9CFFC9E7CDE8 (pole_de_competence_id), PRIMARY KEY(matiere_id, pole_de_competence_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pole_de_competence_matiere (pole_de_competence_id INT NOT NULL, matiere_id INT NOT NULL, INDEX IDX_6C072BB4C9E7CDE8 (pole_de_competence_id), INDEX IDX_6C072BB4F46CD258 (matiere_id), PRIMARY KEY(pole_de_competence_id, matiere_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matiere_pole_de_competence ADD CONSTRAINT FK_5CAA9CFFC9E7CDE8 FOREIGN KEY (pole_de_competence_id) REFERENCES pole_de_competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_pole_de_competence ADD CONSTRAINT FK_5CAA9CFFF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pole_de_competence_matiere ADD CONSTRAINT FK_6C072BB4C9E7CDE8 FOREIGN KEY (pole_de_competence_id) REFERENCES pole_de_competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pole_de_competence_matiere ADD CONSTRAINT FK_6C072BB4F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574AC9E7CDE8');
        $this->addSql('DROP INDEX IDX_9014574AC9E7CDE8 ON matiere');
        $this->addSql('ALTER TABLE matiere DROP pole_de_competence_id');
    }
}
