<?php

namespace App\Entity;

enum StatusEnum: string
{
  case aberto = 'em aberto';
  case aguardandoPagamento = 'aguardando pagamento';
  case finalizado = 'finalizado';
  case descartado = 'descartado';
}
