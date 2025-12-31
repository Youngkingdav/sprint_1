<?php

require_once __DIR__ . '/../repositories/FormateurRepository.php';

class US21_CreateFormateurController
{
    private FormateurRepository $repository;

    public function __construct()
    {
        $this->repository = new FormateurRepository();
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $specialite = $_POST['specialite'] ?? null;
            $telephone = $_POST['telephone'] ?? null;

            try {
                $userId = $this->repository->createUser($email, $password);

                $formateur = new Formateur(
                    $userId,
                    $nom,
                    $prenom,
                    $specialite,
                    $telephone
                );

                $this->repository->create($formateur);

                header('Location: /?success=formateur_created');
                exit;

            } catch (Exception $e) {
                $error = "Erreur lors de la création du formateur";
            }
        }

        require __DIR__ . '/../views/us21/create.php';
    }
}
