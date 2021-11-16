<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
    <a class="navbar-brand" href="#" style="margin-left: 1%;"><?php echo $siteName ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Ajouter une variété</a>
            </li>
	    <li class="nav-item">
                <a class="nav-link" href="models/scriptCleanse.php">Nettoyer BDD</a>
            </li>
	    <li class="nav-item">
                <a class="nav-link" href="models/scriptSetDatabase.php">Générer Structure BDD</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="models/scriptFillDataset.php">Integrer les données</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Générer et afficher une parcelle</a>
            </li>
        </ul>
    </div>
</nav>
