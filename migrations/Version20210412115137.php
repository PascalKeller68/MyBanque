<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210412115137 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction ADD beneficiary_transaction_id INT DEFAULT NULL, DROP beneficiary_transaction');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1C083A207 FOREIGN KEY (beneficiary_transaction_id) REFERENCES beneficiary (id)');
        $this->addSql('CREATE INDEX IDX_723705D1C083A207 ON transaction (beneficiary_transaction_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1C083A207');
        $this->addSql('DROP INDEX IDX_723705D1C083A207 ON transaction');
        $this->addSql('ALTER TABLE transaction ADD beneficiary_transaction INT NOT NULL, DROP beneficiary_transaction_id');
    }
}
