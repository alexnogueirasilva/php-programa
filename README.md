# php-programa

### Programa para controle de demanda de cleintes

### commit teste 


###### tabela de sugestoes - inicio ########

nome: sugestoes

colunas: sug_id, sug_tipo, sug_descricao, sug_datacadastro, sug_dataalteracao, sug_usuario, sug_status


CREATE TABLE `sugestoes` (
  `sug_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sug_tipo` varchar(30) NOT NULL,
  `sug_descricao` varchar(300) NOT NULL,
  `sug_status` varchar(30) NOT NULL,
  `sug_usuario` int(11) DEFAULT NULL,
  `sug_idInstituicao` varchar(30) DEFAULT NULL,
  `sug_datacadastro` datetime DEFAULT CURRENT_TIMESTAMP,
  `sug_dataalteracao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sug_id`),
  KEY `FK_USUARIO_SUGESTAO` (`sug_usuario`),
  CONSTRAINT `FK_USUARIO_SUGESTAO` FOREIGN KEY (`sug_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

###### tabela de sugestoes - final ########