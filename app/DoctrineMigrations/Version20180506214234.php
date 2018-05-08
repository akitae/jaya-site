<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180506214234 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE utilisateur ADD parcours_id INT DEFAULT NULL, CHANGE typeUtilisateur typeUtilisateur VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B36E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B392FC23A8 ON utilisateur (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3A0D96FBF ON utilisateur (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3C05FB297 ON utilisateur (confirmation_token)');
        $this->addSql('CREATE INDEX IDX_1D1C63B36E38C0DB ON utilisateur (parcours_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B36E38C0DB');
        $this->addSql('DROP INDEX UNIQ_1D1C63B392FC23A8 ON utilisateur');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3A0D96FBF ON utilisateur');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3C05FB297 ON utilisateur');
        $this->addSql('DROP INDEX IDX_1D1C63B36E38C0DB ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP parcours_id, CHANGE typeUtilisateur typeUtilisateur VARCHAR(50) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
