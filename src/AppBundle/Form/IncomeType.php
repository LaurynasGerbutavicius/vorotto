<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncomeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'field.label.title'
            ])
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'datepicker'],
                'label' => 'field.label.date'
            ])
            ->add('quantity', NumberType::class, [
                'label' => 'field.label.quantity',
                'attr' => [
                    'data-math-multiply' => json_encode([
                        'field' => $this->getBlockPrefix() . '_price',
                        'target' => $this->getBlockPrefix().'_amount'
                    ])
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'field.label.price',
                'attr' => [
                    'data-math-multiply' => json_encode([
                        'field' => $this->getBlockPrefix() . '_quantity',
                        'target' => $this->getBlockPrefix().'_amount'
                    ])
                ]
            ])
            ->add('amount', MoneyType::class, [
                'label' => 'field.label.amount',
                'disabled' => true
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Income'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_income';
    }


}
