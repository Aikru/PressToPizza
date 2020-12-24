<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201224022652 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD is_archived TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE order_pizza MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE order_pizza DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE order_pizza DROP id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP is_archived');
        $this->addSql('ALTER TABLE order_pizza ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}