<?php
    
    /*Classe conjunto de instruções para usar em outro momento */
    Class Usuario{
        private $pdo;
        public $msgerro;

        public function conectar(){
            /* Invocando o variável $pdo*/
            global $pdo;
            define('HOST','localhost');
            define('USER', 'root');
            define('PASS','');
            define('DBNAME','bd_sapiens_user');
            define('PORT', '3306');

            try{

                $pdo = new PDO('mysql:host='. HOST . ';port=' . PORT . ';dbname=' . DBNAME, USER, PASS);

                
            } catch(PDOException $e){
                /* $e está recebendo a mensagem de erro. */
                $msgerro = $e->getMessage();
            }

        }

        //Método para cadastrar usuário

        public function cadastrar($email,$senha){

            global $pdo;

            // verificar se o usuário está cadastrado no banco
            $sql = $pdo->prepare("SELECT id_user FROM tb_usuario WHERE email = :u");
            $sql->bindValue(":u", $email);
            $sql ->execute();

            if($sql->rowCount() > 0){

                return false; //porque usuario já está cadastrado

            }else{

                $sql = $pdo->prepare("INSERT INTO tb_usuario (email, senha)
                VALUES (:u, :s)");
                $sql->bindValue(":u", $email);
                // md5 - criptografia utilizada na $senha.
                $sql ->bindValue(":s",md5($senha));
                //executar o $sql.
                $sql -> execute();

                return true; // Usuário foi inserido com sucesso.

            }
        }

        // método para logar no sistema. parametros para logar no sistema $email e $senha

        public function logar($email, $senha){
            global $pdo;
            
            $sql = $pdo->prepare("SELECT * FROM tb_usuario WHERE email = :n AND senha = :s");
            $sql->bindValue(":n", $email);
            $sql ->bindValue(":s",md5($senha));
            $sql -> execute();

            if($sql->rowCount() > 0){

                //sessão de login função (fetch) transforma todas as informações do select em um ARRAY.
                $dado = $sql->fetch();
                // validando a sessão
                session_start();
                //importa a SESSION É O id_user. ele vai receber do $dado o id_user. verifica a sessão que está sendo com o id no banco.
                $_SESSION['id_user'] = $dado['id_user'];

                return true; // usuário logado no sistema.

            }else{

                return false; // não está logado.

            }


        }

    }



?>