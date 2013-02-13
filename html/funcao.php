$geturl = explode('/', $_SERVER['REQUEST_URI']);
$empresa = $geturl[count($geturl) - 1];
include reclamacoes.php;