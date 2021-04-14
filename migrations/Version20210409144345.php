<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\User;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210409144345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs


        $this->addSql('INSERT INTO roles (role_name) VALUES ("ROLE_USER")');
        $this->addSql('INSERT INTO roles (role_name) VALUES ("ROLE_ADMIN")');

        $this->addSql('INSERT INTO user (firstname, lastname, mail, password, identity_file, validation) 
        VALUES ("Banquier1", "Banquier1", "banquier1@symfony.fr", "$2y$12$CWHHp8Bi3.Y67tbhAbkBZeAmP5vZCym4yNwSXp2QlrzuVYDUniNCK", "nothing", 1)');

        $this->addSql('INSERT INTO user (firstname, lastname, mail, password, identity_file, validation) 
        VALUES ("Banquier2", "Banquier2", "banquier2@symfony.fr", "$2y$12$GZNZ4Uymmv5FIQba9zfg8etA93SdMafXjfccSlRhmS51XNdrKS0uu", "nothing", 1)');

        $this->addSql('INSERT INTO user (firstname, lastname, mail, password, identity_file, validation) 
        VALUES ("Banquier3", "Banquier3", "banquier3@symfony.fr", "$2y$12$YYrBfGl66Ic5/rfuikmR6.3/h0npaxvrccvuDKkL84AO.H4VPteI", "nothing", 1)');

        $this->addSql('INSERT INTO user (firstname, lastname, mail, password, identity_file, validation) 
        VALUES ("Banquier4", "Banquier4", "banquier4@symfony.fr", "$2y$12$lBjxgx6m6aHn.pspHkMBKOIjWXNAvlk7JO45m9Ao21DrenRm1l776", "nothing", 1)');

        $this->addSql('INSERT INTO user (firstname, lastname, mail, password, identity_file, validation) 
        VALUES ("Banquier5", "Banquier5", "banquier5@symfony.fr", "$2y$12$Fj3IZn8jtLRf/lkXJTMYdezdT58QbdjtjPlUrjskDoV3PDcZTFwaO", "nothing", 1)');


        $this->addSql('INSERT INTO roles_user (roles_id, user_id) VALUES (2, 1)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE roles');
    }
}
