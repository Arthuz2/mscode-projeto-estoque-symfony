<?php 

namespace App\Controller\Api\Cliente;

use App\Entity\Cliente;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\BuscarClientesAtivosService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/clientes", name:"buscar_clientes")]
class ClienteController extends AbstractController
{
    public function __invoke(
       BuscarClientesAtivosService $service,
    ): JsonResponse {
        try {
            return new JsonResponse($service->execute());
        } catch (\Throwable $e) {
            return new JsonResponse(
              ['error' => $e->getMessage()],
             Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }

    #[Route('/cliente/ativar/{id}', name: '_ativar')]
    public function ativarOuDesativar(int $id, EntityManagerInterface $entityManager): Response
    {
        $cliente = $entityManager->getRepository(Cliente::class)->find($id);
    
        if (!$cliente) {
            throw $this->createNotFoundException('Cliente não encontrado');
        }
        
        if (!$cliente->isAtivo()){
        $this->addFlash('sucess', 'O cliente foi ativado.');
        $cliente->setStatus(true);
        }
        else{
        $this->addFlash('sucess', 'O cliente foi desativado.');
        $cliente->setStatus(false);
        }

        $entityManager->flush();
    
        return $this->redirectToRoute('listar_clientes');
    }
}    