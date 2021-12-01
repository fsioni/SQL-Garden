<div class="p-5 mb-4 gray-200 border rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Statistiques</h1>
        <div class="row">
            <div class="col-sm-6 mt-1">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nombres d'instances par tables des plus importantes</h5>
                        <ul>
                            <li>
                                <p class="card-text">Plantes : <?php echo countInstances($connexion, "Plantes") ?></p>
                            </li>
                            <li>
                                <p class="card-text">Variétés : <?php echo countInstances($connexion, "Variétés") ?></p>
                            </li>
                            <li>
                                <p class="card-text">Plantes Sauvages : <?php echo countInstances($connexion, "PlantesSauvages") ?></p>
                            </li>
                            <li>
                                <p class="card-text">Rangs : <?php echo countInstances($connexion, "Rangs") ?></p>
                            </li>
                            <li>
                                <p class="card-text">Parcelles : <?php echo countInstances($connexion, "Parcelles") ?></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Variétés les plus utilisées (top 3)</h5>
                        <ul>
                            <li>
                                <p class="card-text">Lorem : 232</p>
                            </li>
                            <li>
                                <p class="card-text">Ipsum : 189</p>
                            </li>
                            <li>
                                <p class="card-text">Dolore : 156</p>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lorem, ipsum dolor sit amet</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>