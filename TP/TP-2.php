<?php
declare(strict_types=1);

class Vehicule {
    private string $marque;
    private string $modele;
    private float $capaciteReservoir;
    private float $niveauEssence;

    public function __construct(string $marque, string $modele, float $capaciteReservoir, float $niveauEssence) {
        $this->marque = $marque;
        $this->modele = $modele;
        $this->capaciteReservoir = $capaciteReservoir;
        $this->niveauEssence = $niveauEssence;
    }

    public function getMarque(): string {
        return $this->marque;
    }

    public function getModele(): string {
        return $this->modele;
    }

    public function getCapaciteReservoir(): float {
        return $this->capaciteReservoir;
    }

    public function getNiveauEssence(): float {
        return $this->niveauEssence;
    }

    public function setNiveauEssence(float $nouveauNiveau): void {
        $this->niveauEssence = $nouveauNiveau;
    }

    public function afficherDetails(): void {
        echo "Le véhicule est une {$this->marque} {$this->modele} avec une capacité totale de {$this->capaciteReservoir} litres.<br>";
        echo "Ce véhicule dispose actuellement de {$this->niveauEssence} litres d'essence.<br>";
    }
}

class Pompe {
    private float $capaciteTotale;

    public function __construct(float $capaciteTotale) {
        $this->capaciteTotale = $capaciteTotale;
    }

    public function getCapaciteTotale(): float {
        return $this->capaciteTotale;
    }

    public function afficherCapacite(): void {
        echo "La pompe contient actuellement {$this->capaciteTotale} litres d'essence.<br>";
    }

    public function ravitailler(Vehicule $vehicule, float $quantite): void {
        echo "Tentative de ravitaillement de {$quantite} L pour le véhicule {$vehicule->getMarque()} {$vehicule->getModele()}<br>";

        if ($quantite > $this->capaciteTotale) {
            echo "La pompe n'a pas assez d'essence. Il reste {$this->capaciteTotale} L dans la pompe.<br>";
            return;
        }

        $espaceDisponible = $vehicule->getCapaciteReservoir() - $vehicule->getNiveauEssence();
        if ($quantite > $espaceDisponible) {
            echo "La quantité demandée dépasse la capacité du réservoir.<br>";
            echo "Le véhicule ne peut ajouter que {$espaceDisponible} L au maximum.<br>";
            return;
        }

        $vehicule->setNiveauEssence($vehicule->getNiveauEssence() + $quantite);
        $this->capaciteTotale -= $quantite;

        echo "Ravitaillé de {$quantite} L avec succès <br>";
        echo "Il reste désormais {$this->capaciteTotale} L dans la pompe.<br>";
    }
}




// 7. Création d’un véhicule
$voiture = new Vehicule("BMW", "X6", 60, 20);

// 8. Création d’une pompe
$pompe = new Pompe(200);

// 9. Affichage des infos initiales
echo "<h3>État initial</h3>";
$voiture->afficherDetails();
$pompe->afficherCapacite();

// 10. Test du ravitaillement
echo "<h3>Tentative 1: ravitaillement de 30 L</h3>";
$pompe->ravitailler($voiture, 30);
$voiture->afficherDetails();

echo "<h3>Tentative 2: ravitaillement de 20 L (réservoir plein)</h3>";
$pompe->ravitailler($voiture, 20);
$voiture->afficherDetails();

echo "<h3>Tentative 3: ravitaillement de 180 L (pompe insuffisante)</h3>";
$pompe->ravitailler($voiture, 180);

echo "<h3>État final</h3>";
$voiture->afficherDetails();
$pompe->afficherCapacite();
