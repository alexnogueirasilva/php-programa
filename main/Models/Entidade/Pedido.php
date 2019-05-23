<?php 

namespace main\Models\Entidade;

use DateTime;

class Produto{

    private $codControle;
    private $dataCadastro;
    private $numeroPregao;
    private $numeroAf;
    private $statusCliente;
    private $cliente;

    /**
     * Get the value of codControle
     */ 
    public function getCodControle()
    {
        return $this->codControle;
    }

    /**
     * Set the value of codControle
     *
     * @return  self
     */ 
    public function setCodControle($codControle)
    {
        $this->codControle = $codControle;

        return $this;
    }

    /**
     * Get the value of dataCadastro
     */ 
    public function getDataCadastro()
    {
        return new DateTime($this->dataCadastro);
    }

    /**
     * Set the value of dataCadastro
     *
     * @return  self
     */ 
    public function setDataCadastro($dataCadastro)
    {
        $this->dataCadastro = $dataCadastro;

        return $this;
    }

    /**
     * Get the value of numeroPregao
     */ 
    public function getNumeroPregao()
    {
        return $this->numeroPregao;
    }

    /**
     * Set the value of numeroPregao
     *
     * @return  self
     */ 
    public function setNumeroPregao($numeroPregao)
    {
        $this->numeroPregao = $numeroPregao;

        return $this;
    }

    /**
     * Get the value of numeroAf
     */ 
    public function getNumeroAf()
    {
        return $this->numeroAf;
    }

    /**
     * Set the value of numeroAf
     *
     * @return  self
     */ 
    public function setNumeroAf($numeroAf)
    {
        $this->numeroAf = $numeroAf;

        return $this;
    }

    /**
     * Get the value of statusCliente
     */ 
    public function getStatusCliente()
    {
        return $this->statusCliente;
    }

    /**
     * Set the value of statusCliente
     *
     * @return  self
     */ 
    public function setStatusCliente($statusCliente)
    {
        $this->statusCliente = $statusCliente;

        return $this;
    }

    /**
     * Get the value of cliente
     */ 
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set the value of cliente
     *
     * @return  self
     */ 
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }
}



?>