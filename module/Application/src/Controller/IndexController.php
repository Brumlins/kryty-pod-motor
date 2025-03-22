<?php
namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Application\Entity\Produkt;
use Application\Entity\Znacka;
use Application\Entity\Material;

class IndexController extends AbstractActionController
{
    private $entityManager;
    
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function indexAction()
    {
        $page = (int) $this->params()->fromQuery('page', 1);
        $orderBy = $this->params()->fromQuery('order_by', 'id');
        $orderDir = $this->params()->fromQuery('order_dir', 'ASC');
        
        $filters = [];
        $znackaId = (int) $this->params()->fromQuery('znacka_id', 0);
        if ($znackaId > 0) {
            $filters['znacka_id'] = $znackaId;
        }
        
        $materialId = (int) $this->params()->fromQuery('material_id', 0);
        if ($materialId > 0) {
            $filters['material_id'] = $materialId;
        }
        
        $search = $this->params()->fromQuery('search', '');
        if (!empty($search)) {
            $filters['search'] = $search;
        }
        
        $repository = $this->entityManager->getRepository(Produkt::class);
        $produkty = $repository->findAllPaginated($page, 10, $orderBy, $orderDir, $filters);
        $totalCount = $repository->countAll($filters);
        
        $znacky = $this->entityManager->getRepository(Znacka::class)->findAll();
        $materialy = $this->entityManager->getRepository(Material::class)->findAll();
        
        return new ViewModel([
            'produkty' => $produkty,
            'znacky' => $znacky,
            'materialy' => $materialy,
            'page' => $page,
            'orderBy' => $orderBy,
            'orderDir' => $orderDir,
            'filters' => $filters,
            'totalCount' => $totalCount,
            'totalPages' => ceil($totalCount / 10)
        ]);
    }
}
