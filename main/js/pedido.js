permissaoNivel();

//SETA O CÓDIGO NO FORMULARIO PARA CADASTRAR
$("#frmCadastroPedido").on('submit', (function (e) {
    e.preventDefault();
    $.ajax({
        url: "../core/save.php",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            $("#salvaPedido").html("<i class='fa fa-spinner fa-spin'></i> Enviando, aguarde...");
            $("#salvaPedido").prop("disabled", true);
        },
        success: function (data) {
            //alert("resultado data " + data);

            if (data == 1) {
                swal({
                    title: "OK!",
                    text: "Cadastrado com Sucesso!",
                    type: "success",
                    confirmButtonText: "Fechar",
                    closeOnConfirm: false
                },
                    function (isConfirm) {
                        if (isConfirm) {
                            $('#modalCadastrarPedido').modal('hide');
                            //location.reload(table);
                            window.location.reload();// = "pedidoCancelado.php";
                        }
                    });
            } else {

                swal({
                    title: "Ops!",
                    text: "Algo deu errado!",
                    type: "error",
                    confirmButtonText: "Fechar",
                    closeOnConfirm: true//false
                },
                    function (isConfirm) {
                        if (isConfirm) {
                            // location.reload(table);
                            $('#modalCadastrarPedido').modal('hide');
                            $('#erro').val(data);
                            $('#modalSuportePedido').modal('show');
                            //  window.location.reload();
                        }
                    });
            }
        }
    });
}));
//SETA O CÓDIGO NO FORMULARIO PARA CADASTRAR

//SETA O CÓDIGO NO MODAL PARA EXCLUIR
$(document).on("click", "#btnExcluiPedido", function () {
    var id = $(this).data('codigoexcluir');
    var nome = $(this).data('nomeexcluir');
    var idInstituicao = $(this).data('idinstituicaoexcluir');
    //alert("id "+id+" nome "+nome+" int. "+idInstituicao);
    $('#excIdPedido').val(id);
    $('#ExcNomePedido').html(nome);
    $('#ExcIdInstituicao').val(idInstituicao);

    $('#modalExluirPedido').modal('show');
});
//SETA O CÓDIGO NO MODAL PARA EXCLUIR

//SETA O CÓDIGO NO FORMULARIO PARA EXCLUIR
$('#frmExcluirPedido').on('submit', (function (e) {
    e.preventDefault();
    $.ajax({
        url: "../core/save.php",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            $("#btnExcluirPedido").html("<i class='fa fa-spinner fa-spin'></i> Enviando, aguarde...");
            $("#btnExcluirPedido").prop("disabled", true);
        },
        success: function (result) {
            //alert(result);
            if (result == 1) {
                swal({
                    title: "OK!",
                    text: "Excluído com Sucesso!",
                    type: "success",
                    confirmButtonText: "Fechar",
                    closeOnConfirm: false
                },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location = "pedido.php";
                        }
                    });
            } else {
                swal({
                    title: "Ops!",
                    text: "Algo deu errado!",
                    type: "error",
                    confirmButtonText: "Fechar",
                    closeOnConfirm: true// false
                },
                    function (isConfirm) {
                        if (isConfirm) {
                            $('#modalExluirPedido').modal('hide');
                            $('#erro').val(result);
                            $('#modalSuportePedido').modal('show');
                            // location.reload(table);
                        }
                    });
            }

        }
    });

}));
//SETA O CÓDIGO NO FORMULARIO PARA EXCLUIR

//SETA O CÓDIGO NO MODAL PARA ATUALIZAR
$(document).on("click", "#btnPedidoAlterar", function () {

    var codigoControle = $(this).data('codigocontrolealterar');
    var statusAlterar = $(this).data('statusalterar');
    var mensagemAlterar = $(this).data('mensagemalterar');
    var dataFechamento = $(this).data('datafechamento');
    var dataAlteracao = $(this).data('dataalteracao');
    var Cliente = $(this).data('idclientealterar');
    var numeroAf = $(this).data('numeroaf');
    var numeroLicitacao = $(this).data('numerolicitacao');
    var valorPedido = $(this).data('valorpedido');
    var anexoAlterar = $(this).data('anexoalterar');
    var idInstituicao = $(this).data('idinstituicaoalterar');

    $('#codigoControleAlterar').val(codigoControle);
    $('#statusPedidoAlterar').val(statusAlterar);
    $('#mensagemPedidoAlterar').val(mensagemAlterar);
    $('#dataAlteracaoPedidoAlterar').val(dataAlteracao);
    $('#dataFechamentoPedidoAlterar').val(dataFechamento);
    $('#idClientePedidoAlterar').val(Cliente);
    $('#numeroAfPedidoAlterar').val(numeroAf);
    $('#numeroLicitacaoPedidoAlterar').val(numeroLicitacao);
    $('#valorPedidoAlterar').val(valorPedido);
    $('#anexoAlterar').val(anexoAlterar);
    $('#idInstituicaoAlterar').val(idInstituicao);
});
//SETA O CÓDIGO NO MODAL PARA ATUALIZAR

