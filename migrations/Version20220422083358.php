<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220422083358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedido_call_center CHANGE cliente_id cliente_id INT NOT NULL');
        $this->addSql('ALTER TABLE pedido_call_center ADD CONSTRAINT FK_ECB632C5DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('CREATE INDEX IDX_ECB632C5DE734E51 ON pedido_call_center (cliente_id)');
        $this->addSql('ALTER TABLE pedido_items ADD CONSTRAINT FK_A56BD82B3E57D3BF FOREIGN KEY (pedido_call_center_id) REFERENCES pedido_call_center (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedido_call_center DROP FOREIGN KEY FK_ECB632C5DE734E51');
        $this->addSql('DROP INDEX IDX_ECB632C5DE734E51 ON pedido_call_center');
        $this->addSql('ALTER TABLE pedido_call_center CHANGE cliente_id cliente_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pedido_items DROP FOREIGN KEY FK_A56BD82B3E57D3BF');
    }
}
