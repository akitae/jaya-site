<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180506213530 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B36E38C0DB');
        $this->addSql('DROP INDEX IDX_1D1C63B36E38C0DB ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD username VARCHAR(180) NOT NULL, ADD username_canonical VARCHAR(180) NOT NULL, ADD email_canonical VARCHAR(180) NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD last_login DATETIME DEFAULT NULL, ADD confirmation_token VARCHAR(180) DEFAULT NULL, ADD password_requested_at DATETIME DEFAULT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD confirmation_email TINYINT(1) NOT NULL, ADD typeUtilisateur enum(\'ETUDIANT\', \'PROFESSEUR\', \'ADMIN\'), DROP parcours_id, DROP type, CHANGE nom nom VARCHAR(180) NOT NULL, CHANGE prenom prenom VARCHAR(180) NOT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE numeroEtudiant numeroEtudiant INT NOT NULL, CHANGE valide enabled TINYINT(1) NOT NULL, CHANGE motdepasse salt VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B392FC23A8 ON utilisateur (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3A0D96FBF ON utilisateur (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3C05FB297 ON utilisateur (confirmation_token)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_1D1C63B392FC23A8 ON utilisateur');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3A0D96FBF ON utilisateur');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3C05FB297 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD parcours_id INT DEFAULT NULL, ADD valide TINYINT(1) NOT NULL, ADD type INT NOT NULL, DROP username, DROP username_canonical, DROP email_canonical, DROP enabled, DROP password, DROP last_login, DROP confirmation_token, DROP password_requested_at, DROP roles, DROP confirmation_email, DROP typeUtilisateur, CHANGE email email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE numeroEtudiant numeroEtudiant VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE salt motDePasse VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B36E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B36E38C0DB ON utilisateur (parcours_id)');
    }
}