//SETA O CÓDIGO NO FORMULARIO PARA ATUALIZAR
$("#frmAlterarPedido").on('submit', (function (e) {
    e.preventDefault();

    $.ajax({
        url: "../core/save.php",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            $("#alteraPedido").html("<i class='fa fa-spinner fa-spin'></i> Enviando, aguarde...");
            $("#alteraPedido").prop("disabled", true);
        },
        success: function (data) {
            // alert(data);

            if (data == 1) {
                swal({
                    title: "OK!",
                    text: "Alterado com Sucesso!",
                    type: "success",
                    confirmButtonText: "Fechar",
                    closeOnConfirm: false
                },
                    function (isConfirm) {
                        if (isConfirm) {
                            $('#modalPedidoAlterar').modal('hide');
                            //location.reload(table);
                            window.location.reload();// = "pedidoCancelado.php";
                        }
                    });
            } else {
                swal({
                    title: "Ops!",
                    text: "Algo deu errado!",
                    type: "error",
                    confirmButtonText: "Fechar",
                    closeOnConfirm: true
                },
                    function (isConfirm) {
                        if (isConfirm) {

                            $('#modalPedidoAlterar').modal('hide');
                            $('#erro').val(data);
                            $('#modalSuportePedido').modal('show');
                            // window.location.reload();// = "pedidoCancelado.php";
                        }
                    });

            }
        }
    });
}));
//SETA O CÓDIGO NO FORMULARIO PARA ATUALIZAR

//ADICIONA MENSAGEM
$('#frmAddMensagem').submit(function () {
    var tipo = "adicionaMensagemPedido";
    var idLogado = $("#idLogado").val();
    var datahora = $("#datahora").val();
    var codPedido = $('#codigoDetalhes').text();
    var mensagem = $("#mensagemComentario").val();
    var idInstituicao = $("#idInstituicaoMensagem").val();

    $.ajax({
        url: '../core/save.php',
        type: "POST",
        data: {
            tipo: tipo,
            idLogado: idLogado,
            datahora: datahora,
            codPedido: codPedido,
            mensagem: mensagem,
            idInstituicao: idInstituicao
        },
        success: function (result) {
            // alert(result);
            if (result == 1) {
                alert("Mensagem adicionada com Sucesso!");
                atualizaMsg();
                $("#mensagemComentario").val('');
                //location.reload();
            } else {
                alert("Erro ao salvar");
            }

        }
    });
    return false; //Evita que a página seja atualizada
});
//ADICIONA MENSAGEM

//FUNÇÃO QUE ATUALIZA AS MENSAGENS NOS DETALHES APÓS SUBMETE-LA -------------------------
function atualizaMsg() {
    var idControle = $("#codigoDetalhes").text();
    var tipo = 'busca_mensagensPedido';
    //MONTA OS COMENTÁRIOS NO MODAL
    $.ajax({
        url: 'busca_mensagens.php',
        type: "POST",
        data: {
            tipo: tipo,
            idControle: idControle
        },
        success: function (data) {
            if (data) {
                $('#comentariosPedido').html(data);
            }
        }
    });
}
//FUNÇÃO QUE ATUALIZA AS MENSAGENS NOS DETALHES APÓS SUBMETE-LA -------------------------      

