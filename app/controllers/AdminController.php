<?php
    Class AdminController extends Controller {
        
        public function __construct() {
            $this->adminModel = $this->model('AdminModel');
        }

        public function index() {
            $this->view('/admin/dashboard');
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
                        
                    }else {
                        $data['file-error'] = "The file is not supported";
                    }
                }elseif($_FILES['import-csv']['error'] === 4) {
                    $data['file-error'] = "No file selected";
                }

                $this->view('/admin/import', $data);
            }else {
                $this->view('/admin/import', $data);
            }
        }
    }
?>