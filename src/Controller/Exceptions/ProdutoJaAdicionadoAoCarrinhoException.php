<?php

namespace App\Controller\Exceptions;

class  ProdutoJaAdicionadoAoCarrinhoException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Produto ja adicionado ao carrinho .");
    }
} 