//SETA O CÓDIGO NO MODALDETALHES
$(document).on("click", "#btnPedidoDetalhes", function () {
    //pegando valor das colunas da tabela e atribuindo as variaveis
    var idControle = $(this).data('codigocontroledet');
    var nomeCliente = $(this).data('nomeclientedet');
    var tipoCliente = $(this).data('tipoclientedet');
    var numeroPregao = $(this).data('numeropregaodet');
    var numeroPedido = $(this).data('numeropedidodet');
    var valorPedido = $(this).data('valorpedidodet');
    var statusControle = $(this).data('statuscontroledet');
    var dataCadastro = $(this).data('datacadastrodet');
    var dataFechamento = $(this).data('datafechamento');
    var dataAlteracao = $(this).data('dataalteracao');
    var mensagem = $(this).data('mensagem');

    var tempoPedido = "";

    if (mensagem == "") {
        mensagem = " Nenhuma Obserção não encontrado ";
    }
    if (tipoCliente == "M") {
        tipoCliente = "Municipal";
    } else if (tipoCliente == "E") {
        tipoCliente = "Estadual";
    } else if (tipoCliente == "F") {
        tipoCliente = "Federal";
    } else if (tipoCliente == "P") {
        tipoCliente = "Particular";
    }
    //pegando valor das variaveis vindo da tabela e atribuindo aos id dos campos do modal para exibir
    $('#codigoDetalhes').html(idControle);
    $('#nomeClienteDetalhes').html(nomeCliente);
    $('#tipoClienteDetalhes').html(tipoCliente);
    $('#licitacaoDetalhes').html(numeroPregao);
    $('#pedidoDetalhes').html(numeroPedido);
    $('#tempoDetalhes').html(tempoPedido);
    $('#valorDetathes').html(valorPedido);
    $('#statusDetalhes').html(statusControle + " - Em: " + dataFechamento);
    $('#dataCriacaoDetalhes').html(dataCadastro + " - Ultima Alteracao Em: " + dataAlteracao);
    $('#mensagemDetatalhes').html(mensagem);

    //MONTA OS COMENTÁRIOS NO MODAL
    var tipo = 'busca_mensagensPedido';
    $.ajax({
        url: 'busca_mensagens.php',
        type: "POST",
        data: {
            idControle: idControle,
            tipo: tipo
        },
        success: function (data) {
            //  alert(idControle);  
            if (idControle) {
                $('#comentariosPedido').html(data);
            }
        }
    });
});
//SETA O CÓDIGO NO MODALDETALHES

//VERIFICA SE DEMANDA TEM ANEXO --------------------------------------------------------------
$(document).on("click", "#btnAnexo", function (e) {
    var link = $(this).attr("href");
    if (link == '../anexos/sem_anexo.php') {
        //alert('Demanda não possui anexo!');
        $('#modalPedidoSemAnexo').modal('show');
        e.preventDefault();
    }

}); //VERIFICA SE DEMANDA TEM ANEXO -

//BUSCA TODOS OS STATUS PARA MUDAR A COR CONFORME
$("tr #statusControle").each(function (i) {
    if ($(this).text() == "RECEPCIONADO" || $(this).text() == "LIBERADO PARCIALMENTE") {
        //$(status).css("color", "red");
        this.style.background = "blue"; //cor do fundo
        this.style.color = "White"; //cor da fonte
    } else if ($(this).text() == "ATENDIDO") {
        this.style.color = "White"; //cor da fonte
        this.style.background = "green"; //cor do fundo
    } else if ($(this).text() == "PENDENTE") {
        this.style.color = "White"; //cor da fonte
        this.style.background = "red"; //cor do fundo
    } else if ($(this).text() == "CANCELADO" || $(this).text() == "NEGADO") {
        //$(status).css("color", "red");
        this.style.color = "White"; //cor da fonte
        this.style.background = "red"; //cor do fundo
    } else {
        this.style.background = "Yellow"; //cor do fundo
        this.style.color = "White";
    }
});

//SETA O CÓDIGO NO FORMULARIO PARA SUPORTE
$("#frmSuportePedido").on('submit', (function (e) {
    e.preventDefault();
    $.ajax({
        url: "../core/save.php",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            $("#btnSuporte").html("<i class='fa fa-spinner fa-spin'></i> Enviando, aguarde...");
            $("#btnSuporte").prop("disabled", true);
        },
        success: function () {
            // alert(" teste  ");
            $('#modalSuportePedido').modal('hide');
            window.location.reload();

        }
    });
}));
//SETA O CÓDIGO NO FORMULARIO PARA SUPORTE