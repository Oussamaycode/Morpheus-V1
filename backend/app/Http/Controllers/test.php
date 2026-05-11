Créer une classe abstraite CloudGaming avec :
 attribut : heuresJeu
 méthode abstraite : calculerPrix()
Créer deux classes : SessionStandard, SessionPremium
Règles :
Session standard : 15 DH par heure
Session premium : 25 DH par heure + 20 DH fixe
Afficher :
 // Session standard : 45 DH
 // Session premium : 95 DH

<?php

abstract class CloudGaming

{
    protected $heuresJeu;

    public function __constrcut($heuresJeu){
        $this->heuresJeu=$heuresJeu;
    }

    abstract public function calculerPrix();
}

class SessionPremium extends CloudGaming

{
    public function calculerPrix($nombreHeures){
        $prix=$nombreHeures*this->heuresJeu +20
        return $prix ;
    }


}

class SessionPremium extends CloudGaming

{
    public function calculerPrix($nombreHeures){
        
        return ;
    }


}

$sessionStandard=new SessionStandard(3);

$sessionPremium=new SessionPremium(3);

echo $sessionPremium->calculerPrix()