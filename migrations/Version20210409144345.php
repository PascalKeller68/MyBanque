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
                                    VALUES ("admin", "admin", "admin@symfony.fr", "$2a$12$LRYlS6grzmtOycCLzA7sEu5cGdVG8FrcynP5Nu0NgXGQVeZEE44Im", "nothing", 1)');
        $this->addSql('INSERT INTO roles_user (roles_id, user_id) VALUES (2, 1)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE roles');
    }
}
