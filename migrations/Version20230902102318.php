<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230902102318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO interval (id, name, pattern) VALUES (1, '1 time per month', '+ 1 month')");
        $this->addSql("INSERT INTO interval (id, name, pattern) VALUES (2, '1 time per day', '+ 1 day')");
        $this->addSql("INSERT INTO interval (id, name, pattern) VALUES (3, '1 time per year', '+ 1 year')");
        $this->addSql("INSERT INTO interval (id, name, pattern) VALUES (4, '1 time per month, last day', '+ 1 day, last day of this month')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE from interval where pattern in ('+ 1 day', '+ 1 year', '+ 1 month', '+ 1 day, last day of this month')");
    }
}
