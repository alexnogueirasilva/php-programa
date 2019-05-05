<?php

include_once '../core/crud.php';
$status = $_POST['status'];

$condicao = "=";
if($status == "todas"){
    $queryDemandas = 'SELECT d.id, d.mensagem, d.titulo, d.prioridade, d.ordem_servico, d.data_criacao, d.status, d.anexo, u.nome, d.id_usr_criador, dep.nome AS nome_dep FROM demanda AS d INNER JOIN usuarios AS u ON d.id_usr_criador = u.id INNER JOIN departamentos AS dep ON d.id_dep = dep.id  ORDER BY data_criacao ASC';
}else{
    $queryDemandas = 'SELECT d.id, d.mensagem, d.titulo, d.prioridade, d.ordem_servico, d.data_criacao, d.status, d.anexo, u.nome, d.id_usr_criador, dep.nome AS nome_dep FROM demanda AS d INNER JOIN usuarios AS u ON d.id_usr_criador = u.id INNER JOIN departamentos AS dep ON d.id_dep = dep.id WHERE d.status = "'.$status.'"  ORDER BY data_criacao ASC';

}

//$queryDemandas = crud::dataview("SELECT d.id, d.mensagem, d.titulo, d.prioridade, d.ordem_servico, d.data_criacao, d.status, d.anexo, u.nome, d.id_usr_criador, dep.nome AS nome_dep FROM demanda AS d INNER JOIN usuarios AS u ON d.id_usr_criador = u.id INNER JOIN departamentos AS dep ON d.id_dep = dep.id WHERE d.id = 8 ORDER BY data_criacao ASC");
//$queryDemandas2 = $queryDemandas->fetchAll(PDO::FETCH_ASSOC);


//$queryDemandas = 'SELECT d.id, d.mensagem, d.titulo, d.prioridade, d.ordem_servico, d.data_criacao, d.status, d.anexo, u.nome, d.id_usr_criador, dep.nome AS nome_dep FROM demanda AS d INNER JOIN usuarios AS u ON d.id_usr_criador = u.id INNER JOIN departamentos AS dep ON d.id_dep = dep.id WHERE d.status = "Fechada" ORDER BY data_criacao ASC';
$html = '';
$dados = crud::dataview($queryDemandas);                      
if ($dados->rowCount() > 0) {

     $html .=        '<h3>Todas demandas por status '.$status.'</h3>
                    <table id="tabela" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>OS</th>
                                <th>Departamento</th>
                                <th>Data Criaçao</th>
                                <th> Prioridade</th>                                                               
                                <th>Nome</th>                                                               
                            </tr>
                        </thead>
                        <tbody>';                       
                            while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {
            $html .=   '<tr>                                    
                        <td id="status">'.$row['status'].'</td>
                        <td>'.$row['ordem_servico'].'</td>
                        <td>'.$row['nome_dep'].'</td>
                        <td>'.$row['data_criacao'].'</td>                        
                        <td>'.$row['prioridade'].'</td>
                        <td>'.$row['nome'].'</td>


                        
                        <td><a class="btn btn-primary waves-effect waves-light" id="btnAnexo" target="_blank" href="../anexos/'.$row['anexo'].'">Anexo</a></td>
                         <td><a class="btn btn-success waves-effect waves-light" type="button" id="idDemanda2" data-toggle="modal" data-target="#modalDetDemanda" data-whatever="@getbootstrap" data-codigodet="'.$row['id'].'" data-mensagem="'.$row['mensagem'].'" data-titulodet="'.$row['titulo'].'" data-status="'.$row['status'].'" data-datacriacao="'.$row['data_criacao'].'"  >Detalhes</a></td>

                        </tr>';
                    }
                } else {
                    echo "<p >Sem demandas abertas</p>"; 
                    echo "<a href=index_user.php>Retornar para página inicial</a>";            
                }
                $html .= '<tbody>
                        </table>';
            echo $html;	

?>
