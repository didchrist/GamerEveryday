<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223135651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE availability (id SERIAL NOT NULL, id_user_id INT NOT NULL, game_id INT NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3FB7A2BF79F37AE5 ON availability (id_user_id)');
        $this->addSql('CREATE INDEX IDX_3FB7A2BFE48FD905 ON availability (game_id)');
        $this->addSql('CREATE TABLE availability_global (id SERIAL NOT NULL, user_id_id INT NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9970DF5F9D86650F ON availability_global (user_id_id)');
        $this->addSql('CREATE TABLE game (id SERIAL NOT NULL, game_num VARCHAR(20) NOT NULL, game_name VARCHAR(150) NOT NULL, number_of_player INT NOT NULL, category VARCHAR(150) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE game_group (id SERIAL NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE game_group_game (game_group_id INT NOT NULL, game_id INT NOT NULL, PRIMARY KEY(game_group_id, game_id))');
        $this->addSql('CREATE INDEX IDX_E4ADAD1155102661 ON game_group_game (game_group_id)');
        $this->addSql('CREATE INDEX IDX_E4ADAD11E48FD905 ON game_group_game (game_id)');
        $this->addSql('CREATE TABLE game_group_group (game_group_id INT NOT NULL, group_id INT NOT NULL, PRIMARY KEY(game_group_id, group_id))');
        $this->addSql('CREATE INDEX IDX_E3B92DA055102661 ON game_group_group (game_group_id)');
        $this->addSql('CREATE INDEX IDX_E3B92DA0FE54D947 ON game_group_group (group_id)');
        $this->addSql('CREATE TABLE game_user (id SERIAL NOT NULL, id_user_id INT NOT NULL, id_game_id INT NOT NULL, show_game BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6686BA6579F37AE5 ON game_user (id_user_id)');
        $this->addSql('CREATE INDEX IDX_6686BA653A127075 ON game_user (id_game_id)');
        $this->addSql('CREATE TABLE "group" (id SERIAL NOT NULL, num_group VARCHAR(20) NOT NULL, name_group VARCHAR(255) NOT NULL, acces_group BOOLEAN NOT NULL, description_group TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE message (id SERIAL NOT NULL, id_user_id INT NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6BD307F79F37AE5 ON message (id_user_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, username VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(150) NOT NULL, is_verified BOOLEAN NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_group (id SERIAL NOT NULL, role VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_group_user (user_group_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(user_group_id, user_id))');
        $this->addSql('CREATE INDEX IDX_3AE4BD51ED93D47 ON user_group_user (user_group_id)');
        $this->addSql('CREATE INDEX IDX_3AE4BD5A76ED395 ON user_group_user (user_id)');
        $this->addSql('CREATE TABLE user_group_group (user_group_id INT NOT NULL, group_id INT NOT NULL, PRIMARY KEY(user_group_id, group_id))');
        $this->addSql('CREATE INDEX IDX_94F7A6371ED93D47 ON user_group_group (user_group_id)');
        $this->addSql('CREATE INDEX IDX_94F7A637FE54D947 ON user_group_group (group_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BF79F37AE5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BFE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE availability_global ADD CONSTRAINT FK_9970DF5F9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game_group_game ADD CONSTRAINT FK_E4ADAD1155102661 FOREIGN KEY (game_group_id) REFERENCES game_group (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game_group_game ADD CONSTRAINT FK_E4ADAD11E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game_group_group ADD CONSTRAINT FK_E3B92DA055102661 FOREIGN KEY (game_group_id) REFERENCES game_group (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game_group_group ADD CONSTRAINT FK_E3B92DA0FE54D947 FOREIGN KEY (group_id) REFERENCES "group" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game_user ADD CONSTRAINT FK_6686BA6579F37AE5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game_user ADD CONSTRAINT FK_6686BA653A127075 FOREIGN KEY (id_game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group_user ADD CONSTRAINT FK_3AE4BD51ED93D47 FOREIGN KEY (user_group_id) REFERENCES user_group (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group_user ADD CONSTRAINT FK_3AE4BD5A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group_group ADD CONSTRAINT FK_94F7A6371ED93D47 FOREIGN KEY (user_group_id) REFERENCES user_group (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group_group ADD CONSTRAINT FK_94F7A637FE54D947 FOREIGN KEY (group_id) REFERENCES "group" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE availability DROP CONSTRAINT FK_3FB7A2BF79F37AE5');
        $this->addSql('ALTER TABLE availability DROP CONSTRAINT FK_3FB7A2BFE48FD905');
        $this->addSql('ALTER TABLE availability_global DROP CONSTRAINT FK_9970DF5F9D86650F');
        $this->addSql('ALTER TABLE game_group_game DROP CONSTRAINT FK_E4ADAD1155102661');
        $this->addSql('ALTER TABLE game_group_game DROP CONSTRAINT FK_E4ADAD11E48FD905');
        $this->addSql('ALTER TABLE game_group_group DROP CONSTRAINT FK_E3B92DA055102661');
        $this->addSql('ALTER TABLE game_group_group DROP CONSTRAINT FK_E3B92DA0FE54D947');
        $this->addSql('ALTER TABLE game_user DROP CONSTRAINT FK_6686BA6579F37AE5');
        $this->addSql('ALTER TABLE game_user DROP CONSTRAINT FK_6686BA653A127075');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307F79F37AE5');
        $this->addSql('ALTER TABLE user_group_user DROP CONSTRAINT FK_3AE4BD51ED93D47');
        $this->addSql('ALTER TABLE user_group_user DROP CONSTRAINT FK_3AE4BD5A76ED395');
        $this->addSql('ALTER TABLE user_group_group DROP CONSTRAINT FK_94F7A6371ED93D47');
        $this->addSql('ALTER TABLE user_group_group DROP CONSTRAINT FK_94F7A637FE54D947');
        $this->addSql('DROP TABLE availability');
        $this->addSql('DROP TABLE availability_global');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_group');
        $this->addSql('DROP TABLE game_group_game');
        $this->addSql('DROP TABLE game_group_group');
        $this->addSql('DROP TABLE game_user');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_group');
        $this->addSql('DROP TABLE user_group_user');
        $this->addSql('DROP TABLE user_group_group');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
