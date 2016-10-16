<?php
    session_start();
    include_once "classLoader.php";
    classLoader::init();
    $pdo = new PDO('mysql:host=localhost;dbname=phptraining', 'root', '');
    $personnageManager = new PersonnagesManager($pdo);
    if (!empty($_POST['nom']))
    {
        $nouveauPersonnage = new Personnage(["nom" => $_POST['nom']]);
        $personnageManager->add($nouveauPersonnage);
    }
?>
<!DOCTYPE html>
    <html>
        <head>
            <title>TP : Mini jeu de combat</title>
            <meta charset="utf-8" />
        </head>
        <body>
            <form action="" method="post">
                <table>
                    <tr>
                        <td colspan="2">
                            <select name="choix">
                                <option value="1">Créer ce personnage</option>
                                <option value="2">Utiliser ce personnage</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Nom:</label>
                            <input type="text" name="nom">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="creer">
                        </td>
                    </tr>
                </table>
            </form>
        </body>
    </html>