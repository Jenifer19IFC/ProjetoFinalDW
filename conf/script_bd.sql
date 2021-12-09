- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema orcamento
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema orcamento
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `orcamento` DEFAULT CHARACTER SET utf8 ;
USE `orcamento` ;

-- -----------------------------------------------------
-- Table `orcamento`.`conta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `orcamento`.`conta` (
  `conta_id` INT(11) NOT NULL AUTO_INCREMENT,
  `saldo` DOUBLE NULL DEFAULT NULL,
  PRIMARY KEY (`conta_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `orcamento`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `orcamento`.`usuario` (
  `usuario_id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL DEFAULT NULL,
  `cpf` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`usuario_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 45
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `orcamento`.`conta_has_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `orcamento`.`conta_has_usuario` (
  `conta_conta_id` INT(11) NOT NULL,
  `usuario_usuario_id` INT(11) NOT NULL,
  PRIMARY KEY (`conta_conta_id`, `usuario_usuario_id`),
  INDEX `fk_conta_has_usuario_usuario1_idx` (`usuario_usuario_id` ASC),
  INDEX `fk_conta_has_usuario_conta1_idx` (`conta_conta_id` ASC),
  CONSTRAINT `fk_conta_has_usuario_conta1`
    FOREIGN KEY (`conta_conta_id`)
    REFERENCES `orcamento`.`conta` (`conta_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_conta_has_usuario_usuario1`
    FOREIGN KEY (`usuario_usuario_id`)
    REFERENCES `orcamento`.`usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `orcamento`.`tdespesa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `orcamento`.`tdespesa` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `categoria` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 21
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `orcamento`.`despesa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `orcamento`.`despesa` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `valor` DOUBLE NULL DEFAULT NULL,
  `data` DATE NULL DEFAULT NULL,
  `conta_conta_id` INT(11) NOT NULL,
  `tipo_despesa_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_despesa_conta1_idx` (`conta_conta_id` ASC),
  INDEX `fk_despesa_tipo_despesa1_idx` (`tipo_despesa_id` ASC),
  CONSTRAINT `fk_despesa_conta1`
    FOREIGN KEY (`conta_conta_id`)
    REFERENCES `orcamento`.`conta` (`conta_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_despesa_tipo_despesa1`
    FOREIGN KEY (`tipo_despesa_id`)
    REFERENCES `orcamento`.`tdespesa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 23
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `orcamento`.`endereco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `orcamento`.`endereco` (
  `usuario_id` INT(11) NOT NULL,
  `bairro` VARCHAR(45) NULL DEFAULT NULL,
  `cidade` VARCHAR(45) NULL DEFAULT NULL,

    INDEX `fk_endereco_usuario1_idx` (`usuario_usuario_id` ASC),
  CONSTRAINT `fk_endereco_usuario1`
    FOREIGN KEY (`usuario_usuario_id`)
    REFERENCES `orcamento`.`usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `orcamento`.`treceita`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `orcamento`.`treceita` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `categoria` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 13
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `orcamento`.`receita`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `orcamento`.`receita` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `valor` DOUBLE NULL DEFAULT NULL,
  `data` DATE NULL DEFAULT NULL,
  `tipo_receita_id` INT(11) NOT NULL,
  `conta_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_receita_tipo_receita1_idx` (`tipo_receita_id` ASC),
  INDEX `fk_receita_conta1_idx` (`conta_id` ASC),
  CONSTRAINT `fk_receita_conta1`
    FOREIGN KEY (`conta_id`)
    REFERENCES `orcamento`.`conta` (`conta_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_receita_tipo_receita1`
    FOREIGN KEY (`tipo_receita_id`)
    REFERENCES `orcamento`.`treceita` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 26
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
