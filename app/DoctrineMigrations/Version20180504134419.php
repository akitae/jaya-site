<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180504134419 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        try {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
            $this->addSql('DROP TABLE matiere_optionnelle');
            $this->addSql('DROP TABLE optionnelle_matiere');
            $this->addSql('ALTER TABLE optionnelle ADD matieres_id INT DEFAULT NULL, ADD semestre_id INT DEFAULT NULL, DROP type');
            $this->addSql('ALTER TABLE optionnelle ADD CONSTRAINT FK_ECAE60C082350831 FOREIGN KEY (matieres_id) REFERENCES matiere (id)');
            $this->addSql('ALTER TABLE optionnelle ADD CONSTRAINT FK_ECAE60C05577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
            $this->addSql('CREATE INDEX IDX_ECAE60C082350831 ON optionnelle (matieres_id)');
            $this->addSql('CREATE INDEX IDX_ECAE60C05577AFDB ON optionnelle (semestre_id)');
        } catch (AbortMigrationException $e) {
            die("erreur : ".$e->getMessage());
        }


    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        try {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
            $this->addSql('CREATE TABLE matiere_optionnelle (matiere_id INT NOT NULL, optionnelle_id INT NOT NULL, INDEX IDX_DD1226A4F46CD258 (matiere_id), INDEX IDX_DD1226A4A37DB6D4 (optionnelle_id), PRIMARY KEY(matiere_id, optionnelle_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
            $this->addSql('CREATE TABLE optionnelle_matiere (optionnelle_id INT NOT NULL, matiere_id INT NOT NULL, INDEX IDX_DB7EE7A5A37DB6D4 (optionnelle_id), INDEX IDX_DB7EE7A5F46CD258 (matiere_id), PRIMARY KEY(optionnelle_id, matiere_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
            $this->addSql('ALTER TABLE matiere_optionnelle ADD CONSTRAINT FK_DD1226A4A37DB6D4 FOREIGN KEY (optionnelle_id) REFERENCES optionnelle (id) ON DELETE CASCADE');
            $this->addSql('ALTER TABLE matiere_optionnelle ADD CONSTRAINT FK_DD1226A4F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
            $this->addSql('ALTER TABLE optionnelle_matiere ADD CONSTRAINT FK_DB7EE7A5A37DB6D4 FOREIGN KEY (optionnelle_id) REFERENCES optionnelle (id) ON DELETE CASCADE');
            $this->addSql('ALTER TABLE optionnelle_matiere ADD CONSTRAINT FK_DB7EE7A5F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
            $this->addSql('ALTER TABLE optionnelle DROP FOREIGN KEY FK_ECAE60C082350831');
            $this->addSql('ALTER TABLE optionnelle DROP FOREIGN KEY FK_ECAE60C05577AFDB');
            $this->addSql('DROP INDEX IDX_ECAE60C082350831 ON optionnelle');
            $this->addSql('DROP INDEX IDX_ECAE60C05577AFDB ON optionnelle');
            $this->addSql('ALTER TABLE optionnelle ADD type INT NOT NULL, DROP matieres_id, DROP semestre_id');
        } catch (AbortMigrationException $e) {
            die("erreur : ".$e->getMessage());
        }


    }
}
