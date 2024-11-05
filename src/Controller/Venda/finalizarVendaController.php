<?php 


namespace App\Controller\Venda;

use App\Entity\StatusEnum;
use App\Repository\CarrinhoRepository;
use App\Repository\ProdutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class finalizarVendaController extends AbstractController
{
    private CarrinhoRepository $carrinhoRepository;

    public function __construct(
        CarrinhoRepository $carrinhoRepository
    )
    {
        $this->carrinhoRepository = $carrinhoRepository;
    }

    #[Route("/carrinho/{id}", name: "finalizarVenda")]
public function finalizarVenda(int $id, EntityManagerInterface $em): Response
{
    try {
        // Valida se o carrinho existe
        $carrinho = $this->carrinhoRepository->find($id);

        if (!$carrinho) {
            throw $this->createNotFoundException('Carrinho não encontrado.');
        }

        // Valida se o carrinho contém produtos
        if ($carrinho->getItems()->isEmpty()) { // Verifica se a coleção de itens está vazia
            throw new BadRequestHttpException('O carrinho não contém produtos.');
        }

        // Valida se o carrinho já foi finalizado
        if ($carrinho->getStatus() !== StatusEnum::aberto) { // Certifique-se de comparar com o tipo correto
            throw new BadRequestHttpException('Não é possível finalizar um carrinho que não está pendente.');
        }

        // Altera o status para "aguardando pagamento"
        $carrinho->setStatus(StatusEnum::aguardandoPagamento); // Certifique-se de que o StatusEnum tem esse valor
        $em->persist($carrinho);
        $em->flush();

        return new Response('Carrinho alterado para aguardando pagamento.', Response::HTTP_OK);
    } catch (\Exception $e) {
        // Retorna uma resposta JSON em caso de erro
        return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
    }
}

        
    
}

?>