<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221212163532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // migration is auto-generated, with check on id and give_to_id
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, give_to_id INTEGER DEFAULT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT FK_8D93D649980FBC8F FOREIGN KEY (give_to_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE,  CHECK ( id != give_to_id ))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649980FBC8F ON user (give_to_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
    }
}
