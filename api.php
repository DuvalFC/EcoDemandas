<?php 
include 'bd.php';
$myArray = array();
$myRow = array();

if(isset($_GET['offset'])){
	$offset= $_GET['offset'];
}else{
	$offset=0;
}

if(isset($_GET['limit'])){
	$limit= $_GET['limit'];
}else{
	$limit=1;
}

$myArray['vLimit']= $limit;
$myArray['vOffset'] = $offset;


$query = "SELECT publicacion.id, publicacion.titulo, publicacion.cuerpo, publicacion.fecha_publicacion, publicacion.id_autor,
usuarios.usuario, usuarios.perfil FROM publicacion INNER JOIN usuarios ON publicacion.id_autor = usuarios.id
 ORDER BY id DESC LIMIT ".$limit." OFFSET ".$offset;
$result = $conn->query($query);


while($row=$result->fetch()){
	$myRow[] = array(
		"id"=> $row['id'],
		"id_autor"=> $row['id_autor'],
		"titulo"=> $row['titulo'],
        "fecha_publicacion"=> $row['fecha_publicacion'],
		"usuario"=> $row['usuario'] ,
		"perfil"=> $row['perfil']  
	);
}
$myArray['publicacion']= $myRow;
echo json_encode($myArray);


?>