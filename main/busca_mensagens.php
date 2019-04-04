
<?php
include_once '../core/crud.php';

$codDemanda = $_POST['id'];

		$comentarios = crud::dataview("SELECT hst.mensagem, hst.msg_data, hst.cod_usr_msg, us.nome FROM hst_mensagens as hst INNER JOIN demanda as dem ON hst.cod_demanda = dem.id INNER JOIN usuarios as us ON hst.cod_usr_msg=us.id AND hst.cod_demanda =".$codDemanda);
		$arrayComentarios = $comentarios->fetchAll(PDO::FETCH_ASSOC);
		$html = "";
		

		foreach ($arrayComentarios as $comentario){
			$html .= "<tr>
					
					<td>".$comentario['msg_data']." - ".$comentario['nome'].":</td>
					<td><i>".$comentario['mensagem']."</i></td>
				</tr>";
		}


echo $html;
?>