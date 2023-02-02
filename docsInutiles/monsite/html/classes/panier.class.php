<?php
// require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Produit.class.php';
require_once($_SERVER['DOCUMENT_ROOT']."/classes/produit.class.php");
class Panier
{
    protected $m_listeCommandes = array();
    private $m_prixTotal;
    private $m_rabais;
    private $m_prixTotalAvantTaxes;
    private $m_taxes;
    private $m_prixTotalAvecTaxes;
    private $m_etatCommande;

    public function getPrixTotal()
    {
        return $this->m_prixTotal;
    }
    private function setPrixTotal()
    {
        $somme = 0;

        foreach ($this->getItems() as $key => $value) {
            $somme += $value['item']->getPrixUnitaire() * $value['qty'];
        }
        $this->m_prixTotal = $somme;
    }

    public function getRabais()
    {
        return $this->m_rabais;
    }
    private function setRabais()
    {
        switch (true) {
            case $this->getPrixTotal() >= 100:
                $rabais = 0.2 * $this->getPrixTotal();
                break;

            case $this->getPrixTotal() >= 50:
                $rabais = 0.1 * $this->getPrixTotal();
                break;

            default:
                $rabais = 0;
                break;
        }

        $this->m_rabais = $rabais;
    }

    public function getPrixTotalAvantTaxes()
    {
        return $this->m_prixTotalAvantTaxes;
    }
    private function setPrixTotalAvantTaxes()
    {
        $this->m_prixTotalAvantTaxes = $this->getPrixTotal() - $this->getRabais();
    }

    public function getTaxes()
    {
        return $this->m_taxes;
    }
    private function setTaxes()
    {
        $this->m_taxes = ($this->getPrixTotal() - $this->getRabais()) * 0.15;
    }

    public function getPrixTotalAvecTaxes()
    {
        return $this->m_prixTotalAvecTaxes;
    }
    private function setPrixTotalAvecTaxes()
    {
        $this->m_prixTotalAvecTaxes = $this->getPrixTotal() - $this->getRabais() + $this->getTaxes();
    }

    public function updaterTotaux()
    {
        $this->setPrixTotal();
        $this->setRabais();
        $this->setPrixTotalAvantTaxes();
        $this->setTaxes();
        $this->setPrixTotalAvecTaxes();
    }

    public function getEtat()
    {
        return $this->m_etatCommande;
    }
    public function setEtat($p_etatCommande)
    {
        $this->m_etatCommande = $this->$p_etatCommande;
    }

    public function getItems()
    {
        return $this->m_listeCommandes;
    }
    public function getCountItems()
    {
        return count($this->m_listeCommandes);
    }

    public function isEmpty()
    {
        return (empty($this->m_listeCommandes));
    }

    public function addItem(Produit $p_Item, $p_Quantite)
    {
        // if (!$this->valideProduitExist($p_Item)) {

        if ($this->valideQte($p_Quantite) == true) {

            //  item id:
            $id = $p_Item->getId();

            // Throw an exception si pas d'ID:
            if (!is_numeric($id)) {
                throw new Exception("Le panier utilise l'ID du produit.");
            }

            // Ajouter ou maj:
            if (isset($this->m_listeCommandes[$id])) {
                $this->updateItem($p_Item, $p_Quantite);
            } else {
                if (!$this->valideProduitExist($p_Item)) {
                    $this->m_listeCommandes[$id] = array('item' => $p_Item, 'qty' => $p_Quantite);
                }
            }

            //Recalculer les totaux
            $this->updaterTotaux();
        }
        // }
    }

    public function updateItem(Produit $p_Item, $p_Quantite)
    {
        if ($this->valideQte($p_Quantite) == true) {
            // item id:
            $id = $p_Item->getId();

            // maj les valeurs
            if ($p_Quantite == 0) {
                $this->deleteItem($p_Item);
            } elseif (($p_Quantite > 0) && ($p_Quantite != $this->m_listeCommandes[$id]['qty'])) {
                $this->m_listeCommandes[$id]['qty'] = $p_Quantite;
            }
        }
    }

    public function deleteItem(Produit $p_Item)
    {
        $id = $p_Item->getId();

        if (isset($this->m_listeCommandes[$id])) {

            unset($this->m_listeCommandes[$id]);
        }

        //Recalculer les totaux
        //$this->updaterTotaux();
    }

    // public function viderCart()
    // {
    //     foreach ($this->getItems() as $key => $item) {

    //         $this->deleteItem($this->m_listeCommandes[$key]);
    //     }

    //     //Recalculer les totaux
    //     //$this->updaterTotaux();
    // }

    private function valideQte($p_Quantite)
    {
        if (filter_var(
            $p_Quantite,
            FILTER_VALIDATE_INT,
            ["options" => ["min_range" => 0, "max_range" => 10]]
        ) === false) {
            throw new Exception("La quantité est une valeur entre 0 et 10.");
        } else
            return true;
    }

    private function valideProduitExist(Produit $p_Produit): bool
    {
        $estTrouver = false;

        foreach ($this->getItems() as $key => $item) {
            $produit = $item['item'];

            if ($produit->getOeuvre() == $p_Produit->getOeuvre()) {
                $estTrouver = true;
                break;
            }
        }

        return $estTrouver;
    }
}
