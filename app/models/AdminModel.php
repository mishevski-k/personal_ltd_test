<?php

    //Admin Model for our AdminController
    class AdminModel {
        private $db;

        public function __construct() {
            $this->db = new Database; //Instatiating our database class
        }

        //Method to check if the table exists
        public function tableExists($table){
            $this->db->query("SHOW TABLES WHERE Tables_in_personal_ltd_test = '{$table}'");

            $this->db->execute();

            if($this->db->rowCount() > 0){
                return true;
            }else {
                return false;
            }
        }

        //Method to retrieve all calls, $column for filtering with $key, $ordery By and $order for ordering (default by date and DESC) LIMIT and offset
        public function getCalls($column = "", $key = "", $order_by = 'date', $order = "DESC", $limit = 0, $offset = 0){
            if($this->tableExists('calls')){ //checking if table exists
                if($column == ""){ //checking if we are filtering by column
                    if($limit === 0) { //checking if we have a limit
                        $this->db->query("SELECT * FROM calls ORDER BY $order_by $order ");
                    }elseif($offset == 0) { //cehking if we have a offset
                        $this->db->query("SELECT * FROM calls ORDER BY $order_by $order LIMIT $limit");
                    }else {
                        $this->db->query("SELECT * FROM calls ORDER BY $order_by $order LIMIT $limit OFFSET $offset");
                    }
                }else {
                    if($limit === 0) {
                        $this->db->query("SELECT * FROM calls WHERE $column = '$key' ORDER BY $order_by $order ");
                    }elseif($offset == 0) {
                        $this->db->query("SELECT * FROM calls WHERE $column = '$key' ORDER BY $order_by $order LIMIT $limit");
                    }else {
                        $this->db->query("SELECT * FROM calls WHERE $column = '$key' ORDER BY $order_by $order LIMIT $limit OFFSET $offset");
                    }
                }
                

                if($this->db->execute()){ //executing and returnng the data from the sgl query
                    return $this->db->resultSet();
                }else {
                    return false;
                }
               
            }
        }

        //Method to compute a users avarage extercal call score
        public function getAvarageScore($user) {
            if($this->tableExists('calls')){ 
                $this->db->query("SELECT * FROM calls WHERE user = '$user'"); //Query to get all calls from a specific user

                if($this->db->execute()){
                    $data = $this->db->resultSet();

                    $score = 0;
                    $calls = 0;
                    foreach($data as $row){
                        if($row->duration > 10) {
                            $score = $score + $row->external_call_score; //calculating sum of all scores for calls with a duration greater than 10
                            $calls = $calls + 1; //keeping track f how many calls are valid
                        }
                    }

                    return floor($score / $calls); // Diving our sum of all scores with rowcount to find our avarage score and return it
                }
            }
        }

        //methos to find a specific call, with a $key and $column for filtering for calls (default id), $order_by and $order for ordering (default date and DESC) and limit (default 1)
        public function getCall($key, $column = "id", $order_by = 'date', $order = 'DESC', $limit = 1){
            if($this->tableExists('calls')){
                $this->db->query("SELECT * FROM calls WHERE $column = '$key' ORDER BY $order_by $order LIMIT $limit"); //query to find a specific call

                if($this->db->execute()){
                    return $this->db->single(); //returning the call
                }else {
                    return false;
                }
            }
        }

        //method to get all users from our table
        public function getAllUsers(){
            if($this->tableExists('calls')){
                $this->db->query("SELECT DISTINCT(user) FROM calls");

                if($this->db->execute()){
                    return $this->db->resultSet(); //returning all users
                }else {
                    return false;
                }
            }
        }

        //method to find all clients 
        public function getAllClients(){
            if($this->tableExists('calls')){
                $this->db->query("SELECT DISTINCT(client) FROM calls");

                if($this->db->execute()){
                    return $this->db->resultSet(); //returning all client
                }else {
                    return false;
                }
            }
        }

        //method for retrieving all cleint types
        public function getClientTypies(){
            if($this->tableExists('calls')){
                $this->db->query("SELECT DISTINCT(client_type) FROM calls");

                if($this->db->execute()){
                    return $this->db->resultSet(); //returning all client types
                }else {
                    return false;
                }
            }
        }

        //Method to update a specifi call
        public function updateCall($data) {
            if($this->tableExists("calls")){
                //query to update a call with a spicific id
                $this->db->query("UPDATE calls SET user=:user, client=:client, client_type=:client_type, date=:date, duration=:duration, type_of_call=:type_of_call, external_call_score=:external_call_score, updated_at=:updated_at WHERE id = {$data['id']}");

                //binding all placeholders with the data we provide
                $this->db->bind(":user", $data['data']['select-user']);
                $this->db->bind(":client", $data['data']['select-client']);
                $this->db->bind(":client_type", $data['data']['select-client-type']);
                $this->db->bind(":date", $data['data']['date']);
                $this->db->bind(":duration", $data['data']['duration']);
                $this->db->bind(":type_of_call", $data['data']['type_of_call']);
                $this->db->bind(":external_call_score", $data['data']['external_call_score']);
                $this->db->bind(":updated_at", $data['date_now']);

                //updating the call
                if($this->db->execute()){
                    return true;
                }else{
                    return false;
                }
            }
        }

        //deleting a call
        public function deleteCall($key, $column = "id"){
            if($this->tableExists('calls')){
                $this->db->query("DELETE FROM calls WHERE $column = '$key' ");

                if($this->db->execute()){
                    return true;
                }else{
                    return false;
                }
            }
        }

        //Method to create a new call
        public function newCall($data){
            $this->db->query("INSERT INTO calls (user, client, client_type, date, duration, type_of_call, external_call_score, created_at, updated_at) VALUES (:user, :client, :client_type, :date, :duration, :type_of_call, :external_call_score, :created_at, :updated_at) ");

            //binding our placeholders with the provided data
            $this->db->bind(":user", $data['data']['select-user']);
            $this->db->bind(":client", $data['data']['select-client']);
            $this->db->bind(":client_type", $data['data']['select-client-type']);
            $this->db->bind(":date", date("Y-m-d H:i:s", strtotime($data['data']['date'])));
            $this->db->bind(":duration", $data['data']['duration']);
            $this->db->bind(":type_of_call", $data['data']['type_of_call']);
            $this->db->bind(":external_call_score", $data['data']['external_call_score']);
            $this->db->bind(":created_at", $data['date_now']);
            $this->db->bind(":updated_at", $data['date_now']);

            //creating the new call
            if($this->db->execute()){
                return true;
            }else {
                return false;
            }

        }

        //importing data from our csv file to the database
        public function import($data) {
            //query for inserting into the database
            $this->db->query("INSERT INTO calls (user, client, client_type, date, duration, type_of_call, external_call_score, created_at, updated_at) VALUES (:user, :client, :client_type, :date, :duration, :type_of_call, :external_call_score, :created_at, :updated_at) ");

            //foreach row binding the placeholders and executing the query
            foreach($data['data'] as $row){
                $this->db->bind(":user", $row['User']);
                $this->db->bind(":client", $row['Client']);
                $this->db->bind(":client_type", $row['Client Type']);
                $this->db->bind(":date", $row['Date']);
                $this->db->bind(":duration", $row['Duration']);
                $this->db->bind(":type_of_call", $row['Type of Call']);
                $this->db->bind(":external_call_score", $row['External Call Score']);
                $this->db->bind(":created_at", $data['date_now']);
                $this->db->bind(":updated_at", $data['date_now']);

                $this->db->execute();
            }

            return true;
        }

        
        
    }

?>