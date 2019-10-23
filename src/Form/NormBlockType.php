<?php
namespace App\Form;

use App\Entity\NormBlock;
use App\Repository\NormBlockRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
             /*$er = $this->normBlockRepository;
                    $root = $er->findOneBy(['code' => 1, 'parent' => null]);
                    $ch = $er->childrenHierarchy($root, false, null, 'asc', true);*/
        $builder
            ->add('name', EntityType::class,[
                'class' => NormBlock::class,
                //'mapped' => false,
                'block_name' => 'choice_type_tag',
                'choice_label' => 'indentedName',
                'placeholder' => 'Choose a type',
                'attr' => [ 'class' => 'custom-select row' ],
                'choice_attr' => function($choice, $key, $value) {
                    return ['class' => 'col-md-6 offset-md-'.strtolower($choice->getLevel())];
                },
                'multiple' => false,
                'expanded' => false ,
                /*'group_by' => function($choice, $key, $value){
                    return $this->normBlockRepository->getPath($choice);
                    //if($choice->getParent()) return $choice->getParent()->getName();
                },*/
                'query_builder' =>
                //'choices' => $ch,
                function () {
                    $er = $this->normBlockRepository;
                    $root = $er->findOneBy(['code' => 1, 'parent' => null]);
                    //return $er->getNodesHierarchyQueryBuilder($root);
                    return $er->getChildrenWithDepthQueryBuilder($root, 2, false, null, 'asc', false);
                }
                //'choices' => $this->normBlockRepository->getAllDistinctType(),

            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NormBlock::class

        ]);
    }
}