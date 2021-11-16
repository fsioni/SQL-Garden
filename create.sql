CREATE TABLE IF NOT EXISTS `Jardins` (
	`idJ` INT NOT NULL AUTO_INCREMENT,
	`nomJ` varchar(255) NOT NULL DEFAULT ("NONE"),
	`surface` FLOAT ,
	PRIMARY KEY (`idJ`)
);

CREATE TABLE IF NOT EXISTS `Parcelles` (
	`latitudeP` FLOAT ,
	`longitudeP` FLOAT ,
	`hauteur` INT ,
	`idJ` INT ,
	PRIMARY KEY (`latitudeP`,`longitudeP`)
);

CREATE TABLE IF NOT EXISTS `Récoltes` (
	`idRec` INT NOT NULL AUTO_INCREMENT,
	`qualité` INT ,
	`quantité` INT ,
	`commentaireRec` varchar(255) NOT NULL DEFAULT ("NONE"),
	`dateRec` DATE ,
	`latitudeP` FLOAT ,
	`longitudeP` FLOAT ,
	PRIMARY KEY (`idRec`)
);

CREATE TABLE IF NOT EXISTS `Rangs` (
	`numéro` INT NOT NULL AUTO_INCREMENT,
	`latitudeR` FLOAT ,
	`longitudeR` FLOAT ,
	`état` varchar(30) NOT NULL DEFAULT ("NONE"),
	`latitudeP` FLOAT ,
	`longitudeP` FLOAT ,
	PRIMARY KEY (`numéro`)
);

CREATE TABLE IF NOT EXISTS `PlantesSauvages` (
	`nomPS` varchar(30) NOT NULL,
	PRIMARY KEY (`nomPS`)
);

CREATE TABLE IF NOT EXISTS `Variétés` (
	`idV` varchar(255) NOT NULL,
	`annéeV` INT ,
	`précocité` varchar(30) DEFAULT ("NONE"),
	`plantation` varchar(30) DEFAULT ("NONE"),
	`entretien` varchar(30) DEFAULT ("NONE"),
	`récolte` varchar(30) DEFAULT ("NONE"),
	`joursLevée` INT DEFAULT (0),
	`périodePlantation` varchar(30) DEFAULT ("NONE"),
	`périodeRécolte` varchar(30) DEFAULT ("NONE"),
	`commentaireGen` varchar(255) DEFAULT ("NONE"),
	`nomLatin` varchar(255) DEFAULT ("NONE"),
	PRIMARY KEY (`idV`)
);

