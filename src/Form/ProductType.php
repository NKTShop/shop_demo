<?php
namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
{

    $builder
    ->add('categorys', EntityType::class,[
        'class'=>Category::class,
        'choice_label'=>'namecate'
    ])
    ->add('namep')
    ->add('pricep')
    ->add('description')
    ->add('quantity')
    ->add('file', FileType::class, [
        'label' =>'Product Image',
        'required' =>false,
        'mapped'=>false
    ])
    ->add('image', HiddenType::class,[
        'required'=>false
    ])
    ->add('save', SubmitType::class,[
        'label'=>"Confirm"
    ]);

}
}

?>