-- Table `db_certifica`.`Curso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Curso` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nomeCurso` VARCHAR(255) NOT NULL,
  `cargaHorariaAtivComplement` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_certifica`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nomeUsuario` VARCHAR(45) NOT NULL,
  `dataNascimento` DATE NULL,
  `cpf` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `telefone` VARCHAR(15) NULL,
  `endereco` VARCHAR(45) NULL,
  `codigoMatricula` VARCHAR(11) NULL,
  `funcao` ENUM('ADMINISTRADOR', 'COORDENADOR', 'ALUNO') NOT NULL,
  `horasValidadas` INT DEFAULT '0',
  `status` ENUM("ATIVO", "INATIVO", "PENDENTE") NOT NULL,
  `Curso_id` INT NULL,
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
  `id` INT NOT NULL AUTO_INCREMENT,
  `nomeAtividade` VARCHAR(255) NOT NULL,
  `descricao` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_certifica`.`CursoAtividade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CursoAtividade` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cargaHorariaMaxima` INT NOT NULL,
  `codigoAtividade` INT NOT NULL,
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
  `id` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(150) NOT NULL, 
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
  VALUES ('admin', '000.000.000-00', '$2y$10$sJttVOC6tNnvOyGt2ctEOeIAwD6wrFXDhDqTWcD6Yn/KiMKJ1rhqq', 'admin@gmail.com','(11) 90000-0000','Rua Exemplo, 123 - Cidade - Estado','ADMINISTRADOR','ATIVO');

INSERT INTO TipoAtividade (nomeAtividade, descricao) VALUES
('Participação em curso de natureza acadêmica ou profissional', 
 'Participação em cursos, oficinas, minicursos ou capacitações na área de informação e comunicação.'),

('Atuação como ministrante de curso, palestra ou oficina', 
 'Ministrante em cursos, palestras ou oficinas.'),

('Atividade de monitoria em atividades acadêmicas ou disciplinas', 
 'Monitoria em atividades acadêmicas ou disciplinas do Ensino Médio na área do curso.'),

('Participação em iniciação científica ou programas institucionais', 
 'Participação em programas de iniciação científica ou outros programas homologados pelo COPE.'),

('Publicação de artigo científico completo', 
 'Publicação de artigo completo em canais de evento como autor ou coautor.'),

('Publicação de resumo em evento científico', 
 'Publicação de resumo em canais de evento como autor ou coautor.'),

('Exercício de atividade profissional na área de informática', 
 'Atividade profissional na área de informática.'),

('Estágio curricular não obrigatório', 
 'Estágio não obrigatório realizado no curso, com comprovação formal.'),

('Participação em eventos acadêmicos ou profissionais', 
 'Participação em congressos, seminários, simpósios, workshops e outros eventos acadêmicos ou profissionais.'),

('Serviço voluntário de caráter sociocomunitário', 
 'Serviço voluntário sociocomunitário em entidades públicas ou privadas sem fins lucrativos.'),

('Apresentação de trabalho em evento', 
 'Apresentação de trabalho (inclusive pôster) em evento local, regional, nacional ou internacional.'),

('Participação em reuniões de colegiado de curso', 
 'Participação em reuniões de colegiado de curso como representante discente, com ata como comprovação.'),

('Participação em equipe esportiva do IFPR', 
 'Participação em equipe esportiva do IFPR.'),

('Participação em comissão organizadora de evento', 
 'Participação em comissão organizadora de evento.'),

('Certificação profissional na área do Curso', 
 'Certificação profissional relacionada ao curso realizado.'),

('Viagem de estudo e visita técnica', 
 'Viagem de estudo ou visita técnica, com declaração do organizador ou coordenador de curso.'),

('Realização de curso de idioma', 
 'Realização de curso de idioma.');
