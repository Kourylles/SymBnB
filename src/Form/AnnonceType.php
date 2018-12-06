<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnonceType extends AbstractType
{
    /**
     * Permet de configurer le label et le placeholder de chaque cham des formulaires
     *
     * @param String $label
     * @param String $placeHolder
     * @return array
     */
    private function getConfiguration($label, $placeHolder) {

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
            ->add('title', 
                TextType::class, 
                $this->getConfiguration("Titre :", "Tapez un Titre."))
            ->add('slug', 
                TextType::class, 
                $this->getConfiguration("Adresse Web :", "Tapez l'adresse de l'annonce (automatique)."))
            ->add('coverImage', 
                UrlType::class, 
                $this->getConfiguration("URL de l'image d'accueil :", "Tapez l'adresse de l'image d'accueil de votre annonce."))
            ->add('introduction', 
                TextType::class, 
                $this->getConfiguration("Introduction :", "Tapez une description globale de votre annonce."))
            ->add('content', 
                TextareaType::class, 
                $this->getConfiguration("Description Détaillée :", "Tapez une description la plus attrayante possible de votre annonce."))
            ->add('price', 
                MoneyType::class, 
                $this->getConfiguration("Prix Par Nuit :", "Indiquez le prix que vous voulez pour une nuit."))
            ->add('rooms', 
                IntegerType::class, 
                $this->getConfiguration("Nombre de Chambre(s) :", "Tapez le nombre de chambre(s) disponible(s).") )
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
