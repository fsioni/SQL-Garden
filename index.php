<?php
// SIONI Farès - p1907037
// MOKADEM Aziz - p1804157
//scp -r bdw1-projet p1907037@bdw1.univ-lyon1.fr:/var/www/p1907037/

require_once 'statics/header.php';
require_once 'statics/nav.php';

echo '<div id="contentContainer">';
include('views/' . $view . '.php');
echo '</div>';

require_once 'statics/stats.php';
require_once 'statics/footer.php';
