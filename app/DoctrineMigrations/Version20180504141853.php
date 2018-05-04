<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180504141853 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE matiere_optionnelle DROP FOREIGN KEY FK_DD1226A4A37DB6D4');
        $this->addSql('ALTER TABLE optionnelle_matiere DROP FOREIGN KEY FK_DB7EE7A5A37DB6D4');
        $this->addSql('CREATE TABLE matiere_parcours (id INT AUTO_INCREMENT NOT NULL, matieres_id INT DEFAULT NULL, parcours_id INT DEFAULT NULL, INDEX IDX_2DD9465B82350831 (matieres_id), INDEX IDX_2DD9465B6E38C0DB (parcours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matiere_parcours ADD CONSTRAINT FK_2DD9465B82350831 FOREIGN KEY (matieres_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE matiere_parcours ADD CONSTRAINT FK_2DD9465B6E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id)');
        $this->addSql('DROP TABLE matiere_optionnelle');
        $this->addSql('DROP TABLE optionnelle');
        $this->addSql('DROP TABLE optionnelle_matiere');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE matiere_optionnelle (matiere_id INT NOT NULL, optionnelle_id INT NOT NULL, INDEX IDX_DD1226A4F46CD258 (matiere_id), INDEX IDX_DD1226A4A37DB6D4 (optionnelle_id), PRIMARY KEY(matiere_id, optionnelle_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE optionnelle (id INT AUTO_INCREMENT NOT NULL, type INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE optionnelle_matiere (optionnelle_id INT NOT NULL, matiere_id INT NOT NULL, INDEX IDX_DB7EE7A5A37DB6D4 (optionnelle_id), INDEX IDX_DB7EE7A5F46CD258 (matiere_id), PRIMARY KEY(optionnelle_id, matiere_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matiere_optionnelle ADD CONSTRAINT FK_DD1226A4A37DB6D4 FOREIGN KEY (optionnelle_id) REFERENCES optionnelle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_optionnelle ADD CONSTRAINT FK_DD1226A4F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE optionnelle_matiere ADD CONSTRAINT FK_DB7EE7A5A37DB6D4 FOREIGN KEY (optionnelle_id) REFERENCES optionnelle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE optionnelle_matiere ADD CONSTRAINT FK_DB7EE7A5F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE matiere_parcours');
    }
}