CREATE TABLE IF NOT EXISTS `Description` (
	`contenu` varchar(255)  DEFAULT ("NONE"),
	`idV` varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS  `Semenciers` (
	`nomSem` varchar(30) NOT NULL,
	`siteWeb` varchar(255) NOT NULL DEFAULT ("NONE"),
	PRIMARY KEY (`nomSem`)
);

CREATE TABLE IF NOT EXISTS  `Plantes` (
	`nomP` varchar(255) NOT NULL,
	`nomLatinP` varchar(255) NOT NULL,
	`catégorie` varchar(30) NOT NULL DEFAULT ("NONE"),
	`typeP` varchar(255) NOT NULL DEFAULT ("NONE"),
	`sousType` varchar(255) NOT NULL DEFAULT ("NONE"),
	PRIMARY KEY (`nomP`)
);

CREATE TABLE IF NOT EXISTS  `Menaces` (
	`idMen` INT NOT NULL AUTO_INCREMENT,
	`desciptionMen` varchar(255) NOT NULL DEFAULT ("NONE"),
	PRIMARY KEY (`idMen`)
);

CREATE TABLE IF NOT EXISTS  `Solutions` (
	`nomS` varchar(255) NOT NULL,
   PRIMARY KEY (`nomS`)
);

CREATE TABLE IF NOT EXISTS  `TypesSol` (
	`nomTS` varchar(30) NOT NULL,
	PRIMARY KEY (`nomTS`)
);

CREATE TABLE IF NOT EXISTS  `FairePartieDe` (
	`idJ` INT NOT NULL,
	`idTJ` INT NOT NULL
);

CREATE TABLE IF NOT EXISTS  `TypeJardin` (
	`idTJ` INT NOT NULL AUTO_INCREMENT,
	`nomType` varchar(30) NOT NULL,
	`hauteurMax` INT,
	`nomTS` varchar(30) NOT NULL DEFAULT ("NONE"),
	PRIMARY KEY (`idTJ`)
);

CREATE TABLE IF NOT EXISTS  `Couvrir` (
	`numero` INT NOT NULL,
	`latitudeP` FLOAT NOT NULL,
	`longitudeP` FLOAT NOT NULL,
	`nomPS` varchar(30) NOT NULL DEFAULT ("NONE"),
	`dateDebut` DATE NOT NULL,
	`dateFin` DATE NOT NULL,
	PRIMARY KEY (`numero`)
);

CREATE TABLE IF NOT EXISTS  `EtreSourceDe` (
	`nomP` varchar(255) NOT NULL,
	`EtreSourceDe` varchar(255) NOT NULL DEFAULT ("NONE"),
	`typeRelation` varchar(255) NOT NULL DEFAULT ("NONE")
);

CREATE TABLE IF NOT EXISTS  `Subir` (
	`nomP` varchar(255) NOT NULL,
	`idMen` INT NOT NULL
);

CREATE TABLE IF NOT EXISTS  `Résoudre` (
	`idMen` INT NOT NULL,
	`nomS` varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS  `Occuper` (
	`idV` varchar(255) NOT NULL,
	`numero` INT(30) NOT NULL,
	`latitudeP` FLOAT NOT NULL,
	`longitudeP` FLOAT NOT NULL
);

CREATE TABLE IF NOT EXISTS  `Produire` (
	`nomSem` varchar(30) NOT NULL DEFAULT ("NONE"),
	`idV` varchar(255) NOT NULL,
	`version` varchar(30) NOT NULL DEFAULT ("NONE")
);

CREATE TABLE IF NOT EXISTS  `EtreAdapté` (
	`idV` varchar(255) NOT NULL,
	`nomTS` varchar(30) NOT NULL,
	`ratioAdaptation` FLOAT NOT NULL
);

CREATE TABLE IF NOT EXISTS  `Dictionaire` (
	`codeVariété` varchar(255) NOT NULL,
	`nomEspèce` varchar(255) NOT NULL,
	`nomEspèceLatin` varchar(255) NOT NULL,
	`id` varchar(255) NOT NULL ,
	PRIMARY KEY(`id`)
);

ALTER TABLE `Parcelles` ADD CONSTRAINT `Parcelles_fk0` FOREIGN KEY (`idJ`) REFERENCES `Jardins`(`idJ`);

ALTER TABLE `Récoltes` ADD CONSTRAINT `Récoltes_fk0` FOREIGN KEY (`latitudeP`,`longitudeP`) REFERENCES `Parcelles`(`latitudeP`,`longitudeP`);

ALTER TABLE `Rangs` ADD CONSTRAINT `Rangs_fk0` FOREIGN KEY (`latitudeP`,`longitudeP`) REFERENCES `Parcelles`(`latitudeP`,`longitudeP`);

ALTER TABLE `Variétés` ADD CONSTRAINT `Variétés_fk0` FOREIGN KEY (`idV`) REFERENCES `Dictionaire`(`id`);

ALTER TABLE `Description` ADD CONSTRAINT `Description_fk0` FOREIGN KEY (`idV`) REFERENCES `Variétés`(`idV`);

ALTER TABLE `FairePartieDe` ADD CONSTRAINT `FairePartirDe_fk0` FOREIGN KEY (`idJ`) REFERENCES `Jardins`(`idJ`);

ALTER TABLE `FairePartieDe` ADD CONSTRAINT `FairePartirDe_fk1` FOREIGN KEY (`idTJ`) REFERENCES `TypeJardin`(`idTJ`);

ALTER TABLE `TypeJardin` ADD CONSTRAINT `TypeJardin_fk0` FOREIGN KEY (`nomTS`) REFERENCES `TypesSol`(`nomTS`);

ALTER TABLE `Couvrir` ADD CONSTRAINT `Couvrir_fk0` FOREIGN KEY (`numero`) REFERENCES `Rangs`(`numéro`);

ALTER TABLE `Couvrir` ADD CONSTRAINT `Couvrir_fk1` FOREIGN KEY (`latitudeP`,`longitudeP`) REFERENCES `Parcelles`(`latitudeP`,`longitudeP`);

ALTER TABLE `Couvrir` ADD CONSTRAINT `Couvrir_fk3` FOREIGN KEY (`nomPS`) REFERENCES `PlantesSauvages`(`nomPS`);

ALTER TABLE `EtreSourceDe` ADD CONSTRAINT `EtreSourceDe_fk0` FOREIGN KEY (`nomP`) REFERENCES `Plantes`(`nomP`);

ALTER TABLE `Subir` ADD CONSTRAINT `Subir_fk0` FOREIGN KEY (`nomP`) REFERENCES `Plantes`(`nomP`);

ALTER TABLE `Subir` ADD CONSTRAINT `Subir_fk1` FOREIGN KEY (`idMen`) REFERENCES `Menaces`(`idMen`);

ALTER TABLE `Résoudre` ADD CONSTRAINT `Résoudre_fk0` FOREIGN KEY (`idMen`) REFERENCES `Menaces`(`idMen`);

ALTER TABLE `Résoudre` ADD CONSTRAINT `Résoudre_fk1` FOREIGN KEY (`nomS`) REFERENCES `Solutions`(`nomS`);

ALTER TABLE `Occuper` ADD CONSTRAINT `Occuper_fk0` FOREIGN KEY (`idV`) REFERENCES `Variétés`(`idV`);

ALTER TABLE `Occuper` ADD CONSTRAINT `Occuper_fk1` FOREIGN KEY (`numero`) REFERENCES `Rangs`(`numéro`);

ALTER TABLE `Occuper` ADD CONSTRAINT `Occuper_fk2` FOREIGN KEY (`latitudeP`,`longitudeP`) REFERENCES `Parcelles`(`latitudeP`,`longitudeP`);

ALTER TABLE `Produire` ADD CONSTRAINT `Produire_fk0` FOREIGN KEY (`nomSem`) REFERENCES `Semenciers`(`nomSem`);

ALTER TABLE `Produire` ADD CONSTRAINT `Produire_fk1` FOREIGN KEY (`idV`) REFERENCES `Variétés`(`idV`);

ALTER TABLE `EtreAdapté` ADD CONSTRAINT `EtreAdapté_fk0` FOREIGN KEY (`idV`) REFERENCES `Variétés`(`idV`);

ALTER TABLE `EtreAdapté` ADD CONSTRAINT `EtreAdapté_fk1` FOREIGN KEY (`nomTS`) REFERENCES `TypesSol`(`nomTS`);
