<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261030100000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Online marriage: online.marriage_application (portal service + ownerCode, signatures of spouses); marriage.applicant_info.phone_number';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE online.marriage_application_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE online.marriage_application (id INT NOT NULL, marriage_application_id INT NOT NULL, status SMALLINT NOT NULL, service VARCHAR(50) NOT NULL, owner_code INT NOT NULL, applicant_role VARCHAR(10) NOT NULL, groom_signed BOOLEAN DEFAULT false NOT NULL, bride_signed BOOLEAN DEFAULT false NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F804B7F5EA75EC64 ON online.marriage_application (marriage_application_id)');
        $this->addSql('CREATE UNIQUE INDEX uq_online_marriage_service_owner ON online.marriage_application (service, owner_code)');
        $this->addSql('COMMENT ON COLUMN online.marriage_application.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE online.marriage_application ADD CONSTRAINT FK_F804B7F5EA75EC64 FOREIGN KEY (marriage_application_id) REFERENCES marriage.marriage_application (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE marriage.applicant_info ADD phone_number VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE marriage.applicant_info DROP phone_number');
        $this->addSql('ALTER TABLE online.marriage_application DROP CONSTRAINT FK_F804B7F5EA75EC64');
        $this->addSql('DROP TABLE online.marriage_application');
        $this->addSql('DROP SEQUENCE online.marriage_application_id_seq CASCADE');
    }
}
