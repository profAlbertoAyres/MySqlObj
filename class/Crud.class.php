<?php
    abstract class Crud{
        protected $tabela;
        abstract function inserir();
        abstract function atualizar($campo, $id);

        public function listar(){
            $sqlSelect = "select * from {$this->tabela}";
            return Conexao::query($sqlSelect);
        }

        public function buscar($campo, $id){
            $sqlSelect = "select * from {$this->tabela} where $campo=$id";
            $dados =  Conexao::query($sqlSelect);
            return $dados->fetch_object();
        }

        public function deletar($campo, $id){
            $sqlSelect = "delete from {$this->tabela} where $campo=$id";
            return  Conexao::query($sqlSelect);
        }
    }