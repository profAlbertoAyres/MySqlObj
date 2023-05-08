<?php
    abstract class Crud{
        protected $tabela;
        abstract function inserir();
        abstract function atualizar($campo, $id);

<<<<<<< HEAD
        public function listar( $where = null){
            $sqlSelect = "select * from {$this->tabela} $where";
            return Conexao::query($sqlSelect);
=======
        public function listar(){
            $selctSql = "SELECT * FROM {$this->tabela}";
            return Conexao::query($selctSql);
>>>>>>> e5867cb265b4b8d304689c1f3ff0ac5584563269
        }
        public function buscar($campo, $id){
            $selctSql = "SELECT * FROM {$this->tabela} WHERE $campo = {$id}";
            $dados = Conexao::query($selctSql);
            return $dados->fetch_object();
        }

        public function deletar($campo,$id){
            $selctSql = "DELETE FROM {$this->tabela} WHERE $campo = {$id}";
            return Conexao::query($selctSql);
        }
    }