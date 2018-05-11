<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180511161553 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, matiere_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_4B98C21F46CD258 (matiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_utilisateur (groupe_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_92C1107D7A45358C (groupe_id), INDEX IDX_92C1107DFB88E14F (utilisateur_id), PRIMARY KEY(groupe_id, utilisateur_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, pole_de_competence_id INT DEFAULT NULL, semestre_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, place INT NOT NULL, place_stagiare INT NOT NULL, INDEX IDX_9014574AC9E7CDE8 (pole_de_competence_id), INDEX IDX_9014574A5577AFDB (semestre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere_optionelle (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, matiere_id INT DEFAULT NULL, ordre INT NOT NULL, INDEX IDX_B13C1906A76ED395 (user_id), INDEX IDX_B13C1906F46CD258 (matiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere_parcours (id INT AUTO_INCREMENT NOT NULL, matieres_id INT DEFAULT NULL, parcours_id INT DEFAULT NULL, optionnel TINYINT(1) NOT NULL, INDEX IDX_2DD9465B82350831 (matieres_id), INDEX IDX_2DD9465B6E38C0DB (parcours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere_professeur (id INT AUTO_INCREMENT NOT NULL, nbHeuresTP INT NOT NULL, nbHeuresTD INT NOT NULL, nbHeureCours INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere_professeur_utilisateur (matiere_professeur_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_814B113F249C5553 (matiere_professeur_id), INDEX IDX_814B113FFB88E14F (utilisateur_id), PRIMARY KEY(matiere_professeur_id, utilisateur_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere_professeur_matiere (matiere_professeur_id INT NOT NULL, matiere_id INT NOT NULL, INDEX IDX_C090D1EA249C5553 (matiere_professeur_id), INDEX IDX_C090D1EAF46CD258 (matiere_id), PRIMARY KEY(matiere_professeur_id, matiere_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parcours (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, annee INT NOT NULL, stagiare TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE semestre_parcours (parcours_id INT NOT NULL, semestre_id INT NOT NULL, INDEX IDX_EB1DE39A6E38C0DB (parcours_id), INDEX IDX_EB1DE39A5577AFDB (semestre_id), PRIMARY KEY(parcours_id, semestre_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pole_de_competence (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pole_de_competence_parcours (id INT AUTO_INCREMENT NOT NULL, parcours_id INT DEFAULT NULL, matiere_id INT DEFAULT NULL, pole_de_competence_id INT DEFAULT NULL, nbrMatiereOptionnelle INT NOT NULL, INDEX IDX_C34812846E38C0DB (parcours_id), INDEX IDX_C3481284F46CD258 (matiere_id), INDEX IDX_C3481284C9E7CDE8 (pole_de_competence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE semestre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, dateDebut DATETIME NOT NULL, dateFin DATETIME NOT NULL, dateDebutChoix DATETIME NOT NULL, dateFinChoix DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, parcours_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', nom VARCHAR(180) NOT NULL, prenom VARCHAR(180) NOT NULL, numeroEtudiant INT DEFAULT NULL, UNIQUE INDEX UNIQ_1D1C63B392FC23A8 (username_canonical), UNIQUE INDEX UNIQ_1D1C63B3A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_1D1C63B3C05FB297 (confirmation_token), UNIQUE INDEX UNIQ_1D1C63B33A14BF69 (numeroEtudiant), INDEX IDX_1D1C63B36E38C0DB (parcours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_matiere (utilisateur_id INT NOT NULL, matiere_id INT NOT NULL, INDEX IDX_EA1FA0D8FB88E14F (utilisateur_id), INDEX IDX_EA1FA0D8F46CD258 (matiere_id), PRIMARY KEY(utilisateur_id, matiere_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_groupe (utilisateur_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_6514B6AAFB88E14F (utilisateur_id), INDEX IDX_6514B6AA7A45358C (groupe_id), PRIMARY KEY(utilisateur_id, groupe_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE groupe_utilisateur ADD CONSTRAINT FK_92C1107D7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_utilisateur ADD CONSTRAINT FK_92C1107DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574AC9E7CDE8 FOREIGN KEY (pole_de_competence_id) REFERENCES pole_de_competence (id)');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574A5577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE matiere_optionelle ADD CONSTRAINT FK_B13C1906A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE matiere_optionelle ADD CONSTRAINT FK_B13C1906F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE matiere_parcours ADD CONSTRAINT FK_2DD9465B82350831 FOREIGN KEY (matieres_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE matiere_parcours ADD CONSTRAINT FK_2DD9465B6E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id)');
        $this->addSql('ALTER TABLE matiere_professeur_utilisateur ADD CONSTRAINT FK_814B113F249C5553 FOREIGN KEY (matiere_professeur_id) REFERENCES matiere_professeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_professeur_utilisateur ADD CONSTRAINT FK_814B113FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_professeur_matiere ADD CONSTRAINT FK_C090D1EA249C5553 FOREIGN KEY (matiere_professeur_id) REFERENCES matiere_professeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_professeur_matiere ADD CONSTRAINT FK_C090D1EAF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE semestre_parcours ADD CONSTRAINT FK_EB1DE39A6E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE semestre_parcours ADD CONSTRAINT FK_EB1DE39A5577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pole_de_competence_parcours ADD CONSTRAINT FK_C34812846E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id)');
        $this->addSql('ALTER TABLE pole_de_competence_parcours ADD CONSTRAINT FK_C3481284F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE pole_de_competence_parcours ADD CONSTRAINT FK_C3481284C9E7CDE8 FOREIGN KEY (pole_de_competence_id) REFERENCES pole_de_competence (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B36E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id)');
        $this->addSql('ALTER TABLE utilisateur_matiere ADD CONSTRAINT FK_EA1FA0D8FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_matiere ADD CONSTRAINT FK_EA1FA0D8F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_groupe ADD CONSTRAINT FK_6514B6AAFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_groupe ADD CONSTRAINT FK_6514B6AA7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE groupe_utilisateur DROP FOREIGN KEY FK_92C1107D7A45358C');
        $this->addSql('ALTER TABLE utilisateur_groupe DROP FOREIGN KEY FK_6514B6AA7A45358C');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21F46CD258');
        $this->addSql('ALTER TABLE matiere_optionelle DROP FOREIGN KEY FK_B13C1906F46CD258');
        $this->addSql('ALTER TABLE matiere_parcours DROP FOREIGN KEY FK_2DD9465B82350831');
        $this->addSql('ALTER TABLE matiere_professeur_matiere DROP FOREIGN KEY FK_C090D1EAF46CD258');
        $this->addSql('ALTER TABLE pole_de_competence_parcours DROP FOREIGN KEY FK_C3481284F46CD258');
        $this->addSql('ALTER TABLE utilisateur_matiere DROP FOREIGN KEY FK_EA1FA0D8F46CD258');
        $this->addSql('ALTER TABLE matiere_professeur_utilisateur DROP FOREIGN KEY FK_814B113F249C5553');
        $this->addSql('ALTER TABLE matiere_professeur_matiere DROP FOREIGN KEY FK_C090D1EA249C5553');
        $this->addSql('ALTER TABLE matiere_parcours DROP FOREIGN KEY FK_2DD9465B6E38C0DB');
        $this->addSql('ALTER TABLE semestre_parcours DROP FOREIGN KEY FK_EB1DE39A6E38C0DB');
        $this->addSql('ALTER TABLE pole_de_competence_parcours DROP FOREIGN KEY FK_C34812846E38C0DB');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B36E38C0DB');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574AC9E7CDE8');
        $this->addSql('ALTER TABLE pole_de_competence_parcours DROP FOREIGN KEY FK_C3481284C9E7CDE8');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574A5577AFDB');
        $this->addSql('ALTER TABLE semestre_parcours DROP FOREIGN KEY FK_EB1DE39A5577AFDB');
        $this->addSql('ALTER TABLE groupe_utilisateur DROP FOREIGN KEY FK_92C1107DFB88E14F');
        $this->addSql('ALTER TABLE matiere_optionelle DROP FOREIGN KEY FK_B13C1906A76ED395');
        $this->addSql('ALTER TABLE matiere_professeur_utilisateur DROP FOREIGN KEY FK_814B113FFB88E14F');
        $this->addSql('ALTER TABLE utilisateur_matiere DROP FOREIGN KEY FK_EA1FA0D8FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_groupe DROP FOREIGN KEY FK_6514B6AAFB88E14F');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE groupe_utilisateur');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE matiere_optionelle');
        $this->addSql('DROP TABLE matiere_parcours');
        $this->addSql('DROP TABLE matiere_professeur');
        $this->addSql('DROP TABLE matiere_professeur_utilisateur');
        $this->addSql('DROP TABLE matiere_professeur_matiere');
        $this->addSql('DROP TABLE parcours');
        $this->addSql('DROP TABLE semestre_parcours');
        $this->addSql('DROP TABLE pole_de_competence');
        $this->addSql('DROP TABLE pole_de_competence_parcours');
        $this->addSql('DROP TABLE semestre');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_matiere');
        $this->addSql('DROP TABLE utilisateur_groupe');
    }
}
