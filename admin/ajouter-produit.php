<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    $admin = true;
     include '../includes/_head.php';
      ?>

</head>
<body>
   <?php include '../includes/_navbar.php'; ?>
   <main class="container-lg bg-white py-4">
    <title>Ajouter un produit</title>
    <h1>Ajouter un produit</h1>
    <form action="../core/admin-produit.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>
        <div class="form-groupe">
            <label for="description">Description:</label>
            <textarea name="description" id="description"  rows="5" class="form-control"></textarea>
        </div>
        <div class="form-groupe">
            <label for="prix">Prix:</label>
            <input type="number" name="prix" id="prix" class="form-control" required>

        </div>
        <div class="form-groupe">
            <label for="image">Image:</label>
            <input type="file" name="image" id="image" class="form-control" >
        </div> 
        <input type="hidden" name="action" value="new">
        <button type="submit" class="btn btn-success mt-3 ">Ajouter</button>   

    </form>
   </main>
   <?php include '../includes/_js.php';?>
    
</body>
</html>