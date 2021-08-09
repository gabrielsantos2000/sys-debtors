-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema db_devedores
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_devedores
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_devedores` DEFAULT CHARACTER SET utf8mb4 ;
USE `db_devedores` ;

-- -----------------------------------------------------
-- Table `db_devedores`.`tb_cidade`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_devedores`.`tb_cidade` ;

CREATE TABLE IF NOT EXISTS `db_devedores`.`tb_cidade` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nm_cidade` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_devedores`.`tb_devedor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_devedores`.`tb_devedor` ;

CREATE TABLE IF NOT EXISTS `db_devedores`.`tb_devedor` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nm_devedor` VARCHAR(100) NOT NULL,
  `dt_nascimento` DATE NOT NULL,
  `nr_cpf_cnpj` INT(14) NOT NULL,
  `ic_ativo` TINYINT(1) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `cpf_cnpj_unique` (`nr_cpf_cnpj` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_devedores`.`tb_natureza_divida`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_devedores`.`tb_natureza_divida` ;

CREATE TABLE IF NOT EXISTS `db_devedores`.`tb_natureza_divida` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nm_natureza` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_devedores`.`tb_divida`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_devedores`.`tb_divida` ;

CREATE TABLE IF NOT EXISTS `db_devedores`.`tb_divida` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nm_titulo` VARCHAR(60) NOT NULL,
  `ds_titulo` VARCHAR(300) NULL DEFAULT NULL,
  `vl_divida` DECIMAL(8,2) NOT NULL,
  `dt_divida` DATETIME NOT NULL,
  `dt_vencimento` DATETIME NOT NULL,
  `id_natureza_divida` INT(11) NOT NULL,
  `ic_ativo` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_divida_natureza_idx` (`id_natureza_divida` ASC),
  CONSTRAINT `fk_divida_natureza`
    FOREIGN KEY (`id_natureza_divida`)
    REFERENCES `db_devedores`.`tb_natureza_divida` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_devedores`.`tb_estado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_devedores`.`tb_estado` ;

CREATE TABLE IF NOT EXISTS `db_devedores`.`tb_estado` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nm_estado` VARCHAR(100) NOT NULL,
  `sg_estado` CHAR(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `sg_estado_UNIQUE` (`sg_estado` ASC),
  UNIQUE INDEX `nm_estado_UNIQUE` (`nm_estado` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_devedores`.`tb_item_cidade_estado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_devedores`.`tb_item_cidade_estado` ;

CREATE TABLE IF NOT EXISTS `db_devedores`.`tb_item_cidade_estado` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_estado` INT(11) NOT NULL,
  `id_cidade` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_item_cidade_idx` (`id_cidade` ASC),
  INDEX `fk_item_estado_idx` (`id_estado` ASC),
  CONSTRAINT `fk_item_cidade`
    FOREIGN KEY (`id_cidade`)
    REFERENCES `db_devedores`.`tb_cidade` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_estado`
    FOREIGN KEY (`id_estado`)
    REFERENCES `db_devedores`.`tb_estado` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_devedores`.`tb_endereco`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_devedores`.`tb_endereco` ;

CREATE TABLE IF NOT EXISTS `db_devedores`.`tb_endereco` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nm_logradouro` VARCHAR(100) NOT NULL,
  `nr_logradouro` CHAR(4) NOT NULL,
  `nm_bairro` VARCHAR(100) NOT NULL,
  `id_estado_cidade` INT(11) NOT NULL,
  `id_devedor` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_endereco_estado_cidade_idx` (`id_estado_cidade` ASC),
  INDEX `fk_endereco_devedor_idx` (`id_devedor` ASC),
  CONSTRAINT `fk_endereco_devedor`
    FOREIGN KEY (`id_devedor`)
    REFERENCES `db_devedores`.`tb_devedor` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endereco_estado_cidade`
    FOREIGN KEY (`id_estado_cidade`)
    REFERENCES `db_devedores`.`tb_item_cidade_estado` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_devedores`.`tb_item_divida_devedor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_devedores`.`tb_item_divida_devedor` ;

CREATE TABLE IF NOT EXISTS `db_devedores`.`tb_item_divida_devedor` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_devedor` INT(11) NOT NULL,
  `id_divida` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_divida_devedor_idx` (`id_devedor` ASC),
  INDEX `fk_divida_idx` (`id_divida` ASC),
  CONSTRAINT `fk_divida`
    FOREIGN KEY (`id_divida`)
    REFERENCES `db_devedores`.`tb_divida` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_divida_devedor`
    FOREIGN KEY (`id_devedor`)
    REFERENCES `db_devedores`.`tb_devedor` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
