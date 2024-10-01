<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\Uid\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240930123203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $questionsData = [
            [
                'text' => '1 + 1 =',
                'variants' => [
                    '3',
                    '2',
                    '0',
                ],
                'correct' => [2],
            ],
            [
                'text' => '2 + 2 =',
                'variants' => [
                    '4',
                    '3 + 1',
                    '10',
                ],
                'correct' => [1, 2],
            ],
            [
                'text' => '3 + 3 =',
                'variants' => [
                    '1 + 5',
                    '1',
                    '6',
                    '2 + 4',
                ],
                'correct' => [1, 3, 4],
            ],
            [
                'text' => '4 + 4 =',
                'variants' => [
                    '8',
                    '4',
                    '0',
                    '0 + 8',
                ],
                'correct' => [1, 4],
            ],
            [
                'text' => '5 + 5 =',
                'variants' => [
                    '6',
                    '18',
                    '10',
                    '9',
                    '0',
                ],
                'correct' => [3],
            ],
            [
                'text' => '6 + 6 =',
                'variants' => [
                    '3',
                    '9',
                    '0',
                    '12',
                    '5 + 7',
                ],
                'correct' => [4, 5],
            ],
            [
                'text' => '7 + 7 =',
                'variants' => [
                    '5',
                    '14',
                ],
                'correct' => [2],
            ],
            [
                'text' => '8 + 8 =',
                'variants' => [
                    '16',
                    '12',
                    '9',
                    '5',
                ],
                'correct' => [1],
            ],
            [
                'text' => '9 + 9 =',
                'variants' => [
                    '18',
                    '9',
                    '17 + 1',
                    '2 + 16',
                ],
                'correct' => [1, 3, 4],
            ],
            [
                'text' => '10 + 10 =',
                'variants' => [
                    '0',
                    '2',
                    '8',
                    '20',
                ],
                'correct' => [4],
            ],
        ];

        foreach ($questionsData as $questionData) {
            $questionId = Uuid::v4()->toRfc4122();

            $questionText = addslashes($questionData['text']);

            $this->addSql("INSERT INTO questions (id, text) VALUES ('$questionId', '$questionText')");

            $answerVariants = [];
            foreach ($questionData['variants'] as $index => $variantText) {
                $answerVariantId = Uuid::v4()->toRfc4122();
                $variantTextEscaped = addslashes($variantText);
                $this->addSql("INSERT INTO answer_variants (id, question_id, variant) VALUES ('$answerVariantId', '$questionId', '$variantTextEscaped')");
                $answerVariants[$index + 1] = $answerVariantId;
            }

            foreach ($questionData['correct'] as $correctIndex) {
                $correctAnswerId = Uuid::v4()->toRfc4122();
                $answerVariantId = $answerVariants[$correctIndex];

                $this->addSql("INSERT INTO correct_answers (id, question_id, answer_variant_id) VALUES ('$correctAnswerId', '$questionId', '$answerVariantId')");
            }
        }
    }

    public function down(Schema $schema): void
    {
    }
}
