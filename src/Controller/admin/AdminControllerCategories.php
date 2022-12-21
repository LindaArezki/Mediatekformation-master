<?php


namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminControllerCategories
 *
 * @author linda
 */
class AdminControllerCategories extends AbstractController{
    
    /**
     * 
     * @var CategorieRepository
     */
    private $categorieRepository;
    
     /**
     * @var FormationRepository
     */
    private $formationRepository;

  
    
    public function __construct( CategorieRepository $categorieRepository,formationRepository $formationRepository) {
        $this->categorieRepository = $categorieRepository;
        $this->formationRepository = $formationRepository;
        
    }   
  
   
    
     /**
     * @Route("/admin/categorie", name="admin.categorie")
     * @return Response
     */
     public function index(): Response
    {
        
        $categories = $this->categorieRepository->findAll();
        return $this->render('admin/admin.categorie.html.twig', [
            'categories' => $categories          
        ]);
    }
    
    
    
    /**
     * @Route("/admin/categorie/suppr/{id}", name="admin.categorie.suppr")
     * @param Categorie $categorie
     * @return Response
     */
    public function suppr(Categorie $categorie): Response{
        $this->categorieRepository->remove($categorie, true);
        return $this->redirectToRoute('admin.categorie');
    }

    /**
     * @Route("/admin/categorie/ajout", name="admin.categorie.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response{
        $name = $request->get("name");
        $namecategorie = $this->categorieRepository->findAllEqual($name);
        if ($namecategorie == false) {
            $categories = new Categorie();
            $categories->setName($name);
            $this->categorieRepository->add($categories, true);
            return $this->redirectToRoute('admin.categorie'); 
            
        } 
        return $this->redirectToRoute('admin.categorie');   
    }
}


   


