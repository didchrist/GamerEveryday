<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221200933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE availability (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, game_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, INDEX IDX_3FB7A2BF79F37AE5 (id_user_id), INDEX IDX_3FB7A2BFE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE availability_global (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, INDEX IDX_9970DF5F9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, game_num VARCHAR(20) NOT NULL, game_name VARCHAR(150) NOT NULL, number_of_player INT NOT NULL, category VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_user (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_game_id INT NOT NULL, show_game TINYINT(1) NOT NULL, INDEX IDX_6686BA6579F37AE5 (id_user_id), INDEX IDX_6686BA653A127075 (id_game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, group_num VARCHAR(20) NOT NULL, group_name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_game (id INT AUTO_INCREMENT NOT NULL, id_group_id INT NOT NULL, INDEX IDX_A716AFCAE8F35D2 (id_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_game_game (group_game_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_88D0141628F8D09 (group_game_id), INDEX IDX_88D0141E48FD905 (game_id), PRIMARY KEY(group_game_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_B6BD307F79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(150) NOT NULL, is_verified TINYINT(1) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_group (id INT AUTO_INCREMENT NOT NULL, id_group_id INT NOT NULL, id_user_id INT NOT NULL, role VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_8F02BF9DAE8F35D2 (id_group_id), INDEX IDX_8F02BF9D79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BF79F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BFE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE availability_global ADD CONSTRAINT FK_9970DF5F9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE game_user ADD CONSTRAINT FK_6686BA6579F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE game_user ADD CONSTRAINT FK_6686BA653A127075 FOREIGN KEY (id_game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE group_game ADD CONSTRAINT FK_A716AFCAE8F35D2 FOREIGN KEY (id_group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE group_game_game ADD CONSTRAINT FK_88D0141628F8D09 FOREIGN KEY (group_game_id) REFERENCES group_game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_game_game ADD CONSTRAINT FK_88D0141E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_group ADD CONSTRAINT FK_8F02BF9DAE8F35D2 FOREIGN KEY (id_group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE user_group ADD CONSTRAINT FK_8F02BF9D79F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE availability DROP FOREIGN KEY FK_3FB7A2BF79F37AE5');
        $this->addSql('ALTER TABLE availability DROP FOREIGN KEY FK_3FB7A2BFE48FD905');
        $this->addSql('ALTER TABLE availability_global DROP FOREIGN KEY FK_9970DF5F9D86650F');
        $this->addSql('ALTER TABLE game_user DROP FOREIGN KEY FK_6686BA6579F37AE5');
        $this->addSql('ALTER TABLE game_user DROP FOREIGN KEY FK_6686BA653A127075');
        $this->addSql('ALTER TABLE group_game DROP FOREIGN KEY FK_A716AFCAE8F35D2');
        $this->addSql('ALTER TABLE group_game_game DROP FOREIGN KEY FK_88D0141628F8D09');
        $this->addSql('ALTER TABLE group_game_game DROP FOREIGN KEY FK_88D0141E48FD905');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F79F37AE5');
        $this->addSql('ALTER TABLE user_group DROP FOREIGN KEY FK_8F02BF9DAE8F35D2');
        $this->addSql('ALTER TABLE user_group DROP FOREIGN KEY FK_8F02BF9D79F37AE5');
        $this->addSql('DROP TABLE availability');
        $this->addSql('DROP TABLE availability_global');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_user');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE group_game');
        $this->addSql('DROP TABLE group_game_game');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_group');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
