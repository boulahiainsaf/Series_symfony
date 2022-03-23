<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/series",name="serie_")
 */
class SerieController extends AbstractController
{
    /**
     * @Route("", name="list")
     */
    public function list(SerieRepository $serieRepository): Response
    {
        $serie=$serieRepository->findBestSerise();

        return $this->render('serie/liste.html.twig', ["series"=>$serie

        ]);
    }
    /**
     * @Route ("/details/{id}",name="details")
     */
    public function details(int $id, SerieRepository $serieRepository):Response
    {
        $serie=$serieRepository->find($id);
        return $this->render('serie/details.html.twig',[
            'serie'=>$serie
        ]);
    }
    /**
     * @Route ("/create",name="create")
     */
    public function create(Request $request,EntityManagerInterface $entityManager):Response
    {
        $serie= new Serie();
        $serie->setDateCreated(new \DateTime('now', new DateTimeZone('Europe/Paris')));
        $serieForm =$this->createForm(SerieType::class ,$serie);
        $serieForm->handleRequest($request);
        if ($serieForm->isSubmitted() && $serieForm->isValid()){

            $entityManager->persist($serie);
            $entityManager->flush();
            $this->addFlash('success','serie est bien ajouter ');
            return $this->redirectToRoute('serie_details',['id'=>$serie->getId()]);

        }
        return $this->render('serie/create.html.twig',[
            'serieForm'=>$serieForm->createView(),
        ]);
    }
    /**
     * @Route ("/demo",name="demo")
     */
    //                  $entityManager = $this->>getDotrine()->getManager():
    public function demo(EntityManagerInterface $entityManager): Response
    {
        //crée une instance de mon entité
        $serie = new Serie();
        //hydratz toute les propiete
        $serie->setName('pif');
        $serie->setBackdrop('lhqsdmo');
        $serie->setPoster('kfjh');
        $serie->setDateCreated(new \DateTime());
        $serie->setFirstairDate(new \DateTime("-1 year"));
        $serie->setLastAirDate(new \DateTime("-6 month"));
        $serie->setGenres('drama');
        $serie->setOverview('bla bla bla ');
        $serie->setPopularity(123.00);
        $serie->setVote(8.2);
        $serie->setStatus('canceled');
        $serie->setTmdId(125547);
        dump($serie);
        $entityManager->persist($serie);
        $entityManager->flush();


        return $this->render('serie/create.html.twig');
    }
/**
 * @Route ("/delete/{id}",name="delete")
 */
public function  delete(Serie $serie,EntityManagerInterface $entityManager)
{
    $entityManager->remove($serie);
    $entityManager->flush();
    return $this->redirectToRoute("maine_home");
}
}
