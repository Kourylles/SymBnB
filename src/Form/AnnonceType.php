<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    /**
     * Permet de configurer le label et le placeholder de chaque cham des formulaires
     *
     * @param String $label
     * @param String $placeHolder
     * @return array
     */
    private function getConfiguration($label, $placeHolder)
    {
        return [
            'label' => $label,
            'attr' => [
                'placeHolder' => $placeHolder,
            ],
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre : ", "Tapez un Titre."))
            ->add('slug', TextType::class, $this->getConfiguration("Adresse Web : ", "Tapez l'adresse de l'annonce (automatique)."))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix Par Nuit : ", "Indiquez le prix que vous voulez par nuit."))
            ->add('introduction')

            ->add('content')

            ->add('coverImage')
            ->add('rooms')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
