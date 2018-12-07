<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AnnonceType;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController {

    /**
     * Permet d'afficher toutes les annonces
     *
     * @param AdRepository $repoAd
     * @return void
     */
    public function index(AdRepository $repoAd) {

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
    public function show(Ad $ad) {
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
    public function create(
        Request $request,
        ObjectManager $entityManager) {
        //Création d'une entité d'annonce
        $ad = new Ad();

        //Création d'une instance de formBuilder qui va coonstruire le formulaire
        $form = $this->createForm(AnnonceType::class, $ad);
        
        //Récupération des données du formulaire.
        //Utilisation de la méthode de gestion de requête du formulaire qui fera le lien avec l'instance de $ad
        $form->handleRequest($request);

        //Traitement du formulaire
        if ($form->isSubmitted() && $form->isValid()) {

            //Préparer DOCTRINE à faire persister chaque image récupérées dans le AdType doit être persister
            foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $entityManager->persist($image);
            }

            $entityManager->persist($ad);
            $entityManager->flush();

            //Information de l'utilisateur
            $this->addFlash(
                'success',
                "L'annonce <strong> {$ad->getTitle()}</strong> a bien été enregistrée !"
            );

            //redirection vers la page de l'annonce qui vient d'être créé
            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
                ]);
        }

        //Revoi le fichier twig en lui passant le formulaire en paramètre
        return $this->render('ad/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
