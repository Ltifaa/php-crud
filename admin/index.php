<?php
// on démarre la session
session_start();  //a partir de ce moment on a accés à $_session
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    $admin = true;
    include '../includes/_head.php';
    ?>
</head>
<?php include '../includes/_navbar.php'; ?>
<main class="container-lg bg-white py-4">
    <?php
    // on vérifie s'il ya un message à afficher (en session)
    if (isset($_SESSION["message"])) {
        echo '<div class="alert alert-success alert-dismissible fade show">' . $_SESSION["message"] . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        //on supprime le message de la session
        unset($_SESSION["message"]);
    }
    ?>
    <h1> Liste des produits</h1>
    <!--ajouter un Nouveaux boutton-->
    <a href="ajouter-produit.php" class="btn btn-success my-3">Nouveaux produit</a>
    <p>Administrer vos produits</p>
    <table class="table table-striped table-responsive">

        <thead>
            <tr>
                <th>Id</th>
                <th>Image</th>
                <th>nom</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php
            // 1 - connexion a BDD
            require_once '../core/connexion.php';
            //2- ecriture de la requête SQL
            $sql = 'SELECT * FROM product';
            //3- exécution de la requête SQL
            $query = mysqli_query($connexion, $sql);
            //4- recupération des données
            //$products = mysqli_fetch_assoc($query);
            //on passe en revu les produits récupérés dans la base de données a l'aide d'une boucle while
            while ($produit = mysqli_fetch_array($query)) {

            ?>
                <tr>
                    <td><?php echo $produit['id']; ?></td>

                    <td><?php if (isset($produit['image_name'])) {
                            //on affiche l'image
                        ?>
                            <img src="../images/<?php echo $produit['image_name']; ?>" alt="<?php echo $produit['nom']; ?>" class="img-list">
                        <?php
                        }
                        ?>
                    </td>

                    <td><?php echo $produit['nom']; ?></td>
                    <td><?php echo $produit['description']; ?></td>
                    <td><?php echo $produit['prix']; ?></td>

                    <td>
                        <div class="d-flex">
                            <a href="modifier-produit.php?id=<?php echo $produit['id']; ?>" class="btn btn-success me-3">
                            <i class="fa-solid fa-pen"></i></a>
                        <form action="../core/admin-produit.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $produit["id"]; ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                        </div>
                    </td>
                </tr>

            <?php
            }
            ?>


        </tbody>
    </table>
</main>

<body>
    <?php include '../includes/_js.php'; ?>

</body>

</html>