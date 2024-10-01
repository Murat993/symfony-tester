<?php

declare(strict_types=1);

namespace App\Model\Quiz\UseCase\SaveAnswer;


use App\Model\Quiz\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Question $question */
        $question = $options['question'];

        $choices = [];
        foreach ($question->getAnswerVariantsShuffle() as $answer) {
            $choices[$answer->getVariant()] = $answer->getId()->toString();
        }

        $builder
            ->add('answerVariantIds', ChoiceType::class, [
                'choices' => $choices,
                'expanded' => true,
                'multiple' => true,
                'label' => false,
                'required' => true,
                'placeholder' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
            'question' => null,
        ]);

        $resolver->setRequired(['question']);
    }
}
