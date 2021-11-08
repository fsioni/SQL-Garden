<?php
// SIONI Farès - p1907037
// MOKADEM Aziz
//scp -r bdw1-projet p1907037@bdw1.univ-lyon1.fr:/var/www/p1907037/

$controller = 'controllerAccueil'; // contrôleur par défaut
$view = 'viewAccueil'; // vue par défaut

require_once('includes/routes.php');

if (isset($_GET['page'])) {
    $nomPage = $_GET['page'];
    if (isset($routes[$nomPage])) {
        $controller = $routes[$nomPage]['controller'];
        $view = $routes[$nomPage]['view'];
    }
}
include('controllers/' . $controller . '.php');

require_once 'statics/header.php';
require_once 'statics/nav.php';

echo '<div id="contentContainer">';
include('views/' . $view . '.php');
echo '</div>';

require_once 'statics/stats.php';
require_once 'statics/footer.php';
