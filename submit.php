<?php
   if(isset($_FILES['fileUpload'])){
      
      //$nomeAnexo = $_POST['nomeAnexo'];

      //date_default_timezone_set("Brazil/East");

      $name     = $_FILES['fileUpload']['name'];
      $tmp_name = $_FILES['fileUpload']['tmp_name'];

     //$allowedExts = array(".pdf", ".jpeg", ".jpg", ".png", ".bmp");
     

      $ext = strtolower(substr($_FILES['fileUpload']['name'],-5)); //Pegando extensão do arquivo
      $new_name = $name . $ext; //Definindo um novo nome para o arquivo
      $dir = 'anexos/'; //Diretório para uploads

      move_uploaded_file($_FILES['fileUpload']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

      
   }
?>