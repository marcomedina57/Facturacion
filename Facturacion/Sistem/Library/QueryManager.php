<?php
class QueryManager 
{
        private $pdo;
        function __construct($USER, $PASS, $DB){
            try{
                $this->pdo = new PDO(
                    'mysql:host=localhost;dbname='.$DB.
                    ';charset=utf8', $USER, $PASS,
                    [PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ]
                );
            }
            catch(PDOException $e)
            {
                print "¡Error! " . $e->getMessage();
                die();
            }
        }



        function select1($attr, $table, $where, $param)
        {
            try{
                
                $where = $where ?? "";
                $query = "SELECT ".$attr." FROM ".$table.$where;
                $sth = $this->pdo->prepare($query);
                $sth->execute($param);
                $response = $sth->fetchAll(PDO::FETCH_ASSOC);
                return array("results" => $response);
            }
            catch(PDOException $e)
            {
                return $e->getMessage();
            }
            $pdo = null;
        
        }

        function select2($attr, $table, $pagi_inicial, $pagi_cuantos, $where, $param)
        {
            try{
                
                $query = "SELECT ".$attr." FROM ".$table.$where." LIMIT $pagi_inicial, $pagi_cuantos"; 
                $sth = $this->pdo->prepare($query);
                $sth->execute($param);
                $response = $sth->fetchAll(PDO::FETCH_ASSOC);
                return array("results" => $response);
            }
            catch(PDOException $e)
            {
                return $e->getMessage();
            }
            $pdo = null;
        
        }
        function insert($table, $param, $value)
        {
            try
            {
                $query = "INSERT INTO ".$table.$value;
                $sth = $this->pdo->prepare($query);
                $sth->execute((array)$param);
                return true;
            }
            catch(PDOException $e)
            {
                return $e->getMessage();
            }
        }

        function update($table,$param,$value,$where)
        {
            try
            {   echo 'Programas favoritos';
                print_r($param);
                print_r($value);
                
                $query = "UPDATE ".$table." SET ".$value.$where;
                
                $sth = $this->pdo->prepare($query);
                $sth->execute((array)$param);
                
                return true;
            }
            catch(PDOException $e)
            {
                return $e->getMessage();
            }
        }

        function delete($table, $where, $param)
        {   
            
            try {
            $query = "DELETE FROM ".$table.$where;
            echo $query;
            $sth = $this->pdo->prepare($query);
            
            $sth->execute($param);
            return true;
                }
            catch(PDOException $e)
            {
                return $e->getMessage();
            }
        }
}

?>