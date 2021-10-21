<?php

    class AdminModel {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function tableExists($table){
            $this->db->query("SHOW TABLES WHERE Tables_in_personal_ltd_test = '{$table}'");

            $this->db->execute();

            if($this->db->rowCount() > 0){
                return true;
            }else {
                return false;
            }
        }

        public function getCalls($order_by = 'date', $order = "DESC", $limit = 0){
            if($this->tableExists('calls')){
                if($limit === 0) {
                    $this->db->query("SELECT * FROM calls ORDER BY $order_by $order ");
                }else {
                    $this->db->query("SELECT * FROM calls ORDER BY $order_by $order LIMIT $limit");
                }

                if($this->db->execute()){
                    return $this->db->resultSet();
                }else {
                    return false;
                }
               
            }
        }

        public function getCall($key, $column = "id", $order_by = 'date', $order = 'DESC', $limit = 1){
            if($this->tableExists('calls')){
                $this->db->query("SELECT * FROM calls WHERE $column = '$key' ORDER BY $order_by $order LIMIT $limit");

                if($this->db->execute()){
                    return $this->db->single();
                }else {
                    return false;
                }
            }
        }

        public function getAllUsers(){
            if($this->tableExists('calls')){
                $this->db->query("SELECT DISTINCT(user) FROM calls");

                if($this->db->execute()){
                    return $this->db->resultSet();
                }else {
                    return false;
                }
            }
        }

        public function getAllClients(){
            if($this->tableExists('calls')){
                $this->db->query("SELECT DISTINCT(client) FROM calls");

                if($this->db->execute()){
                    return $this->db->resultSet();
                }else {
                    return false;
                }
            }
        }

        public function getClientTypies(){
            if($this->tableExists('calls')){
                $this->db->query("SELECT DISTINCT(client_type) FROM calls");

                if($this->db->execute()){
                    return $this->db->resultSet();
                }else {
                    return false;
                }
            }
        }

        public function updateCall($data) {
            if($this->tableExists("calls")){
                $this->db->query("UPDATE calls SET user=:user, client=:client, client_type=:client_type, date=:date, duration=:duration, type_of_call=:type_of_call, external_call_score=:external_call_score, updated_at=:updated_at WHERE id = {$data['id']}");

                $this->db->bind(":user", $data['data']['select-user']);
                $this->db->bind(":client", $data['data']['select-client']);
                $this->db->bind(":client_type", $data['data']['select-client-type']);
                $this->db->bind(":date", $data['data']['date']);
                $this->db->bind(":duration", $data['data']['duration']);
                $this->db->bind(":type_of_call", $data['data']['type_of_call']);
                $this->db->bind(":external_call_score", $data['data']['external_call_score']);
                $this->db->bind(":updated_at", $data['date_now']);

                if($this->db->execute()){
                    return true;
                }else{
                    return false;
                }
            }
        }

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

        public function newCall($data){
            $this->db->query("INSERT INTO calls (user, client, client_type, date, duration, type_of_call, external_call_score, created_at, updated_at) VALUES (:user, :client, :client_type, :date, :duration, :type_of_call, :external_call_score, :created_at, :updated_at) ");


            $this->db->bind(":user", $data['data']['select-user']);
            $this->db->bind(":client", $data['data']['select-client']);
            $this->db->bind(":client_type", $data['data']['select-client-type']);
            $this->db->bind(":date", date("Y-m-d H:i:s", strtotime($data['data']['date'])));
            $this->db->bind(":duration", $data['data']['duration']);
            $this->db->bind(":type_of_call", $data['data']['type_of_call']);
            $this->db->bind(":external_call_score", $data['data']['external_call_score']);
            $this->db->bind(":created_at", $data['date_now']);
            $this->db->bind(":updated_at", $data['date_now']);

            if($this->db->execute()){
                return true;
            }else {
                return false;
            }

        }

        public function import($data) {
            $this->db->query("INSERT INTO calls (user, client, client_type, date, duration, type_of_call, external_call_score, created_at, updated_at) VALUES (:user, :client, :client_type, :date, :duration, :type_of_call, :external_call_score, :created_at, :updated_at) ");

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