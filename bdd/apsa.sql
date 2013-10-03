-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 28 Juin 2013 à 17:54
-- Version du serveur: 5.5.29
-- Version de PHP: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `mydb`
--

-- --------------------------------------------------------

--
-- Structure de la table `appel115`
--

CREATE TABLE `appel115` (
  `idAppel115` int(11) NOT NULL AUTO_INCREMENT,
  `dateAppel` date DEFAULT NULL,
  `heureAppel` time DEFAULT NULL,
  `polluant` tinyint(1) DEFAULT NULL,
  `directEnregistre` tinyint(1) DEFAULT NULL,
  `commentaires` text,
  PRIMARY KEY (`idAppel115`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `appel115_has_demandepriseencompte`
--

CREATE TABLE `appel115_has_demandepriseencompte` (
  `Appel115_idAppel115` int(11) NOT NULL,
  `DemandePriseEnCompte_idDemandePriseEnCompte` int(11) NOT NULL,
  PRIMARY KEY (`Appel115_idAppel115`,`DemandePriseEnCompte_idDemandePriseEnCompte`),
  KEY `fk_Appel115_has_Personne_Appel1151_idx` (`Appel115_idAppel115`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `categorieage`
--

CREATE TABLE `categorieage` (
  `categorieAge` int(11) NOT NULL AUTO_INCREMENT,
  `intitule` varchar(45) DEFAULT NULL,
  `ageMin` int(11) DEFAULT NULL,
  `ageMax` int(11) DEFAULT NULL,
  PRIMARY KEY (`categorieAge`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `categorieage`
--

INSERT INTO `categorieage` (`categorieAge`, `intitule`, `ageMin`, `ageMax`) VALUES
(1, 'Mineur', 0, 17),
(2, '18/25 Ans', 18, 25),
(3, '26/35 Ans', 26, 35),
(4, '36/50 Ans', 36, 50),
(5, '51/65 Ans', 51, 65),
(6, '+ de 66 Ans', 66, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `demandepriseencompte`
--

CREATE TABLE `demandepriseencompte` (
  `idDemandePriseEnCompte` int(11) NOT NULL AUTO_INCREMENT,
  `interventionEquipeRue` tinyint(1) DEFAULT NULL,
  `dateDemande` date NOT NULL,
  `InitiativeDemande_initiativeDemande` int(11) NOT NULL,
  `Personne_idPersonne` int(11) NOT NULL,
  PRIMARY KEY (`idDemandePriseEnCompte`),
  KEY `fk_AppelPrisEnCharge_InitiativeDemande1_idx` (`InitiativeDemande_initiativeDemande`),
  KEY `fk_AppelPrisEnCharge_Personne1_idx` (`Personne_idPersonne`),
  KEY `Personne_idPersonne` (`Personne_idPersonne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `idEmploye` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `statut` varchar(45) DEFAULT NULL,
  `permis` tinyint(1) DEFAULT NULL,
  `droits` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idEmploye`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `employe`
--

INSERT INTO `employe` (`idEmploye`, `login`, `mdp`, `nom`, `prenom`, `statut`, `permis`, `droits`) VALUES
(1, 'admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 'Lucas', 'Maxence', 'Stagiaire', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

CREATE TABLE `equipe` (
  `idEquipe` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreationEquipe` date NOT NULL,
  PRIMARY KEY (`idEquipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `equipe_has_employe`
--

CREATE TABLE `equipe_has_employe` (
  `Equipe_idEquipe` int(11) NOT NULL,
  `Employe_idEmploye` int(11) NOT NULL,
  PRIMARY KEY (`Equipe_idEquipe`,`Employe_idEmploye`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `est_conjoint`
--

CREATE TABLE `est_conjoint` (
  `Personne_idPersonne1` int(11) NOT NULL,
  `Personne_idPersonne2` int(11) NOT NULL,
  PRIMARY KEY (`Personne_idPersonne1`,`Personne_idPersonne2`),
  KEY `fk_Personne_has_Personne_Personne2_idx` (`Personne_idPersonne2`),
  KEY `fk_Personne_has_Personne_Personne1_idx` (`Personne_idPersonne1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `initiativedemande`
--

CREATE TABLE `initiativedemande` (
  `initiativeDemande` int(11) NOT NULL AUTO_INCREMENT,
  `intituleDemande` varchar(45) DEFAULT NULL,
  `ordreDemande` int(11) NOT NULL,
  PRIMARY KEY (`initiativeDemande`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `initiativedemande`
--

INSERT INTO `initiativedemande` (`initiativeDemande`, `intituleDemande`, `ordreDemande`) VALUES
(1, 'Usager', 1),
(2, 'Intervenant social', 2),
(3, 'Service diagnostique', 3),
(4, 'Autres partenaires sociaux', 4),
(5, 'Police', 5),
(6, 'Pompiers', 6),
(7, 'Hôpital', 7),
(8, 'Particulier', 8),
(9, 'Autres', 9);

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

CREATE TABLE `intervention` (
  `idIntervention` int(11) NOT NULL AUTO_INCREMENT,
  `dateRdv` date DEFAULT NULL,
  `heureRdv` time DEFAULT NULL,
  `lieuIntervention` varchar(45) DEFAULT NULL,
  `dureeIntervention` time DEFAULT NULL,
  `absence` tinyint(1) DEFAULT NULL,
  `personne_idPersonne` int(11) NOT NULL,
  `demandePriseEnCompte_idDemandePriseEnCompte` int(11) NOT NULL,
  `JourneeIntervention_idJourneeIntervention` int(11) NOT NULL,
  PRIMARY KEY (`idIntervention`),
  KEY `fk_Intervention_Personne1_idx` (`personne_idPersonne`),
  KEY `fk_Intervention_DemandePriseEnCompte1_idx` (`demandePriseEnCompte_idDemandePriseEnCompte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `intervention_has_employe`
--

CREATE TABLE `intervention_has_employe` (
  `Intervention_idIntervention` int(11) NOT NULL,
  `Employe_idEmploye` int(11) NOT NULL,
  PRIMARY KEY (`Intervention_idIntervention`,`Employe_idEmploye`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `journeeIntervention`
--

CREATE TABLE `journeeIntervention` (
  `idJourneeIntervention` int(11) NOT NULL AUTO_INCREMENT,
  `dateJourneeIntervention` date DEFAULT NULL,
  `heureDebut` time DEFAULT NULL,
  `heureFin` time DEFAULT NULL,
  `nbKm` int(11) DEFAULT NULL,
  `Vehicule_idVehicule` int(11) NOT NULL,
  PRIMARY KEY (`idJourneeIntervention`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `motif`
--

CREATE TABLE `motif` (
  `idMotif` int(11) NOT NULL AUTO_INCREMENT,
  `intituleMotif` varchar(45) DEFAULT NULL,
  `ordreMotif` int(11) NOT NULL,
  PRIMARY KEY (`idMotif`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `motif`
--

INSERT INTO `motif` (`idMotif`, `intituleMotif`, `ordreMotif`) VALUES
(1, 'Non renseigné', 1),
(2, 'Demandeur d''asile', 2),
(3, 'Demande d''hébergement', 3),
(4, 'Demande de logement', 4),
(5, 'Prestations (Alim,Couv,Soins,etc)', 5),
(6, 'Informations', 6),
(7, 'Ecoute', 7),
(8, 'Signalement d''un sans abri', 8),
(9, 'Salle', 9);

-- --------------------------------------------------------

--
-- Structure de la table `motif_has_demandepriseencompte`
--

CREATE TABLE `motif_has_demandepriseencompte` (
  `Motif_idMotif` int(11) NOT NULL,
  `DemandePriseEnCompte_idDemandePriseEnCompte` int(11) NOT NULL,
  PRIMARY KEY (`Motif_idMotif`,`DemandePriseEnCompte_idDemandePriseEnCompte`),
  KEY `fk_Personne_has_Motif_Motif1_idx` (`Motif_idMotif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `orientation`
--

CREATE TABLE `orientation` (
  `idOrientation` int(11) NOT NULL AUTO_INCREMENT,
  `intituleOrientation` varchar(45) DEFAULT NULL,
  `ordreOrientation` int(11) NOT NULL,
  PRIMARY KEY (`idOrientation`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `orientation`
--

INSERT INTO `orientation` (`idOrientation`, `intituleOrientation`, `ordreOrientation`) VALUES
(1, 'Intervention équipe de rue', 1),
(2, 'Hôtel par SIAO', 2),
(3, 'Hôtel par CHRS 9 de Coeur', 3),
(4, 'CHRS Schaffner', 4),
(5, 'CHRS 9 de Coeur', 5),
(6, 'La Boussole', 6),
(7, 'Service diagnostique', 7),
(8, 'Hôpital', 8),
(9, 'Solution par lui-même', 9),
(10, 'Famille/Amis', 10),
(11, 'Services sociaux', 11),
(12, 'Police', 12),
(13, 'Pompiers', 13),
(14, 'Samu', 14),
(15, 'Structures caritatives', 15),
(16, 'Absence d''urgence Rappel', 16),
(17, 'Signalement', 17);

-- --------------------------------------------------------

--
-- Structure de la table `orientation_has_demandepriseencompte`
--

CREATE TABLE `orientation_has_demandepriseencompte` (
  `Orientation_idOrientation` int(11) NOT NULL,
  `DemandePriseEnCompte_idDemandePriseEnCompte` int(11) NOT NULL,
  PRIMARY KEY (`Orientation_idOrientation`,`DemandePriseEnCompte_idDemandePriseEnCompte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `origine`
--

CREATE TABLE `origine` (
  `idOrigine` int(11) NOT NULL AUTO_INCREMENT,
  `intituleOrigine` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idOrigine`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `origine`
--

INSERT INTO `origine` (`idOrigine`, `intituleOrigine`) VALUES
(1, 'Lens'),
(2, 'Liévin'),
(3, 'Hénin'),
(4, 'Carvin'),
(5, 'CALL'),
(6, 'CAHC'),
(7, 'Département du Pas-de-Calais'),
(8, 'Département du Nord'),
(9, 'France'),
(10, 'Union Européenne'),
(11, 'Hors Union Européenne');

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `idPersonne` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `sexe` varchar(45) DEFAULT NULL,
  `dateNaissance` date DEFAULT NULL,
  `telephone` varchar(10) DEFAULT NULL,
  `notes` text,
  `CategorieAge_categorieAge` int(11) NOT NULL,
  `Origine_idOrigine` int(11) NOT NULL,
  `Typologie_idTypologie` int(11) NOT NULL,
  `aPourResponsable1` int(11) DEFAULT NULL,
  `aPourResponsable2` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPersonne`),
  KEY `fk_Personne_CategorieAge_idx` (`CategorieAge_categorieAge`),
  KEY `fk_Personne_Origine1_idx` (`Origine_idOrigine`),
  KEY `fk_Personne_Typologie1_idx` (`Typologie_idTypologie`),
  KEY `fk_Personne_Personne1_idx` (`aPourResponsable1`),
  KEY `fk_Personne_Personne2_idx` (`aPourResponsable2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `personne_has_ressource`
--

CREATE TABLE `personne_has_ressource` (
  `Personne_idPersonne` int(11) NOT NULL,
  `Ressource_idRessource` int(11) NOT NULL,
  `montant` int(11) DEFAULT NULL,
  PRIMARY KEY (`Personne_idPersonne`,`Ressource_idRessource`),
  KEY `fk_Personne_has_Ressource_Ressource1_idx` (`Ressource_idRessource`),
  KEY `fk_Personne_has_Ressource_Personne1_idx` (`Personne_idPersonne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `prestation`
--

CREATE TABLE `prestation` (
  `idPrestation` int(11) NOT NULL AUTO_INCREMENT,
  `typePrestation` varchar(45) DEFAULT NULL,
  `ordrePrestation` int(11) NOT NULL,
  PRIMARY KEY (`idPrestation`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `prestation`
--

INSERT INTO `prestation` (`idPrestation`, `typePrestation`, `ordrePrestation`) VALUES
(1, 'Soins', 1),
(2, 'Colis alimentaire', 2),
(3, 'Kit santé', 3),
(4, 'Chèque service', 4),
(5, 'Courrier', 5),
(6, 'Couverture', 6),
(7, 'Vestimentaire', 7),
(8, 'Hébergement', 8),
(9, 'Bon de nuitée', 9),
(10, 'PGF', 10);

-- --------------------------------------------------------

--
-- Structure de la table `prestation_has_demandepriseencompte`
--

CREATE TABLE `prestation_has_demandepriseencompte` (
  `Prestation_idPrestation` int(11) NOT NULL,
  `DemandePriseEnCompte_idDemandePriseEnCompte` int(11) NOT NULL,
  PRIMARY KEY (`Prestation_idPrestation`,`DemandePriseEnCompte_idDemandePriseEnCompte`),
  KEY `fk_Prestation_has_DemandePriseEnCompte_DemandePriseEnCompte_idx` (`DemandePriseEnCompte_idDemandePriseEnCompte`),
  KEY `fk_Prestation_has_DemandePriseEnCompte_Prestation1_idx` (`Prestation_idPrestation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ressource`
--

CREATE TABLE `ressource` (
  `idRessource` int(11) NOT NULL AUTO_INCREMENT,
  `typeRessource` varchar(45) DEFAULT NULL,
  `ordreRessource` int(11) NOT NULL,
  PRIMARY KEY (`idRessource`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `ressource`
--

INSERT INTO `ressource` (`idRessource`, `typeRessource`, `ordreRessource`) VALUES
(1, 'Non renseigné', 1),
(2, 'Sans ressources', 2),
(3, 'Ressources en attente', 3),
(4, 'Salaire-Intérim', 4),
(5, 'Stage rémunéré', 5),
(6, 'RSA', 6),
(7, 'Prestations CAF', 7),
(8, 'AAH', 8),
(9, 'ASSEDIC', 9),
(10, 'Retraites', 10),
(11, 'ATA', 11),
(12, 'Pension invalidité', 12),
(13, 'Autres', 13);

-- --------------------------------------------------------

--
-- Structure de la table `rupture`
--

CREATE TABLE `rupture` (
  `idRupture` int(11) NOT NULL AUTO_INCREMENT,
  `intituleRupture` varchar(45) NOT NULL,
  `ordreRupture` int(11) NOT NULL,
  PRIMARY KEY (`idRupture`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `rupture`
--

INSERT INTO `rupture` (`idRupture`, `intituleRupture`, `ordreRupture`) VALUES
(1, 'Crise familiale', 1),
(2, 'Crise familiale dont violence', 2),
(3, 'Crise conjugale', 3),
(4, 'Crise conjugale dont violence', 4),
(5, 'Expulsion', 5),
(6, 'Insalubrité', 6),
(7, 'Fin d''hébergement amical', 7),
(8, 'Sortie hôpital/cure', 8),
(9, 'Sortie autres établissement', 9),
(10, 'Sortie prison', 10),
(11, 'SDF', 11),
(12, 'Autres', 12);

-- --------------------------------------------------------

--
-- Structure de la table `rupture_has_demandepriseencompte`
--

CREATE TABLE `rupture_has_demandepriseencompte` (
  `Rupture_idRupture` int(11) NOT NULL,
  `DemandePriseEnCompte_idDemandePriseEnCompte` int(11) NOT NULL,
  `dateRupture` date DEFAULT NULL,
  PRIMARY KEY (`Rupture_idRupture`,`DemandePriseEnCompte_idDemandePriseEnCompte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `situation`
--

CREATE TABLE `situation` (
  `idSituation` int(11) NOT NULL AUTO_INCREMENT,
  `dateSituation` date NOT NULL,
  `texteSituation` text NOT NULL,
  `dateRappelSituation` date DEFAULT NULL,
  PRIMARY KEY (`idSituation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `situationrue`
--

CREATE TABLE `situationrue` (
  `idSituationRue` int(11) NOT NULL AUTO_INCREMENT,
  `intituleSituationRue` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idSituationRue`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `situationrue`
--

INSERT INTO `situationrue` (`idSituationRue`, `intituleSituationRue`) VALUES
(1, 'Manche'),
(2, 'Errance'),
(3, 'Squat');

-- --------------------------------------------------------

--
-- Structure de la table `situationrue_has_personne`
--

CREATE TABLE `situationrue_has_personne` (
  `SituationRue_idSituationRue` int(11) NOT NULL,
  `Personne_idPersonne` int(11) NOT NULL,
  PRIMARY KEY (`SituationRue_idSituationRue`,`Personne_idPersonne`),
  KEY `fk_SituationRue_has_Personne_Personne1_idx` (`Personne_idPersonne`),
  KEY `fk_SituationRue_has_Personne_SituationRue1_idx` (`SituationRue_idSituationRue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `situation_has_personne`
--

CREATE TABLE `situation_has_personne` (
  `Situation_idSituation` int(11) NOT NULL,
  `Personne_idPersonne` int(11) NOT NULL,
  PRIMARY KEY (`Situation_idSituation`,`Personne_idPersonne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `typologie`
--

CREATE TABLE `typologie` (
  `idTypologie` int(11) NOT NULL AUTO_INCREMENT,
  `intituleTypologie` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idTypologie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

CREATE TABLE `vehicule` (
  `idVehicule` int(11) NOT NULL AUTO_INCREMENT,
  `intituleVehicule` varchar(50) NOT NULL,
  PRIMARY KEY (`idVehicule`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `vehicule`
--

INSERT INTO `vehicule` (`idVehicule`, `intituleVehicule`) VALUES
(1, 'Kangoo Blanc'),
(2, 'Kangoo Noir');
