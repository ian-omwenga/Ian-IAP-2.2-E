<?php
class dbconnect{
    private $connection;
    private $db_type;
    private $db_host;
    private $db_port;
    private $db_user;
    private $db_pass;
    private $db_name;

    public function __construct($db_type, $db_host, $db_port, $db_user, $db_pass, $db_name){
        $this->db_type = $db_type;
        $this->db_host = $db_host;
        $this->db_user = $db_port;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
        $this->connection($db_type, $db_host, $db_port, $db_user, $db_pass, $db_name);
    }
    public function connection($db_type, $db_host, $db_port, $db_user, $db_pass, $db_name){
        switch($db_type){
            case 'MySQLi':
                if($db_port<>Null){
                    $db_host .= ":" . $db_port;
                }
                $this->connection = new mysqli($db_host, $db_user, $db_pass, $db_name);
                if($this->connection->connect_error){
                    return "Connection Failed" . $this->connection->connect_error;
                }else{
                    print "Connected Successfully";
                }
                break;
            case 'PDO':
                if($db_port<>Null){
                    $db_host .= ":" . $db_port;
                }
                try {
                    $this->connection = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
                    // set the PDO error mode to exception
                    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    echo "Connected successfully :-)";
                  } catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                  }
                break;
        }
    }

    public function insert($table, $data){
        ksort($data);
        $fielDetails = NULL;
        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = implode("', '", array_values($data));
        $sth = "INSERT INTO $table (`$fieldNames`) VALUES ('$fieldValues')";
        
        switch($this->db_type){
            case 'MySQLi' :
                if($this->connection->query($sth) === TRUE){
                    return TRUE;
                }else{
                    // return "Error: " . $sth . "<br>" . $this->connection->error;
                }

                break;
            case 'PDO' :
                try{
                    $this->connection->exec($sth);
                    return TRUE;
                  } catch(PDOException $e) {
                    return $sth . "<br>" . $e->getMessage();
                  }
        }
    }
    public function select($sql){
        switch ($this->db_type) {
            case 'MySQLi':
                $result = $this->connection->query($sql);
                return $result ? $result->fetch_assoc() : null;
                break;
            case 'PDO':
                $stmt = $this->connection->prepare($sql);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
                break;
        }
    }
    
    public function select_while($sql){
        switch ($this->db_type) {
            case 'MySQLi':
                $result = $this->connection->query($sql);
                $res = [];
                while($row = $result->fetch_assoc()) {
                    $res[] = $row;
                }
                return $res;
                break;        
            case 'PDO':
                $stmt = $this->connection->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                break;
        }
    }
    
    public function update($table, $data, $where){
        $wer = '';
        if (is_array($where)) {
            foreach ($where as $key => $value) {
                $wer .= "$key = '$value' AND ";
            }
            $wer = substr($wer, 0, -4); 
            $where = $wer;
        }
    
        ksort($data);  
        $fieldDetails = '';
        foreach ($data as $key => $value) {
            $fieldDetails .= "$key = '$value', ";
        }
        $fieldDetails = rtrim($fieldDetails, ', ');  
    
        if (empty($where)) {
            $sth = "UPDATE $table SET $fieldDetails";
        } else {
            $sth = "UPDATE $table SET $fieldDetails WHERE $where";
        }
    
        return $this->extracted($sth);
    }
    
    public function delete($table, $where){
        $wer = '';
        if (is_array($where)) {
            foreach ($where as $key => $value) {
                $wer .= "$key = '$value' AND ";
            }
            $wer = substr($wer, 0, -4); 
            $where = $wer;
        }
    
        if (empty($where)) {
            $sth = "DELETE FROM $table";
        } else {
            $sth = "DELETE FROM $table WHERE $where";
        }
    
        return $this->extracted($sth);
    }
    
    public function truncate($table){
        $sth = "TRUNCATE $table";
        return $this->extracted($sth);
    }
    
    public function last_id(){
        switch ($this->db_type) {
            case 'MySQLi':
                return $this->connection->insert_id;
                break;    
            case 'PDO':
                return $this->connection->lastInsertId();
                break;
        }
    }
    
    /**
     * Execute SQL query and handle MySQLi and PDO responses
     * @param string $sth
     * @return bool|string
     */
    public function extracted(string $sth){
        switch ($this->db_type) {
            case 'MySQLi':
                if ($this->connection->query($sth) === TRUE) {
                    return TRUE;
                } else {
                    return "Error: " . $sth . "<br>" . $this->connection->error;
                }
                break;        
            case 'PDO':
                try {
                    $stmt = $this->connection->prepare($sth);
                    $stmt->execute();
                    return TRUE;
                } catch (PDOException $e) {
                    return $sth . "<br>" . $e->getMessage();
                }
                break;
        }
    }
    
    function getConnection(){
        return $this->connection;
    }
}