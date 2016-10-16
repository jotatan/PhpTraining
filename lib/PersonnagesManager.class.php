<?php

/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 08/09/2016
 * Time: 23:09
 */
class PersonnagesManager
{
    /**
     * @var
     */
    private $_db;

    /**
     * PersonnagesManager constructor.
     * @param $_db
     */
    public function __construct($db)
    {
        $this->setDb($db);
    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->_db;
    }

    /**
     * @param mixed $db
     * @return PersonnagesManager
     */
    public function setDb($db)
    {
        if ($db instanceof PDO)
        {
            $this->_db = $db;
            return $this;
        }
        else
        {
            return false;
        }

    }

    /**
     * @param Personnage $perso
     */
    public function add(Personnage $perso)
    {
        if (!$this->exists($perso->getNom()))
        {
            $query = $this->_db->prepare("INSERT INTO personnages (nom) VALUES (:nom)");
            // Assignation des valeurs pour le nom du personnage.
            $query->bindValue(":nom", $perso->getNom());
            // Exécution de la requête.
            $query->execute();
            // Hydratation du personnage passé en paramètre avec assignation de son identifiant et des dégâts initiaux (= 0).
            $perso->hydrate([
                'id' => $this->_db->lastInsertId(),
                'degats' => 0,
            ]);
            return $perso;
        }
        else
        {
            return false;
        }
    }

    public function count()
    {
        return $this->_db->query('SELECT COUNT(*) FROM personnages')->fetchColumn();
    }

    public function delete(Personnage $perso)
    {
        $this->_db->exec('DELETE FROM personnages WHERE id = '.$perso->id());
    }

    /**
     * On veut voir si tel personnage ayant pour id $info existe.
     * @param $info
     * @return bool
     */
    public function exists($info)
    {
        if (is_int($info))
        {
            return (bool) $this->_db->query('SELECT COUNT(*) FROM personnages WHERE id = '.$info)->fetchColumn();
        }

        // Sinon, c'est qu'on veut vérifier que le nom existe ou pas.

        $q = $this->_db->prepare('SELECT COUNT(*) FROM personnages WHERE LOWER(TRIM(nom)) = LOWER(TRIM(:nom))');
        $q->execute([':nom' => $info]);

        return (bool) $q->fetchColumn();
    }

    public function get($info)
    {
        if (is_int($info))
        {
            $q = $this->_db->query('SELECT id, nom, degats FROM personnages WHERE id = '.$info);
            $donnees = $q->fetch(PDO::FETCH_ASSOC);

            return new Personnage($donnees);
        }
        else
        {
            $q = $this->_db->prepare('SELECT id, nom, degats FROM personnages WHERE nom = :nom');
            $q->execute([':nom' => $info]);

            return new Personnage($q->fetch(PDO::FETCH_ASSOC));
        }
    }

    public function getList($nom)
    {
        $persos = [];

        $q = $this->_db->prepare('SELECT id, nom, degats FROM personnages WHERE nom <> :nom ORDER BY nom');
        $q->execute([':nom' => $nom]);

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $persos[] = new Personnage($donnees);
        }

        return $persos;
    }

    public function update(Personnage $perso)
    {
        $q = $this->_db->prepare('UPDATE personnages SET degats = :degats WHERE id = :id');

        $q->bindValue(':degats', $perso->degats(), PDO::PARAM_INT);
        $q->bindValue(':id', $perso->id(), PDO::PARAM_INT);

        $q->execute();
    }
}