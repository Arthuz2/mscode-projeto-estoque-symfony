<?php

namespace App\Controller\Exception;

class CarrinhoJaDescartadoException extends \Exception
{
  public function __construct() {
    parent::__construct("O carrinho já foi descartado.");
  }
}
