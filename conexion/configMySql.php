<?php

class configMySql{

    private $host;

    private $user;

    private $pass;

    private $database;

    

    public function __construct(){

        $this->host='localhost';
        $this->user='root';
		//$this->user='root';
		$this->pass='';
        //$this->pass='cpdteles';

        $this->database='cpdteles';

    }

    public function setHost($host){

        $this->host=$host;

    }

    public function getHost(){

        return $this->host;

    }

    public function setUser($user){

        $this->user=$user;

    }

    public function getUser(){

        return $this->user;

    }

    public function setPass($pass){

        $this->pass=$pass;

    }

    public function getPass(){

        return $this->pass;

    }

    public function setDataBase($database){

        $this->database=$database;

    }

    public function getDataBase(){

        return $this->database;

    }

}

?>