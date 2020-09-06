<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200819143747 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rent_ad ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE rent_ad ADD CONSTRAINT FK_2D24E858A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2D24E858A76ED395 ON rent_ad (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rent_ad DROP FOREIGN KEY FK_2D24E858A76ED395');
        $this->addSql('DROP INDEX IDX_2D24E858A76ED395 ON rent_ad');
        $this->addSql('ALTER TABLE rent_ad DROP user_id');
    }
}
