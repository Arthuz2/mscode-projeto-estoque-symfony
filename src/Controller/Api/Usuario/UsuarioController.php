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
        // Carrega o usuário com o ID fornecido
        $usuario = $entityManager->getRepository(Usuario::class)->find($id);

        // Caso o usuário não exista, lança uma exceção
        if (!$usuario) {
            throw $this->createNotFoundException('Usuário não encontrado');
        }

        // Verifica o status atual do usuário e altera o estado
        if ($usuario->taAtivo()) {
            // Se o usuário estiver ativo, desativa-o
            $this->addFlash('success', 'O usuário foi desativado.');
            $usuario->setStatus(false); // Marca como desativado
        } else {
            // Se o usuário não estiver ativo, ativa-o
            $this->addFlash('success', 'O usuário foi ativado.');
            $usuario->setStatus(true); // Marca como ativo
        }

        // Persiste a mudança no banco de dados
        $entityManager->flush();

        // Redireciona para a página de listagem de usuários
        return $this->redirectToRoute('listar_usuarios');
    }
}
