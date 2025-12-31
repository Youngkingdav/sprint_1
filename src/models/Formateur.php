<?php

class Formateur
{
    public ?int $id = null;
    public int $user_id;
    public string $nom;
    public string $prenom;
    public ?string $specialite;
    public ?string $telephone;

    public function __construct(
        int $user_id,
        string $nom,
        string $prenom,
        ?string $specialite = null,
        ?string $telephone = null
    ) {
        $this->user_id = $user_id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->specialite = $specialite;
        $this->telephone = $telephone;
    }
}
