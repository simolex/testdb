<?php
namespace App\Form;

use App\Entity\VerBlocks;
use App\Form\VerKindType;
use App\Repository\VerBlocksRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class VerBlockType extends AbstractType
{
    private $verBlocksRepository;

    public function __construct(VerBlocksRepository $verBlocksRepository)
    {
        $this->verBlocksRepository = $verBlocksRepository;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //dd($this->verBlocksRepository);
        $builder
            ->add('Kind', VerKindType::class, [
                'mapped' => false,
                'help' => 'Разновидность видов работ',
                'label' => 'Вид'
            ])
            ->add('type', EntityType::class,[
                'class' => VerBlocks::class,
                'mapped' => false,
                'choice_label' => 'type',
                'placeholder' => 'Choose a type',
                'choices' => $this->verBlocksRepository->getAllDistinctType(),

            ])
            ->add('attr', EntityType::class,[
                'class' => VerBlocks::class,
                'choice_label' => 'attr',
            ])
            ->add('message', EntityType::class,[
                'class' => VerBlocks::class,
                'choice_label' => 'message',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    /*public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VerBlocks::class

        ]);
    }*/
}