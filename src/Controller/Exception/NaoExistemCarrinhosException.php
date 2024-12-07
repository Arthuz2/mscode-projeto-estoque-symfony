<?php

namespace App\Controller\Exception;

use Exception;

class NaoExistemCarrinhosException extends Exception
{
  public function __construct()
  {
    parent::__construct('Não existem carrinhos');
  }
}
