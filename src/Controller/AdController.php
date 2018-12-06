<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AnnonceType;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{

    /**
     * Permet d'afficher toutes les annonces
     *
     * @param AdRepository $repoAd
     * @return void
     */
    public function index(
        AdRepository $repoAd
    ) {
        //Récupération de toutes les annonces (Ad) de la BDD
        $listeAds = $repoAd->findAll();

        return $this->render('ad/index.html.twig', [
            'listeAds' => $listeAds,
        ]);
    }

    /**
     * Permet d'afficher une annonce particulière
     *
     * @return Response
     */
    public function show(Ad $ad)
    {
        /* Nota : Pas besoin de repository pour récupérer l'annonce.
        Le ParamConverter récupére le "slug" et redonne l'instance de Ad qui correspond */

        return $this->render('ad/show.html.twig', [
            'ad' => $ad,
        ]);
    }

    /**
     * Permet de créer une annonce
     *
     * @return Response
     */

    public function create()
    {
        //Création d'une entité d'annonce
        $ad = new Ad();

        //Création d'une instance de formBuilder qui va coonstruire le formulaire
        $form = $this->createForm(AnnonceType::class, $ad);

        return $this->render('ad/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
