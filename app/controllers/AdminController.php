<?php
    Class AdminController extends Controller {
        
        public function __construct() {
            $this->adminModel = $this->model('AdminModel');
        }

        public function index() {
            $calls_data = $this->adminModel->getCalls('date', 'DESC', 100);

            $data = [
                'calls' => $calls_data,
            ];

            $this->view('/admin/dashboard', $data);
        }

        public function call($id){

            if($_SERVER['REQUEST_METHOD'] === 'POST'){

                $data = [
                    'call' => $this->adminModel->getCall($id),
                    'users' => $this->adminModel->getALlUsers(),
                    'clients' => $this->adminModel->getAllClients(),
                    'client_typies' => $this->adminModel->getClientTypies(),
                    'date_error' => "",
                    'duration_error' => "",
                    'score_error' => "",
                ];

                $this->view("/admin/editcall", $data);
            }else {
                header("location: ". URLROOT);
            }
        }

        public function deleteCall($id){
            if($_SERVER['REQUEST_METHOD'] === "POST"){
                if($this->adminModel->deleteCall($id)){
                    header("location:". URLROOT);
                }else {
                    die("An error has eccured");
                }
            }else {
                header("location: ". URLROOT);
            }
        }

        public function editCall($id){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $data = [
                    'id' => $id,
                    'data' => $_POST,
                    'call' => $this->adminModel->getCall($id),
                    'users' => $this->adminModel->getALlUsers(),
                    'clients' => $this->adminModel->getAllClients(),
                    'client_typies' => $this->adminModel->getClientTypies(),
                    'date_error' => "",
                    'duration_error' => "",
                    'score_error' => "",
                    'date_now' => date("Y-m-d H:i:s"),
                ];

                if(empty($data['data']['date'])){
                    $data['date_error'] = "Date cant be empty";
                }elseif(!preg_match('/^[0-9- :]*$/', $data['data']['date'])){
                    $data['date_error'] = "Your format is not supported";
                }

                if(empty($data['data']['duration'])){
                    $data['duration_error'] = "duration cant be empy";
                }

                if(empty($data['data']['external_call_score'])){
                    $data['score_error'] = "External call score cant be empty";
                }

                if(empty($data['data']['date_error']) && empty($data['data']['duration_error']) && empty($data['data']['score_error'])){
                    if($this->adminModel->updateCall($data)){
                        header("location: ". URLROOT);
                    }else {
                        die("An error occured");
                    }
                    // var_dump($_POST);
                }else {
                    $this->view("/admin/editcall", $data);
                }

               
            }else {
                header("location: ". URLROOT);
            }
        }

        public function import() {
            $data = [
                'file-error' => "",
            ];

            if($_SERVER['REQUEST_METHOD'] === "POST") {
                if($_FILES['import-csv']['error'] === 0){
                    $ext = pathinfo($_FILES['import-csv']['name'], PATHINFO_EXTENSION);
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