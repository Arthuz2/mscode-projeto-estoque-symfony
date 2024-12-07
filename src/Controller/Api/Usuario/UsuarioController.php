<?php 

namespace App\Controller\Api\Usuario;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\BuscarUsuariosAtivosService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/usuarios", name:"buscar_usuarios")]
class UsuarioController extends AbstractController
{
    public function __invoke(
       BuscarUsuariosAtivosService $service,
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

    #[Route('/usuario/ativar/{id}', name: '_ativar')]
    public function ativarOuDesativar(int $id, EntityManagerInterface $entityManager): Response
    {
        $usuario = $entityManager->getRepository(Usuario::class)->find($id);
    
        if (!$usuario) {
            throw $this->createNotFoundException('Usuario não encontrado');
        }
        
        if (!$usuario->taAtivo()){
        $this->addFlash('sucess', 'O usuario foi ativado.');
        $usuario->setStatus(true);
        }
        else{
        $this->addFlash('sucess', 'O usuario foi desativado.');
        $usuario->setStatus(false);
        }

        $entityManager->flush();
    
        return $this->redirectToRoute('listar_usuarios');
    }
}    