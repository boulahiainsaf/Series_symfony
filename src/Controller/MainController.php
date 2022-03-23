<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/",name="maine_home")
     */
    public function home()
    {
        return $this->render('main/home.html.twig');
    }

    /**
     * @Route("/test",name="maine_test")
     */
    public function test()
    {
        $serie=[
            "title"=>"<h1>game of thrones</h1>",
            "year"=>2000,
        ];
       return $this->render('main/test.html.twig',[
           "myserie"=>$serie,
           "autrevar"=>54949648
       ]);

    }
}