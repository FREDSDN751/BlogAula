<?php
class Database{
    private $host = 'localhost';
    private $usuario = 'mydatabase';
    private $senha = '1234';
    private $banco = 'blog_aula';
    private $porta = '3306';//verificar a portado seu banco
    private $dbh;
    private $stmt;

    public function __construct(){
        //fonte de dados ou dns que contem as informaçoes para conectar ao banco de dados

        $dns = 'mysql:host='.$this->host.';port='.$this->porta.'dbmame=' .$this->banco;

        $opcoes = [
            //armazenar em cache a conexao para ser reutilizada, 
            //evitando sobrecarga de uma nova conexao

            PDO::ATTR_PERSISTENT => true,
            // lança um PDOException se ocorrer um erro
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        try {
            //cria a istancia do PDO
            $this->dbh = new PDO($dns, $this->usuario, $this->senha, $opcoes);
        } catch (PDOException $error) {
            print "Error!";$error->getMessage()."<br/>";
            die();
        }//fim do catch

    }//fim do metodo construtor
    // prepara o statement com query
    public function query($sql){
        //prepara a consulta sql
        $this->stmt = $this->dbh->prepare($sql);
    }//fim da funçao query
    //vincula um valor a um parametro
    public function bind($parametro, $valor, $tipo = null){
        if (is_null($tipo)):
            switch(true):
                case is_int($valor):
                    $tipo = PDO::PARAM_INT;
                    break;
                case is_bool($valor):
                    $tipo = PDO::PARAM_BOOL;
                    break;
                case is_null($valor):
                    $tipo = PDO::PARAM_NULL;
                    break;
                default:
                    $tipo = PDO::PARAM_STR;
            endswitch;
        endif;
        $this->stmt->bindValue($parametro, $valor, $tipo);
    }//fim da funçao bind
    //executa prepared statement
    public function executa(){
        return $this->stmt->execute();
    }//fim da classe executa

    //obtem um unico registro
    public function resultado(){
        $this->executa();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }//fim da funçao resultado
    //obtem um conjunto de registros
    public function resultados(){
        $this->executa();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }//fim da funçao resultados
    //retorna o numero de linhas afetadas pela ultima instruçao sql
    public function totalResultados(){
        return $this->stmt->rowCount();
    }//fim da função totalresultados
    //retorna o último ID inserido no banco de dados 
    public function ultimoIdInserido(){
        return $this->dbh->lastInsertId();
    }
}//fim da classe Database