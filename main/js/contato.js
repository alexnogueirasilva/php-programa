permissaoNivel();

$("#frmContato").submit(function (e) {
    e.preventDefault();
    alert("click salvar");
   // var nomeCliente = document.getElementById('nomeCliente').options[document.getElementById('nomeCliente').selectedIndex].innerText;
    //$('#nomeCliente').val(nomeCliente);
    $.ajax({ //Função AJAX
        url: "../core/saveContato.php", //Arquivo php
        type: "POST", //Método de envio				
        data: new FormData(this),
        tipo: tipo,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            alert("resultado salvar: " + data);
            if (data > 0) {
                swal({
                    title: "OK!",
                    text: " Cadastrado com Sucesso! \nCódigo " + data,
                    type: "success",
                    confirmButtonText: "Fechar",
                    closeOnConfirm: false
                },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location = "cad_contato.php";
                        }
                    });
            } else {
                swal({
                    title: "Ops!",
                    text: "Algo deu errado!",
                    type: "error",
                    confirmButtonText: "Fechar",
                    closeOnConfirm: false
                },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location = "cad_contato.php";
                        }
                    });
            }
        }
    });

});
        /*
$(document).on("click", "#btnLimpar", function() {
    limparCampos();
    $("#codigoAcesso").prop("disabled", false);
});
$(document).on("click", "#btnEditar", function() {
    //limparCampos();
    var codigo = $(this).data('codigo');
    var nome = $(this).data('nome');
    var nomeFantasia = $(this).data('nomefantasia');
    var codigoAcesso = $(this).data('codigoacesso');
    var acao = 2;

    $('#idInstituicao').val(codigo);
    $('#codigoAcesso').val(codigoAcesso);
    $('#nomeInstituicao').val(nome);
    $('#nomeFantasia').val(nomeFantasia);
    $('#acao').val(acao);
    $('#modalPesquisarAndre').modal('hide');

});

$('#btnBuscar').click(function() {
    var valorPesquisar = $("#valorPesquisa").val();
    var tipo = "pesquisar";
    $.ajax({
        url: 'buscar.php',
        type: "POST",
        data: {
            tipo: tipo,
            valorPesquisar: valorPesquisar
        },
        success: function(data) {
            //		alert(data);
            if (data) {
                $('#tabela2').html(data);
            } else {
                alert("nenhum dados encontrado para pesquisa com ");
            }
        }
    });

    return false;
});

function limparCampos() {
    $("#codigoAcesso").val('');
    $("#idInstituicao").val('');
    $("#nomeInstituicao").val('');
    $('#nomeFantasia').val('');
    $('#nome').val('');
}
$(document).on("click", "#btnAtiva", function() {
    var id = $(this).data('codigo');
    var status = $(this).data('statusatual');
    var nome = $(this).data('nome');
    if (status == "A") {
        alert("Cliente já está Ativo!");
    } else {
        $('#modalConfirmacaoAtiva').modal('show');
    }
    $('#codigoClienteAt').val(id);
    $('#statusAtualAt').val(status);
    $('#nomeClienteAt').html(nome);


});

$(document).on("click", "#btnDesativa", function() {
    var id = $(this).data('codigo');
    var status = $(this).data('statusatual');
    var nome = $(this).data('nome');

    if (status == "D") {
        alert("Cliente já está Desativado!");
    } else {
        $('#modalConfirmacaoDesativa').modal('show');
    }
    $('#codigoClienteDes').val(id);
    $('#statusAtualDes').val(status);
    $('#nomeClienteDes').html(nome);

});

$(document).on("click", "#btnExcluir", function() {
    var codigo = $(this).data('codigo');
    var nome = $(this).data('nome');

    $('#excidInstituicao').val(codigo);
    $('#excnomeInstituicao').html(nome);
    $('#modalPesquisarAndre').modal('hide');
    $('#modalExcluir').modal('show');
});

$('#btnConfirmar').click(function() {
    var idInstituicao = $("#excidInstituicao").val();
    var tipo = "excluirInstituicao";
    $.ajax({
        url: '../core/save.php',
        type: "POST",
        data: {
            tipo: tipo,
            idInstituicao: idInstituicao
        },
        success: function(result) {
            //	alert(result);
            if (result == 1) {
                swal({
                        title: "OK!",
                        text: "Cadastro Excluído com Sucesso!",
                        type: "success",
                        confirmButtonText: "Fechar",
                        closeOnConfirm: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            window.location = "cad_instituicao.php";
                        }
                    });
            } else {
                swal({
                        title: "Ops!",
                        text: "Algo deu errado ao excluir! ",
                        type: "error",
                        confirmButtonText: "Fechar",
                        closeOnConfirm: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            window.location = "cad_instituicao.php";
                        }
                    });
            }
        }
    });
});

$('#btnDesativaCliente').click(function() {
    var tipo = "desativaCliente";
    var id = $('#codigoClienteDes').val();
    var status = $('#statusAtualDes').val();
    var idInstituicao = $("#idInstituicaoDes").val();
    $.ajax({
        url: '../core/save.php',
        type: "POST",
        data: {
            tipo: tipo,
            id: id,
            idInstituicao: idInstituicao
        },
        success: function(result) {
            if (result == 1) {
                swal({
                        title: "OK!",
                        text: "Clinte desativado com Sucesso!",
                        type: "success",
                        confirmButtonText: "Fechar",
                        closeOnConfirm: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            //	$('#modalConfirmacaoDesativa').modal('hide');
                            window.location = "cad_cliente.php";
                        }
                    });
            } else {
                swal({
                        title: "Ops!",
                        text: "Algo deu errado ao desativar o cliente!",
                        type: "error",
                        confirmButtonText: "Fechar",
                        closeOnConfirm: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            window.location = "cad_cliente.php";
                        }
                    });
                //	alert(result);
                //alert("Erro ao salvar");
            }
        }
    });
});

$('#btnAtivaCliente').click(function() {
    var tipo = "ativaCliente";
    var id = $('#codigoClienteAt').val();
    var status = $('#statusAtualAt').val();
    var idInstituicao = $("#idInstituicaoAt").val();
    $.ajax({
        url: '../core/save.php',
        type: "POST",
        data: {
            tipo: tipo,
            id: id,
            idInstituicao: idInstituicao
        },
        success: function(result) {
            if (result == 1) {
                swal({
                        title: "OK!",
                        text: "Clinte ativado com Sucesso!",
                        type: "success",
                        confirmButtonText: "Fechar",
                        closeOnConfirm: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            //	$('#modalConfirmacaoDesativa').modal('hide');
                            window.location = "cad_cliente.php";
                        }
                    });
            } else {
                swal({
                        title: "Ops!",
                        text: "Algo deu errado ao ativar o cliente!",
                        type: "error",
                        confirmButtonText: "Fechar",
                        closeOnConfirm: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            window.location = "cad_cliente.php";
                        }
                    });
                //	alert(result);
                //alert("Erro ao salvar");
            }

        }
    });

});

$('#edtcliente').submit(function() {
    $.ajax({ //Função AJAX
        url: "../core/save.php",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(result) {
            if (result == 1) {
                swal({
                        title: "OK!",
                        text: "Cliente editado com Sucesso!",
                        type: "success",
                        confirmButtonText: "Fechar",
                        closeOnConfirm: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            window.location = "cad_instituicao.php";
                        }
                    });
            } else {
                swal({
                        title: "Ops!",
                        text: "Algo deu errado ao editar cliente!",
                        type: "error",
                        confirmButtonText: "Fechar",
                        closeOnConfirm: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            window.location = "cad_instituicao.php";
                        }
                    });
            }
        }
    });
    return false; //Evita que a página seja atualizada
});


$("#tbl-user").DataTable({
    //TRADUÇÃO DATATABLE
    "oLanguage": {
        "sProcessing": "Processando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "Não foram encontrados resultados",
        "sInfo": "",
        "sInfoEmpty": "",
        "sInfoFiltered": "",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "oPaginate": {
            "sFirst": "Primeiro",
            "sPrevious": "Anterior",
            "sNext": "Seguinte",
            "sLast": "Último"
        }
    }
});

//BUSCA TODOS OS STATUS PARA MUDAR A COR CONFORME
$("tr #status").each(function(i) {
if ($(this).text() == "D") {
    this.style.color = "white";
    this.style.background = "red";
} else {
    this.style.color = "white";
    this.style.background = "green";
}
});
*/