<h1>Générer une parcelle</h1>
<br />

<h4>Nombre de rangs</h4>

<form method="post" action="#">
    <div class="form-group">
        <label for="minR">Nombre de rangs minimum</label>
        <input type="number" name="minR" min="1" max="2000" step="1" value="5" class="form-control" required>
    </div>
    <br />

    <div class="form-group">
        <label for="minR">Nombre de rangs maximum</label>
        <input type="number" name="minR" min="1" max="2000" step="1" value="10" class="form-control" required>
    </div>
    <br />

    <h4>Pourcentage d'occupation</h4>

    <div class="form-group">
        <label for="minR">Pourcentage des rangs occupés par des cultures</label>
        <input type="number" name="minR" min="1" max="100" step="1" value="50" class="form-control" required>
    </div>
    <br />

    <div class="form-group">
        <label for="minR">Pourcentage des rangs occupés par des nuisibles</label>
        <input type="number" name="minR" min="1" max="100" step="1" value="10" class="form-control" required>
    </div>

    <br /><br />
    <button type="submit" name="boutonValider" value="Ajouter" class="btn btn-primary">Soumettre</button>
</form>