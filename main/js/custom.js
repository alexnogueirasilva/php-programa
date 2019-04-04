function permissaoNivel(){
	//MOSTRA LINK DE CADASTRAR LOGIN CONFORME NIVEL DO USUÁRIO ------------
        var nivel = $('#nivel').val();      
        if (nivel == 2) {
            $('#cadLogin').hide();
        }else{
            $('#cadLogin').show();
        }
        //MOSTRA LINK DE CADASTRAR LOGIN CONFORME NIVEL DO USUÁRIO ------------
    
}