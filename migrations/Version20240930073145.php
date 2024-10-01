<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240930073145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer_variants (id UUID NOT NULL, question_id UUID NOT NULL, variant VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_94D252841E27F6BF ON answer_variants (question_id)');
        $this->addSql('COMMENT ON COLUMN answer_variants.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN answer_variants.question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE correct_answers (id UUID NOT NULL, question_id UUID NOT NULL, answer_variant_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BBA62EC41E27F6BF ON correct_answers (question_id)');
        $this->addSql('CREATE INDEX IDX_BBA62EC454E42191 ON correct_answers (answer_variant_id)');
        $this->addSql('COMMENT ON COLUMN correct_answers.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN correct_answers.question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN correct_answers.answer_variant_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE questions (id UUID NOT NULL, text VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN questions.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE user_answers (id UUID NOT NULL, user_result_id UUID NOT NULL, question_id UUID NOT NULL, answer_variant_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8DDD80C7473BA7 ON user_answers (user_result_id)');
        $this->addSql('CREATE INDEX IDX_8DDD80C1E27F6BF ON user_answers (question_id)');
        $this->addSql('CREATE INDEX IDX_8DDD80C54E42191 ON user_answers (answer_variant_id)');
        $this->addSql('COMMENT ON COLUMN user_answers.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_answers.user_result_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_answers.question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_answers.answer_variant_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE user_results (id UUID NOT NULL, user_id UUID NOT NULL, try INT NOT NULL, status VARCHAR(10) NOT NULL, test_taken_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C7AEFA1EA76ED395 ON user_results (user_id)');
        $this->addSql('COMMENT ON COLUMN user_results.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_results.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE users (id UUID NOT NULL, username VARCHAR(180) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
        $this->addSql('COMMENT ON COLUMN users.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE answer_variants ADD CONSTRAINT FK_94D252841E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE correct_answers ADD CONSTRAINT FK_BBA62EC41E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE correct_answers ADD CONSTRAINT FK_BBA62EC454E42191 FOREIGN KEY (answer_variant_id) REFERENCES answer_variants (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_answers ADD CONSTRAINT FK_8DDD80C7473BA7 FOREIGN KEY (user_result_id) REFERENCES user_results (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_answers ADD CONSTRAINT FK_8DDD80C1E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_answers ADD CONSTRAINT FK_8DDD80C54E42191 FOREIGN KEY (answer_variant_id) REFERENCES answer_variants (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_results ADD CONSTRAINT FK_C7AEFA1EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');


    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE answer_variants DROP CONSTRAINT FK_94D252841E27F6BF');
        $this->addSql('ALTER TABLE correct_answers DROP CONSTRAINT FK_BBA62EC41E27F6BF');
        $this->addSql('ALTER TABLE correct_answers DROP CONSTRAINT FK_BBA62EC454E42191');
        $this->addSql('ALTER TABLE user_answers DROP CONSTRAINT FK_8DDD80C7473BA7');
        $this->addSql('ALTER TABLE user_answers DROP CONSTRAINT FK_8DDD80C1E27F6BF');
        $this->addSql('ALTER TABLE user_answers DROP CONSTRAINT FK_8DDD80C54E42191');
        $this->addSql('ALTER TABLE user_results DROP CONSTRAINT FK_C7AEFA1EA76ED395');
        $this->addSql('DROP TABLE answer_variants');
        $this->addSql('DROP TABLE correct_answers');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE user_answers');
        $this->addSql('DROP TABLE user_results');
        $this->addSql('DROP TABLE users');
    }
}
