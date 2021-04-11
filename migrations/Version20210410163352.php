<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210410163352 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE beneficiary (id INT AUTO_INCREMENT NOT NULL, connect_user_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, validation TINYINT(1) NOT NULL, INDEX IDX_7ABF446A6BB7840B (connect_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE beneficiary ADD CONSTRAINT FK_7ABF446A6BB7840B FOREIGN KEY (connect_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE beneficiary');
    }
}
