<?php
require_once '../models/Etudiant.php';

class EtudiantController {
    private $etudiantModel;
    
    public function __construct($pdo) {
        $this->etudiantModel = new Etudiant($pdo);
    }
    
    public function creer($data) {
        return $this->etudiantModel->creer($data);
    }
    
    public function tous() {
        return $this->etudiantModel->tous();
    }
}
?>
