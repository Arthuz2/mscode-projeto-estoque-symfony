<?php

namespace App\Controller\Exception;

class CarrinhoNaoPodeSerDescartadoException extends \Exception
{
  public function __construct() {
    parent::__construct("o carrinho precisa estar com status 'em aberto' para ser descartado e o dia de criação deve ser diferente do dia atual", 500); 
  }
}
