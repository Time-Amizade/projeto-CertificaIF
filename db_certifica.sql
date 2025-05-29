-- Table `db_certifica`.`Curso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Curso` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nomeCurso` VARCHAR(45) NOT NULL,
  `cargaHorariaAtivComplement` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_certifica`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nomeUsuario` VARCHAR(45) NOT NULL,
  `dataNascimento` DATE NOT NULL,
  `cpf` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `telefone` VARCHAR(15) NULL,
  `endereco` VARCHAR(45) NULL,
  `codigoMatricula` INT NULL,
  `funcao` ENUM('ADMINISTRADOR', 'COORDENADOR', 'ALUNO') NOT NULL,
  `horasValidadas` INT NOT NULL,
  `status` ENUM("ATIVO", "INATIVO", "PENDENTE") NOT NULL,
  `Curso_id` INT NOT NULL,
  `fotoPerfil` VARCHAR(150) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_Usuario_Curso`
    FOREIGN KEY (`Curso_id`)
    REFERENCES `db_certifica`.`Curso` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_certifica`.`TipoAtividade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TipoAtividade` (
  `id` INT NOT NULL,
  `nomeAtividade` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_certifica`.`CursoAtividade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CursoAtividade` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cargaHorariaMaxima` INT NOT NULL,
  `equivalencia` VARCHAR(45) NOT NULL,
  `TipoAtividade_id` INT NOT NULL,
  `Curso_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_CursoAtividade_TipoAtividade1`
    FOREIGN KEY (`TipoAtividade_id`)
    REFERENCES `db_certifica`.`TipoAtividade` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CursoAtividade_Curso1`
    FOREIGN KEY (`Curso_id`)
    REFERENCES `db_certifica`.`Curso` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_certifica`.`Comprovante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Comprovante` (
  `id` INT NOT NULL,
  `horas` INT NOT NULL,
  `status` ENUM('PENDENTE', 'APROVADO', 'RECUSADO') NOT NULL,
  `comentario` VARCHAR(45) NULL,
  `arquivo` VARCHAR(45) NOT NULL,
  `Usuario_id` INT NOT NULL,
  `CursoAtividade_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_Comprovante_Usuario1`
    FOREIGN KEY (`Usuario_id`)
    REFERENCES `db_certifica`.`Usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Comprovante_CursoAtividade1`
    FOREIGN KEY (`CursoAtividade_id`)
    REFERENCES `db_certifica`.`CursoAtividade` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



INSERT INTO Usuario (nomeUsuario, cpf, senha, email,telefone,endereco,funcao,status) 
  VALUES ('admin', '000.000.000-00', 'senha123', 'admin@gmail.com','(11) 90000-0000','Rua Exemplo, 123 - Cidade - Estado','ADMINISTRADOR','ATIVO');

