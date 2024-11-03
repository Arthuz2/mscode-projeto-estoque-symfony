<?php 


namespace App\Controller\Venda;
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
use App\Repository\CarrinhoRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route("/venda/finalizarVenda/{carrinho_id}", name: "finalizarVenda", methods: ["POST"])]
    function finalizarVenda(int $id): Response
    {

         // Valida se o carrinho existe
         $carrinho = $this->carrinhoRepository->find($id);

      
         if (!$carrinho) {
             throw  $this->createNotFoundException('Carrinho não encontrado.');
         }
 
         // Valida se o carrinho contém produtos
         if (count($carrinho->getProdutos()) === 0) {
             throw new BadRequestHttpException('O carrinho não contém produtos.');
         }
 
         // Valida se o carrinho já foi finalizado
         if ($carrinho->getStatus() !== 'pendente') {
             throw new BadRequestHttpException('Não é possível finalizar um carrinho que não está pendente.');
         }
 
         // Altera o status para "aguardando pagamento"
         $carrinho->setStatus('aguardando pagamento');
         $this->carrinhoRepository->save($carrinho);

    
 
        return new Response('Carrinho alterado para aguardando pagamento.', Response::HTTP_OK);
    }
}

?>