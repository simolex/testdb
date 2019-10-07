<?php
namespace App\Form;

use App\Entity\NormBlock;
use App\Repository\NormBlockRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class NormBlockType extends AbstractType
{
    private $normBlockRepository;

    public function __construct(NormBlockRepository $normBlockRepository)
    {
        $this->normBlockRepository = $normBlockRepository;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //dd($this->verBlocksRepository);

            /*->add('Kind', VerKindType::class, [
                'mapped' => false,
                'help' => 'Разновидность видов работ',
                'label' => 'Вид'
            ])*/
        $builder
            ->add('type', EntityType::class,[
                'class' => NormBlock::class,
                'mapped' => false,
                'choice_label' => 'type',
                'placeholder' => 'Choose a type',
                //'choices' => $this->normBlockRepository->getAllDistinctType(),

            ])
            ->add('attr', EntityType::class,[
                'class' => NormBlock::class,
                'choice_label' => 'attr',
            ])
            ->add('message', EntityType::class,[
                'class' => NormBlock::class,
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