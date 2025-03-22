<?php
namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Application\Entity\Produkt;
use Application\Entity\Znacka;
use Application\Entity\Material;
use Application\Form\ProduktForm;

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
    
    public function csvAction()
    {
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
        $produkty = $repository->findAllForExport($orderBy, $orderDir, $filters);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=produkty.csv');

        $output = fopen('php://output', 'w');

        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($output, ['ID', 'Kód', 'Značka', 'Materiál', 'Cena', 'Popis']);

        foreach ($produkty as $produkt) {
            fputcsv($output, [
                $produkt->getId(),
                $produkt->getKod(),
                $produkt->getZnacka()->getNazev(),
                $produkt->getMaterial()->getNazev(),
                $produkt->getCena(),
                $produkt->getPopis()
            ]);
        }

        fclose($output);
        exit;
    }
    
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('home');
        }

        $produkt = $this->entityManager->getRepository(Produkt::class)->find($id);
        if (!$produkt) {
            return $this->redirect()->toRoute('home');
        }

        $form = new ProduktForm($this->entityManager);
        $form->bind($produkt);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->entityManager->flush();
                return $this->redirect()->toRoute('home');
            }
        }

        return new ViewModel([
            'form' => $form,
            'produkt' => $produkt
        ]);
    }
}
