<?php
namespace App\Exceptions;
use RuntimeException;
class SemVagasException extends RuntimeException
{
    public function __construct(public readonly int $vagasRestantes)
    { parent::__construct("Só restam {$vagasRestantes} vagas nesta saída."); }
}
