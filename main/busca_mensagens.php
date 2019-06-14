
<?php
include_once '../core/crud.php';


$value = isset($_POST['tipo']) ? $_POST['tipo']   : '';
/*
if($value ==""){
	$comentarios = crud::dataview("SELECT * FROM hst_mensagens WHERE id_mensagem= 3");
		$andre = $comentarios->fetchObject();
	
echo json_encode($andre);

}
*/


switch ($value) {
	case 'busca_mensagensDemanda':
	
$codDemanda = $_POST['id'];


$comentarios = crud::dataview("SELECT hst.mensagem, hst.msg_data, hst.cod_usr_msg, us.nome FROM hst_mensagens as hst INNER JOIN demanda as dem ON hst.cod_demanda = dem.id INNER JOIN usuarios as us ON hst.cod_usr_msg=us.id AND hst.cod_demanda ='".$codDemanda."'");		
$arrayComentarios = $comentarios->fetchAll(PDO::FETCH_ASSOC);
$html = "";


foreach ($arrayComentarios as $comentario){
	$html .= "<tr>
			
			<td>".$comentario['msg_data']." - ".$comentario['nome'].":</td>
			<td><i>".$comentario['mensagem']."</i></td>
		</tr>";
}

echo $html;

break;

case 'busca_mensagensPedido':
	
$codDemanda = $_POST['idControle'];
echo $codDemanda;

$comentarios = crud::dataview("SELECT hst.mensagem, hst.msg_data, hst.cod_usr_msg, us.nome FROM hst_mensagens as hst INNER JOIN controlePedido as con ON hst.cod_demanda = con.codControle INNER JOIN usuarios as us ON hst.cod_usr_msg=us.id AND hst.cod_demanda ='".$codDemanda."'");		
$arrayComentarios = $comentarios->fetchAll(PDO::FETCH_ASSOC);
$html = "";


foreach ($arrayComentarios as $comentario){
	$html .= "<tr>
			
			<td>"." Data: ".$comentario['msg_data']." Usuario: ".$comentario['nome'].":</td>
			<td><i>"." Observacao: ".$comentario['mensagem']."</i></td>
		</tr>";
}

echo $html;

break;

case 'buscarmsg':

	$comentarios = crud::dataview("SELECT * FROM hst_mensagens WHERE id_mensagem= 3");
		$andre = $comentarios->fetchObject();
	
echo json_encode($andre);

break;
	}
?>