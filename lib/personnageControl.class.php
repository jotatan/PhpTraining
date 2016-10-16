<?php

/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 11/10/2016
 * Time: 22:59
 */
class personnageControl
{
    private $post;
    const NOUVEAU_PERSONNAGE = 1;
    const UTILISER_PERSONNAGE = 2;

    /**
     * personnageControl constructor.
     * @param $post
     */
    public function __construct()
    {
        $this->setPost($_POST);
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost(array $post)
    {
        $this->post = $post;
    }

    public function action()
    {
        if (!empty($this->post['choix']))
        {
            if ($this->post['choix'] == NOUVEAU_PERSONNAGE)
            {
                if (!empty($this->post['nom']))
                {
                    $nouveauPersonnage = new Personnage(["nom" => $this->post['nom']]);
                    $pdo = new PDO('mysql:host=localhost;dbname=phptraining', 'root', '');
                    // On émet une alerte à chaque fois qu'une requête a échoué.
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                    $personnageManager = new PersonnagesManager($pdo);
                    $personnageManager->add($nouveauPersonnage);
                }
            }
        }
    }
}