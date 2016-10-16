<?php

/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 21/08/2016
 * Time: 21:44
 */
class Personnage
{
    private $id;
    private $nom="";
    private $degats=0;

    const CEST_MOI = 1; // Constante renvoyée par la méthode `frapper` si on se frappe soi-même.
    const PERSONNAGE_TUE = 2; // Constante renvoyée par la méthode `frapper` si on a tué le personnage en le frappant.
    const PERSONNAGE_FRAPPE = 3; // Constante renvoyée par la méthode `frapper` si on a bien frappé le personnage.
    /**
     * Personnage constructor.
     */
    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Personnage
     */
    public function setId($id)
    {
        if(is_integer($id))
        {
            $this->id = $id;
            return $this;
        }
        else{
            return false;
        }
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return Personnage
     */
    public function setNom($nom)
    {
        if(is_string($nom))
        {
            $this->nom = $nom;
            return $this;
        }
        else
        {
            return false;
        }
    }

    /**
     * @return int
     */
    public function getDegats()
    {
        return $this->degats;
    }

    /**
     * @param int $degats
     * @return Personnage
     */
    public function setDegats($degats)
    {
        if(0 < $degats && $degats < 100)
        {
            $this->degats = $degats;
            return $this;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param Personnage $personnage
     * @return string
     */
    public function frapper(Personnage $personnage)
    {
        if($this->getId() <> $personnage->getId())
        {
            $personnage->setDegats($personnage->getDegats() + 5);
        }
        else
        {
            return "Vous ne pouvez pas vous frapper à vous même. Action annulée";
        }
    }

    /**
     * @param array $donnees
     */
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $cle => $valeur)
        {
            $methode = "set".ucfirst($cle);
            if(method_exists($this, $methode))
            {
                $this->$methode($valeur);
            }
            else
            {
                echo "La méthode '".$methode."' n'existe pas.";
            }
        }
    }
}