<?php
/*try{
    $dbh =  new PDO('mysql:host=localhost;dbname=blogAula' , 'root', '');
} catch (PDOException $e){
    //tentar reconectar após algum intervalo, por exemplo
    echo "ERROR".$e; 
} 
*/
class DataBase{
    private $host = "localhost";
    private $usuario = "root";
    private $senha = "";
    private $banco = "BlogAula";
    private $porta = "3306";//verificar a porta do seu banco
    private $dbh;

    public function __construct(){
        $dns = 'mysql:host='.$this->host.';port='.$this->porta.';
        dbname='.$this->banco;
     $opções = [
     //armazenar em cache a conexão para ser reutilizada, evitando
     //sobrecarga de uma nova conexão
     PDO::ATTR_PERSISTENT => true,
     //lança um PDOEException se ocorrer um erro
     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];
    try{
        //cria a instancia do PDO
        $this->dbh = new PDO($dns, $this->usuario, $this->senha,
        $opções);
    }catch(PDOException $error){
        print "Error!".$error->getMessage()."<br/>";
        die();
    }
    }//fim do método construtor

}  

    

?>