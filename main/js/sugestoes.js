permissaoNivel();
/*		< ?php if ($nivel == 1) { ?>			
			$("#btnSalvar").prop("disabled", false);
		< ?php } ?>*/
    $("#frmSugestao").submit(function(e) {
			e.preventDefault();

			var Sucesso = "";
			if(acao ==1){
				Sucesso = "Cadastro Realizado com Sucesso!";
			}else{
				Sucesso = "Cadastro Alterado com Sucesso!";
			}
			$.ajax({ //Função AJAX
				url: "../core/save.php", //Arquivo php
				type: "POST", //Método de envio				
				data: new FormData(this),
				contentType: false,
			///	tipo: tipo,
				cache: false,
				processData: false,
				success: function(data) {
					//	alert("resultado cadastro sugestao: " +data);				
					if (data > 0) {
						swal({
								title: "OK!",
								text: Sucesso+"\nCódigo " + data,
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									window.location = "sugestao.php";
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
							function(isConfirm) {
								if (isConfirm) {
									window.location = "sugestao.php";
								}
							});
					}
				}
			});

    });
    $(document).on("click", "#btnLimpar", function() {
			limparCampos();
		//	$("#codigoAcesso").prop("disabled", false);
    });
		
    $(document).on("click", "#btnEditar", function() {
			//data-toggle="modal" data-target="#modalEditaUsuario"
			//limparCampos();
			var idSugestao = $(this).data('idsugestao');
			var tipoSugestao = $(this).data('tiposugestao');
			var statusSugestao = $(this).data('statussugestao');
			var descricaoSugestao = $(this).data('descricaosugestao');
			var nomeUsuario = $(this).data('nomesuario');
			var dataCadastro = $(this).data('datacadastro');
			var dataAlteracao = $(this).data('dataalteracao');
			var idInstituicao = $(this).data('instituicao');
			var acao = 2;
			

			/*if (codigo < 0) { 
				$("#btnSalvar").prop("disabled", true);			
			}			
			$("#codigoAcesso").prop("readonly", true);

			< ?php if ($nivel == 1) { ?>
				$("#codigoAcesso").prop("readonly", false);			
			< ?php } ?>*/
			$('#idSugestao').val(idSugestao);
			$('#tipoSugestao').val(tipoSugestao);
			$('#statusSugestao').val(statusSugestao);
			$('#descricaoSugestao').val(descricaoSugestao);
			// $('#nomeUsuario').val(nomeUsuario);
			//$('#dataCadastro').val(dataCadastro);
			//$('#dataAlteracao').val(dataAlteracao);
			$('#idInstituicao').val(idInstituicao);
			$('#acao').val(acao);
			if (acao == 2) { 
			$('#informacao').html("Criado: "+dataCadastro + " - Ultima Alteracao Em: " + dataAlteracao + " Por: " +nomeUsuario);
			}
			

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
		       if ($(this).text() == "Cancelado") {
			this.style.color = "white";
			this.style.background = "red";
		} else if ($(this).text() == "Concluido"){
			this.style.color = "white";
			this.style.background = "green";
		} else if ($(this).text() == " Em Analise"){
			this.style.color = "white";
			this.style.background = "CornflowerBlue";
		} else if ($(this).text() == "Em Desenvolvimento"){
			this.style.color = "white";
			this.style.background = "Orange";
		}else{
			this.style.color = "white";
			this.style.background = "Gold";
        }
    });

$("#frmSugestoes").submit(function (e) {
    e.preventDefault();
    //alert("click salvar");
   // var nomeCliente = document.getElementById('nomeCliente').options[document.getElementById('nomeCliente').selectedIndex].innerText;
    //$('#nomeCliente').val(nomeCliente);

    var Operacao = $('#acao').val();
    if (Operacao == 1) {
        Operacao = "Cadastrado ";
    } else if(Operacao == 2){
        Operacao = "Alterado ";
    }else if(Operacao == 3){
        Operacao = "Excluido ";
    }
    $.ajax({ //Função AJAX
    url: "../core/save.php", //Arquivo php
       // url: "../core/saveContato.php", //Arquivo php
        type: "POST", //Método de envio				
        data: new FormData(this),
        tipo: tipo,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
           //alert("resultado salvar: " + data);
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
                            window.location = "sugestao.php";
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
        $('#titulo').html("Alterando Sugestoes");
        $('#btnSalvar').html("Alterar");
        var botao = document.getElementById('btnSalvar');
        botao.style.backgroundColor = "Gold";
        botao.style.color = "black";

            var idSugestao = $(this).data('idsugestao');
			var tipoSugestao = $(this).data('tiposugestao');
			var statusSugestao = $(this).data('statussugestao');
			var descricaoSugestao = $(this).data('descricaosugestao');
			var nomeUsuario = $(this).data('nomeusuario');
			var dataCadastro = $(this).data('datacadastro');
			var dataAlteracao = $(this).data('dataalteracao');
			var idInstituicao = $(this).data('instituicao');
			var acao = 2;
			
            $('#idSugestao').val(idSugestao);
			$('#tipoSugestao').val(tipoSugestao);
			$('#statusSugestao').val(statusSugestao);
			$('#descricaoSugestao').val(descricaoSugestao);
			// $('#nomeUsuario').val(nomeUsuario);
			//$('#dataCadastro').val(dataCadastro);
			//$('#dataAlteracao').val(dataAlteracao);
			$('#idInstituicao').val(idInstituicao);
			$('#acao').val(acao);
           
			if (acao == 2) { 
			$('#informacao').html("Criado: "+dataCadastro + " - Ultima Alteracao Em: " + dataAlteracao + " Por: " +nomeUsuario);
			}
});

$(document).on("click", "#btnExcluir", function() {
     $('#titulo').html("Excluindo Sugestoes");
     $('#btnSalvar').html("Excluir");
     var botao = document.getElementById('btnSalvar');
         botao.style.backgroundColor = "red";
            
            //atribuido valores as variaveis
            var idSugestao = $(this).data('idsugestao');
			var tipoSugestao = $(this).data('tiposugestao');
			var statusSugestao = $(this).data('statussugestao');
			var descricaoSugestao = $(this).data('descricaosugestao');
			var nomeUsuario = $(this).data('nomeusuario');
			var idUsuario = $(this).data('idusuario');
			var dataCadastro = $(this).data('datacadastro');
			var dataAlteracao = $(this).data('dataalteracao');
			var idInstituicao = $(this).data('instituicao');
            var Acao = 3;	
            
            //atribuido valores no id do formularios
            $('#idSugestao').val(idSugestao);
			$('#tipoSugestao').val(tipoSugestao);
			$('#statusSugestao').val(statusSugestao);
			$('#descricaoSugestao').val(descricaoSugestao);
			$('#idUsuario').val(idUsuario);
			// $('#nomeUsuario').val(nomeUsuario);
			//$('#dataCadastro').val(dataCadastro);
			//$('#dataAlteracao').val(dataAlteracao);
			$('#idInstituicao').val(idInstituicao);
            $('#acao').val(Acao);
    
			$('#informacao').html("Criado: "+dataCadastro + " - Ultima Alteracao Em: " + dataAlteracao + " Por: " +nomeUsuario);
    
    //desabilitando inputs
    desabilitarInputs();
   // $("#btnSalvar").prop("disabled", true);
});

function limparCampos() {
    $('#idSugestao').val('');
    $('#dataCadastro').val('');
    $('#dataAlteracao').val('');
    $('#informacao').text('');            
    $("#statusSugestao").val('');
    $('#tipoSugestao').val('');
    $('#descricaoSugestao').val('');

    $('#acao').val(1);
    //habilitando inputs
   habilitarInputs();
}
function habilitarInputs(){    
    //habilitando inputs
    $("#idSugestao").prop("readonly", false);
    $("#tipoSugestao").prop("disabled", false);
    $("#statusSugestao").prop("disabled", false);
    $("#descricaoSugestao").prop("readonly", false);
    $("#nomeUsuario").prop("readonly", false);
    $("#dataCadastro").prop("readonly", false);
    $("#dataAlteracao").prop("readonly", false);
    $("#btnSalvar").prop("disabled", false);
}
function desabilitarInputs(){
    //desabilitando inputs
    $("#idSugestao").prop("readonly", true);
    $("#tipoSugestao").prop("disabled", true);
    $("#statusSugestao").prop("disabled", true);
    $("#descricaoSugestao").prop("readonly", true);
    $("#nomeUsuario").prop("readonly", true);
    $("#dataCadastro").prop("readonly", true);
    $("#dataAlteracao").prop("readonly", true);
    $("#idInstituicao").prop("readonly", true);
}
$(document).on("click", "#btnLimpar", function() {
     limparCampos();
     $('#btnSalvar').html("Salvar");
     var botao = document.getElementById('btnSalvar');
   botao.style.backgroundColor = "green";

});

$(document).on("click", "#btnCancelar", function() {
     limparCampos();
     habilitarInputs();
});

$(document).on("click", "#btnCadastrar", function() {
     limparCampos();
    $('#titulo').html("Cadastrando Sugestoes");
    $('#datas').html("Cadastrando em... "+ $('#dataAtual').val());
});

$(document).on("click", "#btnDetalhes", function() {
    $('#titulo').html("Detalhe de Sugestoes");
    $('#btnSalvar').html("Excluir");
            var botao = document.getElementById('btnSalvar');
            botao.style.backgroundColor = "red";
            //atribuido valores as variaveis
            var idSugestao = $(this).data('idsugestao');
			var tipoSugestao = $(this).data('tiposugestao');
			var statusSugestao = $(this).data('statussugestao');
			var descricaoSugestao = $(this).data('descricaosugestao');
			var nomeUsuario = $(this).data('nomeusuario');
			var dataCadastro = $(this).data('datacadastro');
			var dataAlteracao = $(this).data('dataalteracao');
			var idInstituicao = $(this).data('instituicao');
            var Acao = 3;				
            //atribuido valores no id do formularios
            $('#idSugestao').val(idSugestao);
			$('#tipoSugestao').val(tipoSugestao);
			$('#statusSugestao').val(statusSugestao);
			$('#descricaoSugestao').val(descricaoSugestao);
			// $('#nomeUsuario').val(nomeUsuario);
			//$('#dataCadastro').val(dataCadastro);
			//$('#dataAlteracao').val(dataAlteracao);
			$('#idInstituicao').val(idInstituicao);
    
			    $('#informacao').html("Criado: "+dataCadastro + " - Ultima Alteracao Em: " + dataAlteracao + " Por: " +nomeUsuario);
    $('#acao').val(Acao);
    
    //desabilitando inputs
      desabilitarInputs();
   // $("#btnSalvar").prop("disabled", true);
});
