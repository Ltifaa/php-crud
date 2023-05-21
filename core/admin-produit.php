<?php
// On démarre la session
session_start(); // A partir de ce moment on a accès à $_SESSION
// On analyse la valeur de la variable action
// pour savoir si on doit ajouter un nouveau produit
// ou si on doit modifier un produit existant
// ou encore si on doit supprimer un produit
switch($_POST["action"]){
    case "new":
        addProduct();
        break;
    case "edit":
        editProduct();
        break;
    case "delete":
        deleteProduct();
        break;
}
// Fonction pour supprimer un produit
function deleteProduct(){
    //1 - Connexion à la BDD
    require_once 'connexion.php';
    // 2 - Ecrire une requête SQL
    $sql = 'SELECT image_name FROM product WHERE id='.$_POST['id'];
    // 3 - Exécution de la requête SQL
    $query = mysqli_query($connexion, $sql);
    // 4 - Récupération des données
    $resultat = mysqli_fetch_array($query);
    // On vérifie si il y a une image dans la base de données
    if(isset($resultat['image_name'])){
        // On supprime l'ancienne image
        unlink('../images/'.$resultat['image_name']);
    }
    // 2 - Ecrire une requête SQL
    $sql = 'DELETE FROM product WHERE id='.$_POST['id'];
    // 3 - Exécution de la requête SQL
    $query = mysqli_query($connexion, $sql);
    $_SESSION['message'] = 'Le produit a bien été supprimé';
    // On redirige l'utilisateur vers la page d'accueil
    header('Location: ../admin/index.php');
}
// Fonction pour modifier un produit
function editProduct(){
    //1 - Connexion à la BDD
    require_once 'connexion.php';
    // 2 - Ecrire une requête SQL
    $nom  = trim(strip_tags(addslashes($_POST['nom'])));
    // On vérifie si l'utilisateur a saisi une description
    if(isset($_POST['description'])){
        $description = trim(strip_tags(addslashes($_POST['description'])));
    } else {
        $description = '';
    }
    $prix = $_POST['prix'];
    // Gestion de l'image
    if(!empty($_FILES['image']['name'])){
        // echo "ici la";
        // die();
        $sql = "SELECT image_name FROM product WHERE id=".$_POST['id'];
        $query = mysqli_query($connexion, $sql);
        $resultat = mysqli_fetch_array($query);
        // On vérifie si il y a une image dans la base de données
        if(isset($resultat['image_name'])){
            // On supprime l'ancienne image
            unlink('../images/'.$resultat['image_name']);
        }
        // On vérifie si le fichier a bien été uploadé
        if($_FILES['image']['error'] == 0){
            // On récupère le nom du fichier uploadé
            $nomFichier = $_FILES['image']['name'];
            // On passe le nom de l'image en minuscule et de supprime les espaces
            $nomFichier = strtolower(str_replace(' ', '-', $nomFichier));
            // On rend unique le nom de l'image avec le timestamp
            $nomFichier = time().'-'.$nomFichier;
            // On déplace le fichier du dossier temporaire (du serveur) vers le dossier images
            move_uploaded_file($_FILES['image']['tmp_name'], '../images/'.$nomFichier);
        }
        $sql = 'UPDATE product SET nom="'.$nom.'", description="'.$description.'", prix='.$prix.', image_name="'.$nomFichier.'" WHERE id='.$_POST['id'];
    }else{
        // On écrit une requête sans prendre en compte l'image
        $sql = 'UPDATE product SET nom="'.$nom.'", description="'.$description.'", prix='.$prix.' WHERE id='.$_POST['id'];
    }
   
    //
    // 3 - Exécuter la requête SQL
    mysqli_query($connexion, $sql);
    $_SESSION['message'] = 'Le produit a bien été modifié';
    // header('Location: ../admin/index.php');
}
// Fonction pour ajouter un produit
function addProduct(){
    // 1 - Connexion à la BDD
    require_once 'connexion.php';
    // 2 - Ecrire une requête SQL
    $nom  = trim(strip_tags(addslashes($_POST['nom'])));
    // On vérifie si l'utilisateur a saisi une description
    if(isset($_POST['description'])){
        $description = trim(strip_tags(addslashes($_POST['description'])));
    } else {
        $description = '';
    }
    $prix = $_POST['prix'];
    // Prise en charge du fichier image
    // On vérifie si l'utilisateur a bien sélectionné un fichier
    if(!empty($_FILES['image']['name'])){
        // On vérifie si le fichier a bien été uploadé
        if($_FILES['image']['error'] == 0){
            // On récupère le nom du fichier uploadé
            $nomFichier = $_FILES['image']['name'];
            // On passe le nom de l'image en minuscule et de supprime les espaces
            $nomFichier = strtolower(str_replace(' ', '-', $nomFichier));
            // On rend unique le nom de l'image avec le timestamp
            $nomFichier = time().'-'.$nomFichier;
            // On déplace le fichier du dossier temporaire (du serveur) vers le dossier images
            move_uploaded_file($_FILES['image']['tmp_name'], '../images/'.$nomFichier);
        }
    }else{
        $nomFichier = '';
    }
    $sql = 'INSERT INTO product (nom, description, prix, image_name) VALUES ("'.$nom.'", "'.$description.'", '.$prix.', "'.$nomFichier.'")';
    //echo $sql;
    // 3 - Exécuter la requête SQL
    mysqli_query($connexion, $sql);
    // 4 - Mise en session d'un message de succès et redirection de l'utilisateur
    $_SESSION['message'] = 'Le produit a bien été ajouté';
    header('Location:../admin/index.php');
}

