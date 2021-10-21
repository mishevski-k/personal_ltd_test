<?php

    //Controller for Admin functions and views (inhericts from core controller)
    Class AdminController extends Controller {
        
        public function __construct() {
            $this->adminModel = $this->model('AdminModel');  //Connection to the appropriate model
        }

        public function index() {
            $data = [
                'users' => $this->adminModel->getALlUsers(), //Retrieving all users from calls table via admin model getAllUsers Method
            ];

            $this->view('/admin/dashboard', $data); //Displaying dashboard via with the appropiete data
        }
        

        //Method that retrieves all calls with offset for pages, first page will have a offset of zero, second of 1 * 100 = 100, third will have 2 * 100 = 200 etc...
        public function calls(){

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $offset = $_POST['page_number'] * 100; 
                $data = [
                    'calls' => $this->adminModel->getCalls("", "", 'id', 'ASC', 100, $offset), // Retrieving all calls Ordering by id ASC with a LIMIT of 100 and appropirate offset
                    'page_number' => $_POST['page_number']
                ];
    
                $this->view("/admin/callsTable", $data); //Displaying a table with the data gathered form the admin model
            }else {
                header("location: ". URLROOT); //Redirecting to home page if method is get
            }
            
        }

        //Method to get specific call via its id
        public function call($id){

            if($_SERVER['REQUEST_METHOD'] === 'POST'){

                $data = [
                    'call' => $this->adminModel->getCall($id), //Retrieving the call
                    'users' => $this->adminModel->getALlUsers(),//Retrieving all users
                    'clients' => $this->adminModel->getAllClients(), //Retrieving all client
                    'client_typies' => $this->adminModel->getClientTypies(),//Retrieving all client types
                    'date_error' => "", //passing variables for error handling
                    'duration_error' => "",
                    'score_error' => "",
                ];

                $this->view("/admin/editcall", $data); // Displaying view of a specific call
            }else {
                header("location: ". URLROOT);
            }
        }

        //Method to delete a call via its id
        public function deleteCall($id){
            if($_SERVER['REQUEST_METHOD'] === "POST"){ //You can only delete if the method is post
                if($this->adminModel->deleteCall($id)){ //Via Admin model we delete the specific call if it deletes we will be redirected to our home page
                    header("location:". URLROOT);
                }else {
                    die("An error has eccured");
                }
            }else {
                header("location: ". URLROOT);
            }
        }

        //Method to edit a call
        public function editCall($id){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){ //Only possible if the method is post

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //filtering the data from our Post body

                $data = [
                    'id' => $id, //Id of the post
                    'data' => $_POST, //data from the form 
                    'call' => $this->adminModel->getCall($id), //Data of the specific call
                    'users' => $this->adminModel->getALlUsers(), //Retrieving all users
                    'clients' => $this->adminModel->getAllClients(), //Retrieving all clients
                    'client_typies' => $this->adminModel->getClientTypies(),//Retrieving all client type
                    'date_error' => "", //variables for error handling
                    'duration_error' => "",
                    'score_error' => "",
                    'date_now' => date("Y-m-d H:i:s"), //datetime for when we update the call, 
                ];


                //Error handling for tha date field, checking if the date is set to empty and if it has invalid characters
                if(empty($data['data']['date'])){
                    $data['date_error'] = "Date cant be empty";
                }elseif(!preg_match('/^[0-9- :]*$/', $data['data']['date'])){
                    $data['date_error'] = "Your format is not supported";
                }

                //Error handling for duration field, checking if the field is empty
                if(empty($data['data']['duration'])){
                    $data['duration_error'] = "duration can't be empy";
                }

                //Error handlig for external_call_score field, checking if its empty
                if(empty($data['data']['external_call_score'])){
                    $data['score_error'] = "External call score can't be empty";
                }

                //Checking if we have error in our form, if we have we will be redirected to the edit page with our error printed, if we have will update the call
                if(empty($data['data']['date_error']) && empty($data['data']['duration_error']) && empty($data['data']['score_error'])){
                    if($this->adminModel->updateCall($data)){ //updateing the call via admin model Method updateCall
                        header("location: ". URLROOT);
                    }else {
                        die("An error occured");
                    }
                    // var_dump($_POST);
                }else {
                    $this->view("/admin/editcall", $data); //Redirecting to editCall if we have errors
                }

               
            }else {
                header("location: ". URLROOT);
            }
        }

        //Method to create a newCall
        public function newCall(){

            //Data for our new call form
            $data = [
                'users' => $this->adminModel->getALlUsers(), //Retrieving all user
                'clients' => $this->adminModel->getAllClients(), //Retrieving all clients
                'client_typies' => $this->adminModel->getClientTypies(), //Retrieving all client types
                'date_error' => "", //varriables for error handling
                'duration_error' => "",
                'score_error' => "",
                'user_error' => "",
                'client_error' => "",
                'client_type_error' => "",
                'type_of_call_error' => "",
            ];

            if($_SERVER['REQUEST_METHOD'] === 'POST'){

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //Sanitizing the Post data

                $data['data'] = $_POST; //Data form our form
                $data['date_now'] = date("Y-m-d H:i:s"); //date for creteing the new call


                //below are error hanlers for if any of our field are empty
                if(empty($data['select-user'])){
                    $data['user_error'] = "User field can't be empty";
                }

                if(empty($data['select-client'])){
                    $data['client_error'] = "Client field can't be empty";
                }

                if(empty($data['select-client_type'])){
                    $data['client_type_error'] = "Client Type field can't be empty";
                }

                if(empty($data['data']['date'])){
                    $data['date_error'] = "Date field cant be empty";
                }

                if(empty($data['data']['duration'])){
                    $data['duration_error'] = "duration field can't be empy";
                }

                if(empty($data['data']['type_of_call'])){
                    $data['type_of_call_error'] = "Type of call field can't be empty";
                }

                if(empty($data['data']['external_call_score'])){
                    $data['score_error'] = "External call score field can't be empty";
                }


                //checking if we have errors in our form, if we have it will redirect us to the new call view, if not we will move forward to the creation of the new cal
                if(empty($data['data']['user_error']) && empty($data['data']['client_error']) && empty($data['data']['client_type_error']) && empty($data['data']['date_error']) && empty($data['data']['duration_error']) && empty($data['data']['type_of_call_error']) && empty($data['data']['score_error'])){
                    if($this->adminModel->newCall($data)){ //with admin model creating the new call
                        header("location: ". URLROOT);
                    }else {
                        die("An error occured");
                    }
                }else {
                    $this->view("/admin/newCall", $data); //redirecting to ediCall if we have errors
                }
            }else{
                $this->view("/admin/newCall", $data); //redirecting to editCall if method is get
            }
        }

        //Method to find user via name
        public function user($key) {
            $user = explode("_", $key); //making a array from our $key with the users name and surname as results
            $key = str_replace("_", " ", $key); //replacing _ with whitespace from our key for finding our user
            
            $data = [
                "calls" => $this->adminModel->getCalls("user", $key, "date", "DESC"), //Retrieving all calls the user has made with method get calls, where we look by collumns user with $key, order by date DESC
                "user_name" => $user[0], //users name is the first item in our array
                "user_surname" => $user[1], //user surname is our second item in our array
                "avarage_score" => $this->adminModel->getAvarageScore($key), // retrieving the users avarage externall call score computed by the method getAvarageScore in out admin Model
                "limit" => 5, //Limit for how many calls to display
            ];

            $this->view("/admin/user", $data); //Displaying the view with the users data

            
        }

        //Method to import our .csv file into our database
        public function import() {
            $data = [
                'file-error' => "", //variable for error handling
            ];

            if($_SERVER['REQUEST_METHOD'] === "POST") { //If the method is post we will import the data, if its get we will just display the view,
                if($_FILES['import-csv']['error'] === 0){ //checking if the $_FILES error attribure is 0 = no errors found, uplaod success
                    $ext = pathinfo($_FILES['import-csv']['name'], PATHINFO_EXTENSION); //Geting the extens
                    $whitlisted_ext = ['csv'];
                    if(in_array($ext, $whitlisted_ext)) {
                        $file = file($_FILES['import-csv']['tmp_name']);
                        $import_data = [];
                        for($i = 1; $i < count($file); $i++){
                            $csv_entry[]=explode(',', $file[$i]);

                            $row = [
                                'User' => formatString($csv_entry[0][0]),
                                'Client' => formatString($csv_entry[0][1]),
                                'Client Type' => formatString($csv_entry[0][2]),
                                'Date' => formatString($csv_entry[0][3]),
                                'Duration' => formatString($csv_entry[0][4]),
                                'Type of Call' => formatString($csv_entry[0][5]),
                                'External Call Score' => formatString($csv_entry[0][6]),
                            ];

                            $import_data[] = $row;
                            $row = [];
                            $csv_entry = [];
                        }

                        $data = [
                            'file-error' => "",
                            'data' => $import_data,
                            'date_now' => date("Y-m-d H:i:s"),
                        ];
                    }else {
                        $data['file-error'] = "The file is not supported";
                    }
                }elseif($_FILES['import-csv']['error'] === 4) {
                    $data['file-error'] = "No file selected";
                }

                if($data['file-error'] === "") {
                    if($this->adminModel->import($data)){
                        header("location:". URLROOT . "/admin");
                    } else{
                        die("An error occured");
                    }
                    
                }else {
                    $this->view('/admin/import', $data);
                }

            }else {
                $this->view('/admin/import', $data);
            }
        }
    }
?>