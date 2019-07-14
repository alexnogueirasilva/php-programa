permissaoNivel();

$("#frmContato").submit(function (e) {
    e.preventDefault();
    //alert("click salvar");
   // var nomeCliente = document.getElementById('nomeCliente').options[document.getElementById('nomeCliente').selectedIndex].innerText;
    //$('#nomeCliente').val(nomeCliente);

    var Operacao = $('#acao').val();
    if (Operacao == 1) {
        Operacao = "Cadastrado ";
    } else if(Operacao == 2){
        Operacao = "Alterado ";
    }else{
        Operacao = "Excluido ";
    }
    $.ajax({ //Função AJAX
        url: "../core/saveContato.php", //Arquivo php
        type: "POST", //Método de envio				
        data: new FormData(this),
        tipo: tipo,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
          // alert("resultado salvar: " + data);
            if (data > 0) {
                swal({
                    title: "OK!",
                    text: Operacao +"com Sucesso! \nCódigo " + data,
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
                    closeOnConfirm: true
                },
                    function (isConfirm) {
                        if (isConfirm) {
                           // window.location = "cad_contato.php";
                            $('#modalContato').modal('hide');
                            $('#erro').val(data);
                            $('#modalSuportePedido').modal('show');
                        }
                    });
            }
        }
    });

});

$(document).on("click", "#btnEditar", function() {
        
    var Codigo = $(this).data('codigo');
    var codCliente = $(this).data('codcliente');
    var Nome     = $(this).data('nome');
    var Celular = $(this).data('celular');
    var Email = $(this).data('email');
    var Telefone = $(this).data('telefone');
    var DadaCadastro = $(this).data('datacadastro');
    var DataAlteracao = $(this).data('dataalteracao');
    var codUsuario = $(this).data('codusuario');
    var nomeUsuario = $(this).data('nomeusuario');
    
    var Acao =2;
     
    $('#codContato').val(Codigo);
    $('#codCliente').val(codCliente);
    $('#nomeContato').val(Nome);
    $('#telefoneContato').val(Telefone);
    $('#celularContato').val(Celular);
    $('#emailContato').val(Email);
    $('#codUsuario').val(codUsuario);
    $('#nomeUsuario').val(nomeUsuario);
    $('#datas').html("Cadastrado em: "+ DadaCadastro + " - Ultima alteração: "+ DataAlteracao +" - Por: "+nomeUsuario);
    $('#acao').val(Acao);
});

$(document).on("click", "#btnExcluir", function() {
    //atribuido valores as variaveis
    var Codigo = $(this).data('codigo');
    var codCliente = $(this).data('codcliente');
    var Nome     = $(this).data('nome');
    var Celular = $(this).data('celular');
    var Email = $(this).data('email');
    var Telefone = $(this).data('telefone');
    var CargoSetor = $(this).data('cargosetor');
    var Acao =3;
    //atribuido valores no id do formularios
    $('#codContato').val(Codigo);
    $('#codCliente').val(codCliente);
    $('#nomeContato').val(Nome);
    $('#telefoneContato').val(Telefone);
    $('#celularContato').val(Celular);
    $('#emailContato').val(Email);
    $('#cargoSetor').val(CargoSetor);
    $('#acao').val(Acao);
    //desabilitando inputs
    $("#codContato").prop("readonly", true);
    $("#codCliente").prop("readonly", true);
    $("#nomeContato").prop("readonly", true);
    $("#telefoneContato").prop("readonly", true);
    $("#celularContato").prop("readonly", true);
    $("#emailContato").prop("readonly", true);
    $("#cargoSetor").prop("readonly", true);
});
function limparCampos() {
    $('#codContato').val('');
    $('#codCliente').val('');
    $('#nomeContato').val('');
    $('#telefoneContato').val('');
    $('#celularContato').val('');
    $('#emailContato').val('');
    $('#cargoSetor').val('');
    $('#datas').text('');
    $('#acao').val(1);
    //habilitando inputs
    $("#codContato").prop("readonly", false);
    $("#codCliente").prop("readonly", false);
    $("#codCliente").prop("disabled", false);
    $("#nomeContato").prop("readonly", false);
    $("#telefoneContato").prop("readonly", false);
    $("#celularContato").prop("readonly", false);
    $("#emailContato").prop("readonly", false);
    $("#cargoSetor").prop("readonly", false);
    $("#btnSalvar").prop("disabled", false);
}
$(document).on("click", "#btnLimpar", function() {
     limparCampos();

});
$(document).on("click", "#btnCancelar", function() {
     limparCampos();
});

$(document).on("click", "#btnCadastrar", function() {
     limparCampos();
    $('#datas').html("Cadastrando em... "+ $('#dataAtual').val());
});

$(document).on("click", "#btnDetalhes", function() {
    //atribuido valores as variaveis
    var Codigo = $(this).data('codigo');
    var codCliente = $(this).data('codcliente');
    var Nome     = $(this).data('nome');
    var Celular = $(this).data('celular');
    var Email = $(this).data('email');
    var Telefone = $(this).data('telefone');
    var CargoSetor = $(this).data('cargosetor');
    var DadaCadastro = $(this).data('datacadastro');
    var DataAlteracao = $(this).data('dataalteracao');
    var codUsuario = $(this).data('codusuario');
    var nomeUsuario = $(this).data('nomeusuario');
    var Acao = 3;
    //atribuido valores no id do formularios
    $('#codContato').val(Codigo);
    $('#codCliente').val(codCliente);
    $('#nomeContato').val(Nome);
    $('#telefoneContato').val(Telefone);
    $('#celularContato').val(Celular);
    $('#emailContato').val(Email);
    $('#cargoSetor').val(CargoSetor);
    $('#codUsuario').val(codUsuario);
    $('#nomeUsuario').val(nomeUsuario);
    $('#datas').html("Cadastrado em: "+ DadaCadastro + " - Ultima alteração: "+ DataAlteracao+" - Por: "+nomeUsuario);
    $('#acao').val(Acao);
    
    //desabilitando inputs
    $("#codContato").prop("readonly", true);
    $("#codCliente").prop("disabled", true);
    $("#nomeContato").prop("readonly", true);
    $("#telefoneContato").prop("readonly", true);
    $("#celularContato").prop("readonly", true);
    $("#emailContato").prop("readonly", true);
    $("#cargoSetor").prop("readonly", true);
    $("#btnSalvar").prop("disabled", true);
});
