CREATE TABLE usuarios ( 
  id_usuario int AUTO_INCREMENT, 
  nome_usuario varchar(70) NOT NULL, 
  login varchar(15) NOT NULL,
  senha varchar(255) NOT NULL,
  papel varchar(255),
  PRIMARY KEY (id_usuario) 
);
ALTER TABLE usuarios ADD CONSTRAINT uk_usuarios UNIQUE KEY (login);

/*Inserts usuarios*/
/* admin - admin */
INSERT INTO usuarios (nome_usuario, login, senha, papel) VALUES ('Sr. Administrador', 'admin', 
                '$2y$10$PrnFrYArQJto/SlnMTFTpOSDKU9XS5PfeHHUvJlzMxeJH5KdnI/Sm', 'ADMINISTRADOR');
/* root - root */
INSERT INTO usuarios (nome_usuario, login, senha, papel) VALUES ('Sr. Root', 'root', 
                '$2y$10$9H8nNzW7tM7cGhy6r59gYuKuflEGKzKGOMPv86yUhJbySUNnnY42y', 'ADMINISTRADOR');