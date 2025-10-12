<?php
declare(strict_types=1);

class Livre {
    public string $isbn;
    public string $titre;
    public string $auteur;
    public int $nombrePages;
    private bool $disponible;
    protected string $dateAjout;
    public string $categorie;
    private float $prixAchat;

    public function __construct(
        string $isbn,
        string $titre,
        string $auteur,
        int $nombrePages,
        string $categorie,
        float $prixAchat,
        string $dateAjout
    ) {
        $this->isbn = $isbn;
        $this->titre = $titre;
        $this->auteur = $auteur;
        $this->nombrePages = $nombrePages;
        $this->categorie = $categorie;
        $this->prixAchat = $prixAchat;
        $this->dateAjout = $dateAjout;
        $this->disponible = true;
    }

    public function afficherDetails(): array {
        return [
            'ISBN' => $this->isbn,
            'Titre' => $this->titre,
            'Auteur' => $this->auteur,
            'Pages' => $this->nombrePages,
            'Categorie' => $this->categorie,
            'Disponible' => $this->disponible ? 'Oui' : 'Non',
            'DateAjout' => $this->dateAjout
        ];
    }

    public function emprunter(): bool {
        if ($this->disponible) {
            $this->disponible = false;
            return true;
        }
        return false;
    }

    public function retourner(): bool {
        if (!$this->disponible) {
            $this->disponible = true;
            return true;
        }
        return false;
    }

    public function estDisponible(): bool {
        return $this->disponible;
    }

    public function calculerAgeEnBibliotheque(string $dateActuelle): int {
        $date1 = new DateTime($this->dateAjout);
        $date2 = new DateTime($dateActuelle);
        $interval = $date1->diff($date2);
        return $interval->days;
    }

    public function obtenirResume(): string {
        return $this->titre;
    }

    public function getPrixAchat(): float {
        return $this->prixAchat;
    }

    public function getDateAjout(): string {
        return $this->dateAjout;
    }
}

class Bibliotheque {
    public string $nom;
    public string $adresse;
    private int $nombreLivres = 0;
    public bool $ouvert = true;
    private array $livres = [];
    private array $livresEmpruntes = [];
    protected int $capaciteMax;

    public function __construct(string $nom, string $adresse, int $capaciteMax) {
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->capaciteMax = $capaciteMax;
    }

    public function ajouterLivre(string $isbn, string $titre, string $auteur, int $pages, string $categorie, float $prix, string $date): bool {
        if ($this->nombreLivres >= $this->capaciteMax) {
            return false;
        }

        $livre = new Livre($isbn, $titre, $auteur, $pages, $categorie, $prix, $date);
        $this->livres[] = $livre;
        $this->nombreLivres++;
        return true;
    }
    
    public function rechercherLivre(string $titre): ?string {
        foreach ($this->livres as $livre) {
            if (strcasecmp($livre->titre, $titre) === 0) {
                return "Livre trouvé : " . $livre->titre . " par " . $livre->auteur;
            }
        }
        return null;
    }

    public function obtenirStatistiques(): array {
        $disponibles = 0;
        $empruntes = 0;
        foreach ($this->livres as $livre) {
            if ($livre->estDisponible()) {
                $disponibles++;
            } else {
                $empruntes++;
            }
        }
        return [
            'Total' => $this->nombreLivres,
            'Disponibles' => $disponibles,
            'Empruntes' => $empruntes
        ];
    }

    public function fermerBibliotheque(): void {
        $this->ouvert = false;
    }

    public function calculerValeurCollection(): ?float {
        if (empty($this->livres)) {
            return null;
        }
        $total = 0.0;
        foreach ($this->livres as $livre) {
            $total += $livre->getPrixAchat();
        }
        return $total;
    }

    public function listerLivresParCategorie(string $categorie): array {
        $liste = [];
        foreach ($this->livres as $livre) {
            if (strcasecmp($livre->categorie, $categorie) === 0) {
                $liste[] = $livre->afficherDetails();
            }
        }
        return $liste;
    }

    public function emprunterLivre(string $titre): bool {
        foreach ($this->livres as $livre) {
            if (strcasecmp($livre->titre, $titre) === 0 && $livre->emprunter()) {
                $this->livresEmpruntes[] = $livre;
                return true;
            }
        }
        return false;
    }

    public function retournerLivre(string $titre): bool {
        foreach ($this->livresEmpruntes as $key => $livre) {
            if (strcasecmp($livre->titre, $titre) === 0 && $livre->retourner()) {
                unset($this->livresEmpruntes[$key]);
                return true;
            }
        }
        return false;
    }
}



// 1. Création d'une bibliothèque
$biblio = new Bibliotheque("Médiathèque Centrale", "12 rue du Livre", 5);

// 2. Ajout de plusieurs livres
$biblio->ajouterLivre("978-1", "Le Petit Prince", "Saint-Exupéry", 120, "Roman", 12.5, "2022-01-10");
$biblio->ajouterLivre("978-2", "Les Misérables", "Victor Hugo", 900, "Classique", 20.0, "2021-03-15");
$biblio->ajouterLivre("978-3", "1984", "George Orwell", 350, "Science-Fiction", 15.0, "2023-06-01");

// 3. Emprunt et retour
$biblio->emprunterLivre("1984");
$biblio->retournerLivre("1984");

// 4. Vérification des accès

// echo $livre->prixAchat; Propriété privée — provoquerait une erreur


// 5. Test obtenirResume (titre complet)
$livreTest = new Livre("999", "Voyage au centre de la terre", "Jules Verne", 450, "Aventure", 10.0, "2022-02-01");
echo "Titre du livre : " . $livreTest->obtenirResume() . "<br>";
echo "Âge du livre en bibliothèque (au 2025-10-12) : " . $livreTest->calculerAgeEnBibliotheque("2025-10-12") . " jours<br>";

// 6. Statistiques
print_r($biblio->obtenirStatistiques());

// 7. Recherche et listing
echo $biblio->rechercherLivre("Les Misérables") . "<br>";
print_r($biblio->listerLivresParCategorie("Roman"));
echo "Valeur totale de la collection : " . $biblio->calculerValeurCollection() . " €<br>";
