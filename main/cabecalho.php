<?php
include_once 'vrf_lgin.php';
$logado = $_SESSION['nomeUsuario'];
$instituicao = $_SESSION['instituicaoUsuario'];
$nomeInstituicao = $_SESSION['instituicaoNome'];
$nivel = $_SESSION['nivel'];
$idAndre = $_SESSION['usuarioID'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/logo2.png">
    <title>SD - Sistema de Ocorrências</title>
    <link href="css/AdminLTE.css" rel="stylesheet">
    <!-- Bootstrap Core CSS -->
    <link href="../assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap-toggle -->
    <!--link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet"-->
    <link href="css/bootstrap2-toggle.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="../css/bootstrap4-toggle.css">	-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!--script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script-->
    <!--script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script-->
    <script src="js/bootstrap2-toggle.min.js"></script>
    <!-- Fim - Bootstrap-toggle -->
    <!-- Menu CSS -->
    <link href="../assets/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="../assets/bower_components/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="../assets/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <link href="../assets/bower_components/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
    <link href="../assets/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

    <script src="../assets/bower_components/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript" src="js/loader.js"></script>
    <script type="text/javascript" src="js/custom.js"></script>
    <script type="text/javascript" src="js/toggle.js"></script>

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/stylenew.css" rel="stylesheet">
    <!--  ATUALIZA A PÁGINA A CADA 5 MINUTOS -->
    <!--  <meta http-equiv="refresh" content="300"> -->

</head>

<body>

    <div id="wrapper">
        <input id="nivel" type="hidden" name="" value="<?php echo $nivel; ?>">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <div class="top-left-part">
                    <a class="logo" href="index_user.php"><b><img src="../assets/images/logo2.png" alt="Home"></b><span class="hidden-xs"><img src="../assets/images/logo-topo2.png" alt="Home"></span>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-left">

                    <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                    <!-- <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><i class="icon-envelope"></i> <span class="badge badge-xs badge-warning">4</span></a>
                        <ul class="dropdown-menu nicescroll mailbox">
                            <li>
                                <div class="drop-title">Você tem 4 demandas abertas</div>
                            </li>                            
                        </ul>                       
                    </li>  -->

                </ul>


                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>

                        <a><i class="fa fa-user"></i> Você está logado como </a>

                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="../assets/images/users/avatar2.png" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?php echo $idAndre . " - " . $logado . " - " . $nomeInstituicao; ?> </b> </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="ti-email"></i> Mensagens</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="logout.php"><i class="fa fa-power-off"></i> Sair</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
            </div>

        </nav>

        <div class="navbar-default sidebar nicescroll" role="navigation">
            <div class="sidebar-nav navbar-collapse ">
                <ul class="nav" id="side-menu">

                    <li class="nav-small-cap">Menu Principal</li>
                    <li> <a href="index_user.php" class="waves-effect"><i class="icon-speedometer fa-fw"></i> Início</a>
                    </li>
                    <li> <a href="#" id="menuMinhasDemandas" class="waves-effect"><i class="icon-star fa-fw"></i> Demandas criadas<span class="fa arrow"></span> </a>
                        <ul class="nav nav-second-level">
                            <li><a href="minhas_dem_abertas.php" class="hideMenu">Abertas</a></li>
                            <li><a href="minhas_dem_fechadas.php">Fechadas</a></li>

                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li> <a href="#" class="waves-effect"><i class="icon-envelope fa-fw"></i> Demandas para mim<span class="fa arrow"></span> </a>
                        <ul class="nav nav-second-level">
                            <li><a href="para_mim_dem_abertas.php">Abertas</a></li>
                            <li><a href="para_mim_dem_fechadas.php">Fechadas</a></li>

                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li id="cadLogin"> <a href="#" class="waves-effect"><i class="icon-graph fa-fw"></i> Gerência<span class="fa arrow"></span> </a>
                        <ul class="nav nav-second-level">
                           
                            <li><a href="cad_user.php">Cadastros Usuários</a></li>
                            <li><a href="cad_cliente.php">Cadastros Clientes</a></li>
                            <li><a href="cad_dep.php">Cadastros Departamentos</a></li>
                            <li><a href="cad_sla.php">Cadastros SLAs</a></li>
                            <li><a href="cad_representante.php">Cadastros Representante</a></li>                              
                            <li><a href="pedido.php">Cadastros Pedidos  </a></li>
                            <li><a href="cad_status.php">Cadastros Status  </a></li>
                            <li><a href="lista_todas.php">Listar Todas Demandas</a></li>
                            <li><a href="relatorios.php">Relatórios</a></li>

                        </ul>
                        <!-- /.nav-second-level -->
                    </li>                 
                        <li id="Desenvolvimento"> <a href="#" class="waves-effect"><i class="icon-graph fa-fw"></i> Em Desenvolvimento<span class="fa arrow"></span> </a>
                        <?php if ($nivel == 1) { ?>
                            <ul class="nav nav-second-level">
                                <li><a href="andre.php">Dashboard</a></li>
                                <li><a href="cadastro.php">Cadastros Usuários</a></li>  
                                <li><a href="e-mail.php">E-mail</a></li>
                                <li><a href="valida_cadastro.php">Validação de Cadastros</a></li>
                                <li><a href="teste_dem_fechada.php">Demandas fechadas</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    <?php }  ?>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- Page Content -->
        <div id="page-wrapper">