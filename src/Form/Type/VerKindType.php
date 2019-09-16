<?php
namespace App\Form\Type;

use App\Entity\VerKinds;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
/**
 *
 */
class VerKindType extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('kind',EntityType::class, [
    		'class' => VerKinds::class,
    		'chioce_label' => 'name'
    	]);
    }
}