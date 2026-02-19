CREATE TABLE institution_tutelles
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT institution_tutelles_pkey PRIMARY KEY (id),
    CONSTRAINT institution_tutelles_intitule_unique UNIQUE (intitule)
);
INSERT INTO institution_tutelles (intitule) VALUES
('Ministère de lEconomie et des Finances');

CREATE TABLE nature_donnees
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT nature_donnees_pkey PRIMARY KEY (id),
    CONSTRAINT nature_donnees_intitule_unique UNIQUE (intitule)
);
INSERT INTO nature_donnees (intitule) VALUES
('Prévision'),
('Réalisation'),
('Valeur de référence');

CREATE TABLE type_indicateurs
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT type_indicateurs_pkey PRIMARY KEY (id),
    CONSTRAINT type_indicateurs_intitule_unique UNIQUE (intitule)
);
INSERT INTO type_indicateurs (intitule) VALUES
('Strategie'),
('Produit');


CREATE TABLE nature_financements
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT nature_financements_pkey PRIMARY KEY (id),
    CONSTRAINT nature_financements_intitule_unique UNIQUE (intitule)
);
INSERT INTO nature_financements (intitule) VALUES
('ANR'),
('EMPRUNT'),
('FONDS PROPRES'),
('FONDS DE CONTREPARTIE'),
('BENEFICIAIRES'),
('PPP'),
('COLLECTIVITES'),
('AUTRES A PRECISER');

CREATE TABLE periodes
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT periodes_pkey PRIMARY KEY (id),
    CONSTRAINT periodes_intitule_unique UNIQUE (intitule)
);
INSERT INTO periodes (intitule) VALUES
('2000'),
('2001'),
('2002'),
('2003'),
('2004'),
('2005'),
('2006'),
('2007'),
('2008'),
('2009'),
('2010'),
('2011'),
('2012'),
('2013'),
('2014'),
('2015'),
('2016'),
('2017'),
('2018'),
('2019'),
('2020'),
('2021'),
('2022'),
('2023'),
('2024'),
('2025'),
('2026'),
('2027'),
('2028'),
('2029'),
('2030');

CREATE TABLE population_cibles
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT population_cibles_pkey PRIMARY KEY (id),
    CONSTRAINT population_cibles_intitule_unique UNIQUE (intitule)
);

CREATE TABLE priorites
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT priorites_pkey PRIMARY KEY (id),
    CONSTRAINT priorites_intitule_unique UNIQUE (intitule)
);
INSERT INTO priorites (intitule) VALUES
('Non précisé'),
('Haute'),
('Moyenne'),
('Basse'),
('A attribuer');

CREATE TABLE bailleurs
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT bailleurs_pkey PRIMARY KEY (id),
    CONSTRAINT bailleurs_intitule_unique UNIQUE (intitule)
);
INSERT INTO bailleurs (intitule) VALUES
('Banque Mondiale'),
('UNICEF'),
('ETAT');

CREATE TABLE source_financements
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT source_financements_pkey PRIMARY KEY (id),
    CONSTRAINT source_financements_intitule_unique UNIQUE (intitule)
);
INSERT INTO source_financements (intitule) VALUES
('PTFs'),
('ETAT'),
('cofinancement Etat/PTFs');

CREATE TABLE source_indicateurs
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT source_indicateurs_pkey PRIMARY KEY (id),
    CONSTRAINT source_indicateurs_intitule_unique UNIQUE (intitule)
);
INSERT INTO source_indicateurs (intitule) VALUES
('INS, 2021, EHCVM'),
('INS, 2019, Rapport sur les projections démographiques'),
('Rapport Ministère en charge de l''intérieur'),
('Rapport Ministère en charge de l''intérieur 2022'),
('HACP'),
('MJDH, 2022, Rapport d''enquête sur les besoins et la satisfaction en matière de justice'),
('MJDH'),
('RAP du ministère en charge de la fonction publique'),
('Cour des comptes, 2021, Rapport d''activité'),
('Ministère de l''intérieur'),
('MJCAS'),
('Annuaire MJCAS'),
('INS, 2024, comptes nationaux annuels (CNA) révisés 2015-2022 et provisoires 2023-2024'),
('MEF/DGPPD-DGB'),
('MEF/DGPPD'),
('MEF'),
('DGB'),
('Ministère de l''Agriculture et l''Elevage'),
('Rapport DS/MAG/EL, RAP et RAC du MAG/EL'),
('MEq, 2022, RAP'),
('INS, 2023, Bulletin des statistiques du commerce extérieur'),
('Ministère du Commerce et de l''Industrie'),
('INS, 2022, CEN'),
('ME/ER, RAP 2022'),
('MEq, 2024, RAP'),
('MT, 2022, RAP'),
('ARCEP, Rapport d''activités 2022'),
('INS, 2021, Enquête ENAFEME'),
('INS, 2015, ENISED'),
('Annuaire MEN/A/EP/PLN 2023-2024'),
('INS-RNDH,2020'),
('Annuaire MESR 2023-2024'),
('Annuaire MESRIT 2023-2024'),
('Ministère du Commerce et d''Industrie'),
('Ministère de l''Economie et des Finances'),
('MESRIT'),
('Annuaire Statistique MSP, 2024'),
('Annuaire Santé'),
('Rapport d''évaluation, 2024, du PGDISS 2016-2020'),
('INS, 2022, Enquête SMART'),
('PAP/MAHGC'),
('Rapport ANPE'),
('Rapport sur les indicateurs MH/A'),
('Rapport sur les indicateurs MHA/E'),
('Rapport MELCD'),
('MU/ L, Rapport Annuel de Performance 2022'),
('MU/H RAP');

CREATE TABLE statut_activites
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT statut_activites_pkey PRIMARY KEY (id),
    CONSTRAINT statut_activites_intitule_unique UNIQUE (intitule)
);
INSERT INTO statut_activites (intitule) VALUES
('En cours'),
('Non démarré'),
('Terminé');

CREATE TABLE statut_financements
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT statut_financements_pkey PRIMARY KEY (id),
    CONSTRAINT statut_financements_intitule_unique UNIQUE (intitule)
);
INSERT INTO statut_financements (intitule) VALUES
('A rechercher'),
('Complément à rechercher'),
('En négociation'),
('Accord de principe'),
('Acquis'),
('Signé'),
('Demande transmise');

CREATE TABLE categorie_depenses
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT categorie_depenses_pkey PRIMARY KEY (id),
    CONSTRAINT categorie_depenses_intitule_unique UNIQUE (intitule)
);
INSERT INTO categorie_depenses (intitule) VALUES
('Biens'),
('Travaux'),
('Services'),
('Fonctionnement');

CREATE TABLE statut_produits
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT statut_produits_pkey PRIMARY KEY (id),
    CONSTRAINT statut_produits_intitule_unique UNIQUE (intitule)
);
INSERT INTO statut_produits (intitule) VALUES
('Programmé'),
('En cours d''exécution'),
('Terminé');

CREATE TABLE statut_projets
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT statut_projets_pkey PRIMARY KEY (id),
    CONSTRAINT statut_projets_intitule_unique UNIQUE (intitule)
);
INSERT INTO statut_projets (intitule) VALUES
('Identification'),
('Formulation'),
('Exécution'),
('Cloture');

CREATE TABLE type_activites
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT type_activites_pkey PRIMARY KEY (id),
    CONSTRAINT type_activites_intitule_unique UNIQUE (intitule)
);
INSERT INTO type_activites (intitule) VALUES
('Atelier de formation'),
('Mission de sensibilisation');

CREATE TABLE type_desagregations
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT type_desagregations_pkey PRIMARY KEY (id),
    CONSTRAINT type_desagregations_intitule_unique UNIQUE (intitule)
);
INSERT INTO type_desagregations (intitule) VALUES
('Sexe'),
('Milieu de résidence'),
('Ensemble'),
('NA');

CREATE TABLE type_produits
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT type_produits_pkey PRIMARY KEY (id),
    CONSTRAINT type_produits_intitule_unique UNIQUE (intitule)
);
INSERT INTO type_produits (intitule) VALUES
('Salle de Classe'),
('Centre de santé');

CREATE TABLE unite_indicateurs
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT unite_indicateurs_pkey PRIMARY KEY (id),
    CONSTRAINT unite_indicateurs_intitule_unique UNIQUE (intitule)
);
INSERT INTO unite_indicateurs (intitule) VALUES
('%'),
('Ans'),
('Jour'),
('Encadrants pour 1000hbts'),
('Nombre'),
('Indice'),
('Km/1000hbts'),
('‰'),
('100 000 naissances'),
('Ratio');

CREATE TABLE commentaire_valeur_indicateurs
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT commentaire_valeur_indicateurs_pkey PRIMARY KEY (id),
    CONSTRAINT commentaire_valeur_indicateurs_intitule_unique UNIQUE (intitule)
);
INSERT INTO commentaire_valeur_indicateurs (intitule) VALUES
('RAS'),
('...'),
('///');

CREATE TABLE etudes
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT etudes_pkey PRIMARY KEY (id),
    CONSTRAINT etudes_intitule_unique UNIQUE (intitule)
);
INSERT INTO etudes (intitule) VALUES
('Document d''identification de projet'),
('Etude pré-faisabilité'),
('Document d''evaluation de projet'),
('Etudes de faisabilité technique et financière'),
('Etudes d’impact environnemental'),
('Etudes d’analyse socioéconomique'),
('Etudes géotechniques'),
('Etudes architecturales et topographiques'),
('Etudes bathymétriques'),
('Etudes hydrauliques et hydro-morphiques'),
('Etudes routières'),
('Elaboration d’un plan d’affaires dans le cadre des PPP');


CREATE TABLE zones
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    code character varying(255),
    latitude double precision,
    longitude double precision,
    zone_id bigint,
    niveau integer NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT zones_pkey PRIMARY KEY (id)
);
INSERT INTO zones (id, intitule, code, latitude, longitude, zone_id, niveau, created_at, updated_at) VALUES
(1,	'NIGER',	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL),
(2,	'NIAMEY',	NULL,	NULL,	NULL,	1,	2,	NULL,	NULL),
(3,	'DOSSO',	NULL,	NULL,	NULL,	1,	2,	NULL,	NULL),
(4,	'AGADEZ',	NULL,	NULL,	NULL,	1,	2,	NULL,	NULL),
(5,	'TAHOUA',	NULL,	NULL,	NULL,	1,	2,	NULL,	NULL),
(6,	'MARADI',	NULL,	NULL,	NULL,	1,	2,	NULL,	NULL),
(7,	'DIFFA',	NULL,	NULL,	NULL,	1,	2,	NULL,	NULL),
(8,	'VILLE DE NIAMEY',	NULL,	NULL,	NULL,	2,	3,	NULL,	NULL),
(9,	'DOGONDOUTCHI',	NULL,	NULL,	NULL,	3,	3,	NULL,	NULL),
(10,	'INGALL',	NULL,	NULL,	NULL,	4,	3,	NULL,	NULL),
(11,	'TAHOUA',	NULL,	NULL,	NULL,	5,	3,	NULL,	NULL),
(13,	'BAGAROUA',	NULL,	NULL,	NULL,	5,	3,	NULL,	NULL),
(14,	'ILLELA',	NULL,	NULL,	NULL,	5,	3,	NULL,	NULL),
(15,	'MALBAZA',	NULL,	NULL,	NULL,	5,	3,	NULL,	NULL),
(16,	'MADAOUA',	NULL,	NULL,	NULL,	5,	3,	NULL,	NULL),
(17,	'KEITA',	NULL,	NULL,	NULL,	5,	3,	NULL,	NULL),
(18,	'BOUZA',	NULL,	NULL,	NULL,	5,	3,	NULL,	NULL),
(19,	'ABALAK',	NULL,	NULL,	NULL,	5,	3,	NULL,	NULL),
(20,	'ARLIT',	NULL,	NULL,	NULL,	4,	3,	NULL,	NULL),
(21,	'BOBOYE',	NULL,	NULL,	NULL,	3,	3,	NULL,	NULL),
(22,	'FALMEY',	NULL,	NULL,	NULL,	3,	3,	NULL,	NULL),
(23,	'DOSSO',	NULL,	NULL,	NULL,	3,	3,	NULL,	NULL),
(24,	'GAYA',	NULL,	NULL,	NULL,	3,	3,	NULL,	NULL),
(25,	'DIOUNDIOU',	NULL,	NULL,	NULL,	3,	3,	NULL,	NULL),
(26,	'TIBIRI (DOUTCHI)',	NULL,	NULL,	NULL,	3,	3,	NULL,	NULL),
(27,	'LOGA',	NULL,	NULL,	NULL,	3,	3,	NULL,	NULL),
(28,	'GAZAOUA',	NULL,	NULL,	NULL,	6,	3,	NULL,	NULL),
(29,	'AGUIE',	NULL,	NULL,	NULL,	6,	3,	NULL,	NULL),
(30,	'MADAROUNFA',	NULL,	NULL,	NULL,	6,	3,	NULL,	NULL),
(31,	'GUIDAN-ROUMDJI',	NULL,	NULL,	NULL,	6,	3,	NULL,	NULL),
(32,	'TESSAOUA',	NULL,	NULL,	NULL,	6,	3,	NULL,	NULL),
(33,	'DAKORO',	NULL,	NULL,	NULL,	6,	3,	NULL,	NULL),
(34,	'MAYAHI',	NULL,	NULL,	NULL,	6,	3,	NULL,	NULL),
(35,	'MAINE-SOROA',	NULL,	NULL,	NULL,	7,	3,	NULL,	NULL),
(36,	'DIFFA',	NULL,	NULL,	NULL,	7,	3,	NULL,	NULL),
(37,	'GOUDOUMARIA',	NULL,	NULL,	NULL,	7,	3,	NULL,	NULL),
(38,	'BOSSO',	NULL,	NULL,	NULL,	7,	3,	NULL,	NULL),
(41,	'BERMO',	NULL,	NULL,	NULL,	6,	3,	NULL,	NULL),
(42,	'ADERBISSINAT',	NULL,	NULL,	NULL,	4,	3,	NULL,	NULL),
(43,	'TCHIROZERINE',	NULL,	NULL,	NULL,	4,	3,	NULL,	NULL),
(44,	'IFEROUANE',	NULL,	NULL,	NULL,	4,	3,	NULL,	NULL),
(45,	'BILMA',	NULL,	NULL,	NULL,	4,	3,	NULL,	NULL),
(46,	'MARADI VILLE',	NULL,	NULL,	NULL,	6,	3,	NULL,	NULL),
(47,	'NIAMEY ARRONDISSEMENT 3',	NULL,	NULL,	NULL,	8,	4,	NULL,	NULL),
(48,	'NIAMEY ARRONDISSEMENT 2',	NULL,	NULL,	NULL,	8,	4,	NULL,	NULL),
(49,	'NIAMEY ARRONDISSEMENT 1',	NULL,	NULL,	NULL,	8,	4,	NULL,	NULL),
(50,	'NIAMEY ARRONDISSEMENT 5',	NULL,	NULL,	NULL,	8,	4,	NULL,	NULL),
(51,	'NIAMEY ARRONDISSEMENT 4',	NULL,	NULL,	NULL,	8,	4,	NULL,	NULL),
(52,	'DOGONKIRIA',	NULL,	NULL,	NULL,	9,	4,	NULL,	NULL),
(53,	'MATANKARI',	NULL,	NULL,	NULL,	9,	4,	NULL,	NULL),
(54,	'INGALL',	NULL,	NULL,	NULL,	10,	4,	NULL,	NULL),
(57,	'BAGAROUA',	NULL,	NULL,	NULL,	13,	4,	NULL,	NULL),
(58,	'ILLELA',	NULL,	NULL,	NULL,	14,	4,	NULL,	NULL),
(59,	'BAMBEYE',	NULL,	NULL,	NULL,	11,	4,	NULL,	NULL),
(60,	'TAJAE',	NULL,	NULL,	NULL,	14,	4,	NULL,	NULL),
(61,	'MALBAZA',	NULL,	NULL,	NULL,	15,	4,	NULL,	NULL),
(64,	'DOGUERAWA',	NULL,	NULL,	NULL,	15,	4,	NULL,	NULL),
(65,	'SABON GUIDA',	NULL,	NULL,	NULL,	16,	4,	NULL,	NULL),
(66,	'GALMA KOUDAWATCHE',	NULL,	NULL,	NULL,	16,	4,	NULL,	NULL),
(67,	'TAMASKE',	NULL,	NULL,	NULL,	17,	4,	NULL,	NULL),
(68,	'BADAGUICHIRI',	NULL,	NULL,	NULL,	14,	4,	NULL,	NULL),
(69,	'ALLAKAYE',	NULL,	NULL,	NULL,	18,	4,	NULL,	NULL),
(70,	'TABOTAKI',	NULL,	NULL,	NULL,	18,	4,	NULL,	NULL),
(71,	'AZARORI',	NULL,	NULL,	NULL,	16,	4,	NULL,	NULL),
(72,	'GARHANGA',	NULL,	NULL,	NULL,	17,	4,	NULL,	NULL),
(73,	'DEOULE',	NULL,	NULL,	NULL,	18,	4,	NULL,	NULL),
(74,	'AFFALA',	NULL,	NULL,	NULL,	11,	4,	NULL,	NULL),
(75,	'TABALAK',	NULL,	NULL,	NULL,	19,	4,	NULL,	NULL),
(76,	'BARMOU',	NULL,	NULL,	NULL,	11,	4,	NULL,	NULL),
(77,	'ABALAK',	NULL,	NULL,	NULL,	19,	4,	NULL,	NULL),
(78,	'IBOHAMANE',	NULL,	NULL,	NULL,	17,	4,	NULL,	NULL),
(79,	'KEITA',	NULL,	NULL,	NULL,	17,	4,	NULL,	NULL),
(80,	'AKOUBOUNOU',	NULL,	NULL,	NULL,	19,	4,	NULL,	NULL),
(81,	'BANGUI',	NULL,	NULL,	NULL,	16,	4,	NULL,	NULL),
(82,	'OURNO',	NULL,	NULL,	NULL,	16,	4,	NULL,	NULL),
(83,	'MADAOUA',	NULL,	NULL,	NULL,	16,	4,	NULL,	NULL),
(84,	'KAROFANE',	NULL,	NULL,	NULL,	18,	4,	NULL,	NULL),
(85,	'BOUZA',	NULL,	NULL,	NULL,	18,	4,	NULL,	NULL),
(86,	'BABANKATAMI',	NULL,	NULL,	NULL,	18,	4,	NULL,	NULL),
(87,	'AZEYE',	NULL,	NULL,	NULL,	19,	4,	NULL,	NULL),
(88,	'TAMAYA',	NULL,	NULL,	NULL,	19,	4,	NULL,	NULL),
(89,	'GOUGARAM',	NULL,	NULL,	NULL,	20,	4,	NULL,	NULL),
(91,	'FAKARA',	NULL,	NULL,	NULL,	21,	4,	NULL,	NULL),
(92,	'FALMEY',	NULL,	NULL,	NULL,	22,	4,	NULL,	NULL),
(93,	'FABIDJI',	NULL,	NULL,	NULL,	21,	4,	NULL,	NULL),
(95,	'KANKANDI',	NULL,	NULL,	NULL,	21,	4,	NULL,	NULL),
(96,	'TESSA',	NULL,	NULL,	NULL,	23,	4,	NULL,	NULL),
(97,	'SAMBERA',	NULL,	NULL,	NULL,	23,	4,	NULL,	NULL),
(98,	'TANDA',	NULL,	NULL,	NULL,	24,	4,	NULL,	NULL),
(99,	'GAYA',	NULL,	NULL,	NULL,	24,	4,	NULL,	NULL),
(100,	'YELOU',	NULL,	NULL,	NULL,	24,	4,	NULL,	NULL),
(101,	'GOLLE',	NULL,	NULL,	NULL,	23,	4,	NULL,	NULL),
(102,	'GUILLADJE',	NULL,	NULL,	NULL,	22,	4,	NULL,	NULL),
(103,	'FAREY',	NULL,	NULL,	NULL,	23,	4,	NULL,	NULL),
(104,	'BANA',	NULL,	NULL,	NULL,	24,	4,	NULL,	NULL),
(105,	'BENGOU',	NULL,	NULL,	NULL,	24,	4,	NULL,	NULL),
(106,	'TOUNOUGA',	NULL,	NULL,	NULL,	24,	4,	NULL,	NULL),
(107,	'KARGUIBANGOU',	NULL,	NULL,	NULL,	23,	4,	NULL,	NULL),
(108,	'DIOUNDIOU',	NULL,	NULL,	NULL,	25,	4,	NULL,	NULL),
(109,	'ZABORI',	NULL,	NULL,	NULL,	25,	4,	NULL,	NULL),
(110,	'KARAKARA',	NULL,	NULL,	NULL,	25,	4,	NULL,	NULL),
(111,	'GUECHEME',	NULL,	NULL,	NULL,	26,	4,	NULL,	NULL),
(112,	'MOKKO',	NULL,	NULL,	NULL,	23,	4,	NULL,	NULL),
(113,	'KIOTA',	NULL,	NULL,	NULL,	21,	4,	NULL,	NULL),
(114,	'GARANKEDEY',	NULL,	NULL,	NULL,	23,	4,	NULL,	NULL),
(115,	'GOROUBANKASSAM',	NULL,	NULL,	NULL,	23,	4,	NULL,	NULL),
(116,	'DOSSO',	NULL,	NULL,	NULL,	23,	4,	NULL,	NULL),
(117,	'KOYGOLO',	NULL,	NULL,	NULL,	21,	4,	NULL,	NULL),
(118,	'HARIKANASSOU',	NULL,	NULL,	NULL,	21,	4,	NULL,	NULL),
(119,	'SOKORBE',	NULL,	NULL,	NULL,	27,	4,	NULL,	NULL),
(120,	'LOGA',	NULL,	NULL,	NULL,	27,	4,	NULL,	NULL),
(121,	'KORE MAIROUA',	NULL,	NULL,	NULL,	26,	4,	NULL,	NULL),
(122,	'TOMBOKOIREY II',	NULL,	NULL,	NULL,	23,	4,	NULL,	NULL),
(123,	'TOMBOKOIREY I',	NULL,	NULL,	NULL,	23,	4,	NULL,	NULL),
(124,	'DOUMEGA',	NULL,	NULL,	NULL,	26,	4,	NULL,	NULL),
(125,	'TIBIRI (DOUTCHI)',	NULL,	NULL,	NULL,	26,	4,	NULL,	NULL),
(126,	'DOGONDOUTCHI',	NULL,	NULL,	NULL,	9,	4,	NULL,	NULL),
(127,	'FALWEL',	NULL,	NULL,	NULL,	27,	4,	NULL,	NULL),
(128,	'KIECHE',	NULL,	NULL,	NULL,	9,	4,	NULL,	NULL),
(129,	'DAN-KASSARI',	NULL,	NULL,	NULL,	9,	4,	NULL,	NULL),
(130,	'SOUCOUCOUTANE',	NULL,	NULL,	NULL,	9,	4,	NULL,	NULL),
(131,	'DANNET',	NULL,	NULL,	NULL,	20,	4,	NULL,	NULL),
(132,	'GANGARA (AGUIE)',	NULL,	NULL,	NULL,	28,	4,	NULL,	NULL),
(133,	'AGUIE',	NULL,	NULL,	NULL,	29,	4,	NULL,	NULL),
(134,	'GABI',	NULL,	NULL,	NULL,	30,	4,	NULL,	NULL),
(135,	'SAFO',	NULL,	NULL,	NULL,	30,	4,	NULL,	NULL),
(136,	'TIBIRI (MARADI)',	NULL,	NULL,	NULL,	31,	4,	NULL,	NULL),
(137,	'MADAROUNFA',	NULL,	NULL,	NULL,	30,	4,	NULL,	NULL),
(138,	'DAN-ISSA',	NULL,	NULL,	NULL,	30,	4,	NULL,	NULL),
(139,	'SARKIN YAMMA',	NULL,	NULL,	NULL,	30,	4,	NULL,	NULL),
(140,	'GUIDAN SORI',	NULL,	NULL,	NULL,	31,	4,	NULL,	NULL),
(141,	'DJIRATAWA',	NULL,	NULL,	NULL,	30,	4,	NULL,	NULL),
(142,	'TCHADOUA',	NULL,	NULL,	NULL,	29,	4,	NULL,	NULL),
(143,	'HAWANDAWAKI',	NULL,	NULL,	NULL,	32,	4,	NULL,	NULL),
(144,	'KORGOM',	NULL,	NULL,	NULL,	32,	4,	NULL,	NULL),
(145,	'GAZAOUA',	NULL,	NULL,	NULL,	28,	4,	NULL,	NULL),
(146,	'SAE SABOUA',	NULL,	NULL,	NULL,	31,	4,	NULL,	NULL),
(147,	'MAIYARA',	NULL,	NULL,	NULL,	33,	4,	NULL,	NULL),
(148,	'GUIDAN ROUMDJI',	NULL,	NULL,	NULL,	31,	4,	NULL,	NULL),
(149,	'CHADAKORI',	NULL,	NULL,	NULL,	31,	4,	NULL,	NULL),
(150,	'DAN-GOULBI',	NULL,	NULL,	NULL,	33,	4,	NULL,	NULL),
(151,	'SABON MACHI',	NULL,	NULL,	NULL,	33,	4,	NULL,	NULL),
(152,	'KORNAKA',	NULL,	NULL,	NULL,	33,	4,	NULL,	NULL),
(153,	'SARKIN HAOUSSA',	NULL,	NULL,	NULL,	34,	4,	NULL,	NULL),
(154,	'BAOUDETTA',	NULL,	NULL,	NULL,	32,	4,	NULL,	NULL),
(155,	'MAIJIRGUI',	NULL,	NULL,	NULL,	32,	4,	NULL,	NULL),
(156,	'KOONA',	NULL,	NULL,	NULL,	32,	4,	NULL,	NULL),
(157,	'TESSAOUA',	NULL,	NULL,	NULL,	32,	4,	NULL,	NULL),
(158,	'MAYAHI',	NULL,	NULL,	NULL,	34,	4,	NULL,	NULL),
(159,	'ATTANTANE',	NULL,	NULL,	NULL,	34,	4,	NULL,	NULL),
(160,	'OURAFANE',	NULL,	NULL,	NULL,	32,	4,	NULL,	NULL),
(161,	'KANAN-BAKACHE',	NULL,	NULL,	NULL,	34,	4,	NULL,	NULL),
(162,	'ISSAWANE',	NULL,	NULL,	NULL,	34,	4,	NULL,	NULL),
(163,	'FOULATARI',	NULL,	NULL,	NULL,	35,	4,	NULL,	NULL),
(164,	'MAINE SOROA',	NULL,	NULL,	NULL,	35,	4,	NULL,	NULL),
(165,	'CHETIMARI',	NULL,	NULL,	NULL,	36,	4,	NULL,	NULL),
(166,	'GOUDOUMARIA',	NULL,	NULL,	NULL,	37,	4,	NULL,	NULL),
(167,	'DIFFA',	NULL,	NULL,	NULL,	36,	4,	NULL,	NULL),
(168,	'GUESKEROU',	NULL,	NULL,	NULL,	36,	4,	NULL,	NULL),
(169,	'TOUMOUR',	NULL,	NULL,	NULL,	38,	4,	NULL,	NULL),
(170,	'BOSSO',	NULL,	NULL,	NULL,	38,	4,	NULL,	NULL),
(175,	'EL ALLASSANE MAIREYREY',	NULL,	NULL,	NULL,	34,	4,	NULL,	NULL),
(176,	'GADABEDJI',	NULL,	NULL,	NULL,	41,	4,	NULL,	NULL),
(177,	'BERMO',	NULL,	NULL,	NULL,	41,	4,	NULL,	NULL),
(178,	'BIRNI LALLE',	NULL,	NULL,	NULL,	33,	4,	NULL,	NULL),
(179,	'ADJEKORIA',	NULL,	NULL,	NULL,	33,	4,	NULL,	NULL),
(180,	'KORAHANE',	NULL,	NULL,	NULL,	33,	4,	NULL,	NULL),
(181,	'TAGRISS',	NULL,	NULL,	NULL,	33,	4,	NULL,	NULL),
(182,	'GUIDAN AMOUMOUNE',	NULL,	NULL,	NULL,	34,	4,	NULL,	NULL),
(183,	'TCHAKE',	NULL,	NULL,	NULL,	34,	4,	NULL,	NULL),
(184,	'ROUMBOU I',	NULL,	NULL,	NULL,	33,	4,	NULL,	NULL),
(185,	'DAKORO',	NULL,	NULL,	NULL,	33,	4,	NULL,	NULL),
(186,	'AZAGOR',	NULL,	NULL,	NULL,	33,	4,	NULL,	NULL),
(187,	'BADER GOULA',	NULL,	NULL,	NULL,	33,	4,	NULL,	NULL),
(188,	'ARLIT',	NULL,	NULL,	NULL,	20,	4,	NULL,	NULL),
(189,	'ADERBISSINAT',	NULL,	NULL,	NULL,	42,	4,	NULL,	NULL),
(190,	'DABAGA',	NULL,	NULL,	NULL,	43,	4,	NULL,	NULL),
(191,	'TCHIROZERINE',	NULL,	NULL,	NULL,	43,	4,	NULL,	NULL),
(192,	'TABELOT',	NULL,	NULL,	NULL,	43,	4,	NULL,	NULL),
(193,	'TIMIA',	NULL,	NULL,	NULL,	44,	4,	NULL,	NULL),
(194,	'AGADEZ',	NULL,	NULL,	NULL,	43,	4,	NULL,	NULL),
(195,	'IFEROUANE',	NULL,	NULL,	NULL,	44,	4,	NULL,	NULL),
(196,	'DIRKOU',	NULL,	NULL,	NULL,	45,	4,	NULL,	NULL),
(197,	'FACHI',	NULL,	NULL,	NULL,	45,	4,	NULL,	NULL),
(198,	'BILMA',	NULL,	NULL,	NULL,	45,	4,	NULL,	NULL),
(199,	'DJADO',	NULL,	NULL,	NULL,	45,	4,	NULL,	NULL),
(200,	'TILLABERI',	NULL,	NULL,	NULL,	1,	2,	NULL,	NULL),
(201,	'ZINDER',	NULL,	NULL,	NULL,	1,	2,	NULL,	NULL),
(202,	'SAY',	NULL,	NULL,	NULL,	200,	3,	NULL,	NULL),
(203,	'KOLLO',	NULL,	NULL,	NULL,	200,	3,	NULL,	NULL),
(204,	'GOTHEYE',	NULL,	NULL,	NULL,	200,	3,	NULL,	NULL),
(205,	'TERA',	NULL,	NULL,	NULL,	200,	3,	NULL,	NULL),
(206,	'BALLEYARA',	NULL,	NULL,	NULL,	200,	3,	NULL,	NULL),
(207,	'ABALA',	NULL,	NULL,	NULL,	200,	3,	NULL,	NULL),
(208,	'OUALLAM',	NULL,	NULL,	NULL,	200,	3,	NULL,	NULL),
(209,	'TILLABERI',	NULL,	NULL,	NULL,	200,	3,	NULL,	NULL),
(210,	'FILINGUE',	NULL,	NULL,	NULL,	200,	3,	NULL,	NULL),
(211,	'AYEROU',	NULL,	NULL,	NULL,	200,	3,	NULL,	NULL),
(212,	'BANIBANGOU',	NULL,	NULL,	NULL,	200,	3,	NULL,	NULL),
(213,	'BANKILARE',	NULL,	NULL,	NULL,	200,	3,	NULL,	NULL),
(214,	'KANTCHE',	NULL,	NULL,	NULL,	201,	3,	NULL,	NULL),
(215,	'MAGARIA',	NULL,	NULL,	NULL,	201,	3,	NULL,	NULL),
(216,	'MIRRIAH',	NULL,	NULL,	NULL,	201,	3,	NULL,	NULL),
(217,	'TAKEITA',	NULL,	NULL,	NULL,	201,	3,	NULL,	NULL),
(218,	'GOURE',	NULL,	NULL,	NULL,	201,	3,	NULL,	NULL),
(219,	'DUNGASS',	NULL,	NULL,	NULL,	201,	3,	NULL,	NULL),
(220,	'DAMAGARAM TAKAYA',	NULL,	NULL,	NULL,	201,	3,	NULL,	NULL),
(221,	'BELBEDJI',	NULL,	NULL,	NULL,	201,	3,	NULL,	NULL),
(222,	'TANOUT',	NULL,	NULL,	NULL,	201,	3,	NULL,	NULL),
(223,	'TESKER',	NULL,	NULL,	NULL,	201,	3,	NULL,	NULL),
(224,	'TILLIA',	NULL,	NULL,	NULL,	5,	3,	NULL,	NULL),
(225,	'TCHINTABARADEN',	NULL,	NULL,	NULL,	5,	3,	NULL,	NULL),
(226,	'TASSARA',	NULL,	NULL,	NULL,	5,	3,	NULL,	NULL),
(227,	'ZINDER VILLE',	NULL,	NULL,	NULL,	201,	3,	NULL,	NULL),
(228,	'TAHOUA VILLE',	NULL,	NULL,	NULL,	5,	3,	NULL,	NULL),
(229,	'TORODI',	NULL,	NULL,	NULL,	200,	3,	NULL,	NULL),
(230,	'SAY',	NULL,	NULL,	NULL,	202,	4,	NULL,	NULL),
(231,	'TAMOU',	NULL,	NULL,	NULL,	202,	4,	NULL,	NULL),
(232,	'OURO GUELADJO',	NULL,	NULL,	NULL,	202,	4,	NULL,	NULL),
(233,	'KIRTACHI',	NULL,	NULL,	NULL,	203,	4,	NULL,	NULL),
(234,	'DARGOL',	NULL,	NULL,	NULL,	204,	4,	NULL,	NULL),
(235,	'NAMARO',	NULL,	NULL,	NULL,	203,	4,	NULL,	NULL),
(236,	'DIAGOUROU',	NULL,	NULL,	NULL,	205,	4,	NULL,	NULL),
(237,	'GOTHEYE',	NULL,	NULL,	NULL,	204,	4,	NULL,	NULL),
(238,	'KOURE',	NULL,	NULL,	NULL,	203,	4,	NULL,	NULL),
(239,	'KOLLO',	NULL,	NULL,	NULL,	203,	4,	NULL,	NULL),
(240,	'DIANTCHANDOU',	NULL,	NULL,	NULL,	203,	4,	NULL,	NULL),
(241,	'TAGAZAR',	NULL,	NULL,	NULL,	206,	4,	NULL,	NULL),
(242,	'ABALA',	NULL,	NULL,	NULL,	207,	4,	NULL,	NULL),
(243,	'SIMIRI',	NULL,	NULL,	NULL,	208,	4,	NULL,	NULL),
(244,	'KOKOROU',	NULL,	NULL,	NULL,	205,	4,	NULL,	NULL),
(245,	'TERA',	NULL,	NULL,	NULL,	205,	4,	NULL,	NULL),
(246,	'KOURTEYE',	NULL,	NULL,	NULL,	209,	4,	NULL,	NULL),
(247,	'SAKOIRA',	NULL,	NULL,	NULL,	209,	4,	NULL,	NULL),
(248,	'OUALLAM',	NULL,	NULL,	NULL,	208,	4,	NULL,	NULL),
(249,	'TILLABERI',	NULL,	NULL,	NULL,	209,	4,	NULL,	NULL),
(250,	'IMANAN',	NULL,	NULL,	NULL,	210,	4,	NULL,	NULL),
(251,	'TONDIKANDIA',	NULL,	NULL,	NULL,	210,	4,	NULL,	NULL),
(252,	'KOURFEYE CENTRE',	NULL,	NULL,	NULL,	210,	4,	NULL,	NULL),
(253,	'DINGAZI',	NULL,	NULL,	NULL,	208,	4,	NULL,	NULL),
(254,	'FILINGUE',	NULL,	NULL,	NULL,	210,	4,	NULL,	NULL),
(255,	'DESSA',	NULL,	NULL,	NULL,	209,	4,	NULL,	NULL),
(256,	'MEHANA',	NULL,	NULL,	NULL,	205,	4,	NULL,	NULL),
(257,	'SINDER',	NULL,	NULL,	NULL,	209,	4,	NULL,	NULL),
(258,	'ANZOUROU',	NULL,	NULL,	NULL,	209,	4,	NULL,	NULL),
(259,	'AYEROU',	NULL,	NULL,	NULL,	211,	4,	NULL,	NULL),
(260,	'INATES',	NULL,	NULL,	NULL,	211,	4,	NULL,	NULL),
(261,	'TONDIKIWINDI',	NULL,	NULL,	NULL,	208,	4,	NULL,	NULL),
(262,	'BIBIYERGOU',	NULL,	NULL,	NULL,	209,	4,	NULL,	NULL),
(263,	'BANIBANGOU',	NULL,	NULL,	NULL,	212,	4,	NULL,	NULL),
(264,	'KARMA',	NULL,	NULL,	NULL,	203,	4,	NULL,	NULL),
(265,	'HAMDALLAYE',	NULL,	NULL,	NULL,	203,	4,	NULL,	NULL),
(267,	'BITINKODJI',	NULL,	NULL,	NULL,	203,	4,	NULL,	NULL),
(268,	'YOURI',	NULL,	NULL,	NULL,	203,	4,	NULL,	NULL),
(269,	'LIBORE',	NULL,	NULL,	NULL,	203,	4,	NULL,	NULL),
(270,	'GOROUOL',	NULL,	NULL,	NULL,	205,	4,	NULL,	NULL),
(271,	'BANKILARE',	NULL,	NULL,	NULL,	213,	4,	NULL,	NULL),
(272,	'MATAMEY',	NULL,	NULL,	NULL,	214,	4,	NULL,	NULL),
(273,	'MAGARIA',	NULL,	NULL,	NULL,	215,	4,	NULL,	NULL),
(274,	'DROUM',	NULL,	NULL,	NULL,	216,	4,	NULL,	NULL),
(275,	'DAN BARTO',	NULL,	NULL,	NULL,	214,	4,	NULL,	NULL),
(276,	'SASSOUMBROUM',	NULL,	NULL,	NULL,	215,	4,	NULL,	NULL),
(277,	'YEKOUA',	NULL,	NULL,	NULL,	215,	4,	NULL,	NULL),
(278,	'KWAYA',	NULL,	NULL,	NULL,	215,	4,	NULL,	NULL),
(279,	'DAOUCHE',	NULL,	NULL,	NULL,	214,	4,	NULL,	NULL),
(280,	'TSAOUNI',	NULL,	NULL,	NULL,	214,	4,	NULL,	NULL),
(281,	'YAOURI',	NULL,	NULL,	NULL,	214,	4,	NULL,	NULL),
(282,	'KOURNI',	NULL,	NULL,	NULL,	214,	4,	NULL,	NULL),
(283,	'DOUNGOU',	NULL,	NULL,	NULL,	214,	4,	NULL,	NULL),
(284,	'ICHIRNAWA',	NULL,	NULL,	NULL,	214,	4,	NULL,	NULL),
(285,	'GARAGOUMSA',	NULL,	NULL,	NULL,	217,	4,	NULL,	NULL),
(286,	'TIRMINI',	NULL,	NULL,	NULL,	217,	4,	NULL,	NULL),
(287,	'BOUNE',	NULL,	NULL,	NULL,	218,	4,	NULL,	NULL),
(288,	'BANDE',	NULL,	NULL,	NULL,	215,	4,	NULL,	NULL),
(289,	'DOGO-DOGO',	NULL,	NULL,	NULL,	219,	4,	NULL,	NULL),
(290,	'DANTCHIAO',	NULL,	NULL,	NULL,	215,	4,	NULL,	NULL),
(291,	'DUNGASS',	NULL,	NULL,	NULL,	219,	4,	NULL,	NULL),
(292,	'MALAWA',	NULL,	NULL,	NULL,	219,	4,	NULL,	NULL),
(293,	'WACHA',	NULL,	NULL,	NULL,	215,	4,	NULL,	NULL),
(294,	'DOGO',	NULL,	NULL,	NULL,	216,	4,	NULL,	NULL),
(295,	'GOUNA',	NULL,	NULL,	NULL,	216,	4,	NULL,	NULL),
(296,	'GOUCHI',	NULL,	NULL,	NULL,	219,	4,	NULL,	NULL),
(297,	'GUIDIGUIR',	NULL,	NULL,	NULL,	218,	4,	NULL,	NULL),
(298,	'KELLE',	NULL,	NULL,	NULL,	218,	4,	NULL,	NULL),
(299,	'GAFFATI',	NULL,	NULL,	NULL,	216,	4,	NULL,	NULL),
(300,	'HAMDARA',	NULL,	NULL,	NULL,	216,	4,	NULL,	NULL),
(301,	'KOLLERAM',	NULL,	NULL,	NULL,	216,	4,	NULL,	NULL),
(302,	'MIRRIAH',	NULL,	NULL,	NULL,	216,	4,	NULL,	NULL),
(303,	'ZERMOU',	NULL,	NULL,	NULL,	216,	4,	NULL,	NULL),
(304,	'GOURE',	NULL,	NULL,	NULL,	218,	4,	NULL,	NULL),
(305,	'GUIDIMOUNI',	NULL,	NULL,	NULL,	220,	4,	NULL,	NULL),
(306,	'ALBARKARAM',	NULL,	NULL,	NULL,	220,	4,	NULL,	NULL),
(307,	'DAKOUSSA',	NULL,	NULL,	NULL,	217,	4,	NULL,	NULL),
(308,	'WAME',	NULL,	NULL,	NULL,	220,	4,	NULL,	NULL),
(309,	'DAMAGARAM TAKAYA',	NULL,	NULL,	NULL,	220,	4,	NULL,	NULL),
(310,	'MAZAMNI',	NULL,	NULL,	NULL,	220,	4,	NULL,	NULL),
(311,	'MOA',	NULL,	NULL,	NULL,	220,	4,	NULL,	NULL),
(312,	'TARKA',	NULL,	NULL,	NULL,	221,	4,	NULL,	NULL),
(313,	'TANOUT',	NULL,	NULL,	NULL,	222,	4,	NULL,	NULL),
(314,	'FALENKO',	NULL,	NULL,	NULL,	222,	4,	NULL,	NULL),
(315,	'OLLELEWA',	NULL,	NULL,	NULL,	222,	4,	NULL,	NULL),
(316,	'TENHYA',	NULL,	NULL,	NULL,	222,	4,	NULL,	NULL),
(317,	'GANGARA (TANOUT)',	NULL,	NULL,	NULL,	222,	4,	NULL,	NULL),
(318,	'GAMOU',	NULL,	NULL,	NULL,	218,	4,	NULL,	NULL),
(319,	'TESKER',	NULL,	NULL,	NULL,	223,	4,	NULL,	NULL),
(320,	'ALAKOSS',	NULL,	NULL,	NULL,	218,	4,	NULL,	NULL),
(321,	'KANTCHE',	NULL,	NULL,	NULL,	214,	4,	NULL,	NULL),
(322,	'KALFOU',	NULL,	NULL,	NULL,	11,	4,	NULL,	NULL),
(323,	'TILLIA',	NULL,	NULL,	NULL,	224,	4,	NULL,	NULL),
(324,	'TEBARAM',	NULL,	NULL,	NULL,	11,	4,	NULL,	NULL),
(325,	'TCHINTABARADEN',	NULL,	NULL,	NULL,	225,	4,	NULL,	NULL),
(326,	'TASSARA',	NULL,	NULL,	NULL,	226,	4,	NULL,	NULL),
(327,	'KAO',	NULL,	NULL,	NULL,	225,	4,	NULL,	NULL),
(328,	'TAKANAMAT',	NULL,	NULL,	NULL,	11,	4,	NULL,	NULL),
(329,	'PARC W',	NULL,	NULL,	NULL,	202,	4,	NULL,	NULL),
(330,	'ZINDER I,II,III,IV,V',	NULL,	NULL,	NULL,	227,	4,	NULL,	NULL),
(331,	'TAHOUA I,II',	NULL,	NULL,	NULL,	228,	4,	NULL,	NULL),
(332,	'TORODI',	NULL,	NULL,	NULL,	229,	4,	NULL,	NULL),
(333,	'MAKALONDI',	NULL,	NULL,	NULL,	229,	4,	NULL,	NULL);

CREATE TABLE indicateurs
(
    id BIGSERIAL,
    code character varying(255),
    intitule character varying(255) NOT NULL,
	type_indicateur_id bigint DEFAULT 1,
    definition character varying(255),
    donnees_requises character varying(255),
    methode_calcul character varying(255),
    methode_collecte character varying(255),
    source character varying(255),
    commentaire_limite character varying(255),
    niveau_desagregation character varying(255),
    periodicite character varying(255),
    unite character varying(255),
    echelle character varying(255),
    lien_avec_cadre_developpement character varying(255),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT indicateurs_pkey PRIMARY KEY (id),
    CONSTRAINT intitule_unique UNIQUE (intitule),
	CONSTRAINT indicateur_type_indicateur_id_fkey FOREIGN KEY (type_indicateur_id)
        REFERENCES type_indicateurs (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE type_cadre_developpements
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT type_cadre_developpements_pkey PRIMARY KEY (id),
    CONSTRAINT type_cadre_developpements_intitule_unique UNIQUE (intitule)
);
INSERT INTO type_cadre_developpements (intitule) VALUES
('cadre de développement'),
('projet et programme');

CREATE TABLE cadre_developpements
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    structure_responsable character varying(255),
    annee_debut integer,
    annee_fin integer,
    description text,
    cadre_developpement_id bigint,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    type_cadre_developpement_id bigint DEFAULT 1,
    CONSTRAINT cadre_developpements_pkey PRIMARY KEY (id),
	CONSTRAINT cadre_developpements_type_cadre_developpement_id_fkey FOREIGN KEY (type_cadre_developpement_id)
        REFERENCES type_cadre_developpements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE cadre_logiques
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    niveau integer,
    cadre_logique_id bigint,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT cadre_logiques_pkey PRIMARY KEY (id)
);
CREATE TABLE orientation_cadre_developpements
(
    id BIGSERIAL,
    intitule character varying(255),
    cadre_developpement_id bigint NOT NULL,
    cadre_logique_id bigint NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT orientation_cadre_developpements_pkey PRIMARY KEY (id),
	CONSTRAINT orientation_cadre_developpements_cadre_developpement_id_fkey FOREIGN KEY (cadre_developpement_id)
        REFERENCES cadre_developpements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT orientation_cadre_developpements_cadre_logique_id_fkey FOREIGN KEY (cadre_logique_id)
        REFERENCES cadre_logiques (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE

);
CREATE TABLE cadre_mesure_resultats
(
	id BIGSERIAL,
    indicateur_id bigint NOT NULL,
    cadre_logique_id bigint NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT cadre_mesure_resultats_pkey PRIMARY KEY (id),
    CONSTRAINT cadre_mesure_resultat_unique UNIQUE (indicateur_id, cadre_logique_id),
    CONSTRAINT cadre_mesure_resultat_cadre_logique_fkey FOREIGN KEY (cadre_logique_id)
        REFERENCES cadre_logiques (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT cadre_mesure_resultat_indicateur_fkey FOREIGN KEY (indicateur_id)
        REFERENCES indicateurs (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE alignement_strategiques
(
    id BIGSERIAL,
    cadre_developpement_id bigint NOT NULL,
    cadre_logique_id bigint NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT alignement_strategiques_pkey PRIMARY KEY (cadre_developpement_id, cadre_logique_id),
    CONSTRAINT alignement_strategiques_unique UNIQUE (id),
	CONSTRAINT alignement_strategiques_cadre_developpement_id_fkey FOREIGN KEY (cadre_developpement_id)
        REFERENCES cadre_developpements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT alignement_strategiques_cadre_logique_id_fkey FOREIGN KEY (cadre_logique_id)
        REFERENCES cadre_logiques (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE hypothese_risques
(
    id BIGSERIAL,
    cadre_logique_id integer NOT NULL,
    hypothese text,
    risque text,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT hypothese_risques_pkey PRIMARY KEY (id),
    CONSTRAINT hypothese_risque_cadre_logique_fkey FOREIGN KEY (cadre_logique_id)
        REFERENCES cadre_logiques (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE desagregations
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    type_desagregation_id bigint NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT desagregations_pkey PRIMARY KEY (id),
    CONSTRAINT desagregations_intitule_unique UNIQUE (intitule),
	CONSTRAINT desagregations_type_desagregation_fkey FOREIGN KEY (type_desagregation_id)
        REFERENCES type_desagregations (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
INSERT INTO desagregations (intitule, type_desagregation_id) VALUES
('Femme',	1),
('Homme',	1),
('Urbain',	2),
('Rural',	2),
('Total',	3);

CREATE TABLE desagregation_indicateur
(
    id BIGSERIAL,
    desagregation_id bigint NOT NULL,
    indicateur_id bigint NOT NULL,
    CONSTRAINT desagregation_indicateur_pkey PRIMARY KEY (id),
    CONSTRAINT desagregation_indicateur_unique UNIQUE (desagregation_id, indicateur_id),
    CONSTRAINT desagregation_fkey FOREIGN KEY (desagregation_id)
        REFERENCES desagregations (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT indicateur_fkey FOREIGN KEY (indicateur_id)
        REFERENCES indicateurs (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE donnee_indicateurs
(
    id BIGSERIAL,
    nature_donnee_id bigint NOT NULL,
    indicateur_id bigint NOT NULL,
    zone_id bigint NOT NULL,
    periode_id bigint NOT NULL,
    source_indicateur_id bigint NOT NULL,
    unite_indicateur_id bigint NOT NULL,
    commentaire_valeur_indicateur_id bigint NOT NULL,
    valeur double precision NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT donnee_indicateur_pkey PRIMARY KEY (nature_donnee_id, indicateur_id, zone_id, periode_id, source_indicateur_id, unite_indicateur_id, commentaire_valeur_indicateur_id),
    CONSTRAINT donnee_indicateurs_id_unique UNIQUE (id),
    CONSTRAINT donnee_indicateurs_nature_donnee_fkey FOREIGN KEY (nature_donnee_id)
        REFERENCES nature_donnees (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT donnee_indicateurs_indicateur_fkey FOREIGN KEY (indicateur_id)
        REFERENCES indicateurs (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	CONSTRAINT donnee_indicateurs_zone_fkey FOREIGN KEY (zone_id)
        REFERENCES zones (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	CONSTRAINT donnee_indicateurs_periode_fkey FOREIGN KEY (periode_id)
        REFERENCES periodes (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT donnee_indicateurs_source_fkey FOREIGN KEY (source_indicateur_id)
        REFERENCES source_indicateurs (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT donnee_indicateurs_unite_fkey FOREIGN KEY (unite_indicateur_id)
        REFERENCES unite_indicateurs (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT donnee_indicateurs_commentaire_fkey FOREIGN KEY (commentaire_valeur_indicateur_id)
        REFERENCES commentaire_valeur_indicateurs (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE donnee_indicateur_desagregation
(
    id BIGSERIAL,
    donnee_indicateur_id bigint NOT NULL,
    desagregation_id bigint NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT donnee_indicateur_desagregation_pkey PRIMARY KEY (donnee_indicateur_id, desagregation_id),
    CONSTRAINT donnee_indicateur_desagregation_unique UNIQUE (id),
	CONSTRAINT did_desagregation_fkey FOREIGN KEY (desagregation_id)
        REFERENCES desagregations (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT did_donnee_indicateur_fkey FOREIGN KEY (donnee_indicateur_id)
        REFERENCES donnee_indicateurs (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);



CREATE TABLE activites (
    id BIGSERIAL,
    cadre_logique_id bigint NOT NULL,
    intitule character varying(255) NOT NULL,
    annee_debut_prevu integer,
    annee_fin_prevu integer,
    duree_travaux integer,
    cout_prevu integer,
    responsable character varying(255),
    contact_responsable character varying(255),
    statut_activite_id bigint,
    description character varying(255),
    date_debut_realisation date,
    date_fin_realisation date,
    cout_realisation integer,
    latitude double precision,
    longitude double precision,
    activite_id bigint,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    type_activite_id bigint,
	CONSTRAINT activites_pkey PRIMARY KEY (id),
    CONSTRAINT activites_cadre_logique_fkey FOREIGN KEY (cadre_logique_id)
        REFERENCES cadre_logiques (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT activites_statut_activite_fkey FOREIGN KEY (statut_activite_id)
        REFERENCES statut_activites (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT activites_type_activite_fkey FOREIGN KEY (type_activite_id)
        REFERENCES type_activites (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE activite_zone (
    id BIGSERIAL,
    activite_id bigint NOT NULL,
    zone_id bigint NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT activite_zone_pkey PRIMARY KEY (activite_id, zone_id),
	CONSTRAINT activite_zone_unique UNIQUE (id),
	CONSTRAINT activite_zone_activite_id_fkey FOREIGN KEY (activite_id)
        REFERENCES activites (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT activite_zone_zone_id_fkey FOREIGN KEY (zone_id)
        REFERENCES zones (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE piece_jointe_activites
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    fichier character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    activite_id bigint,
    CONSTRAINT piece_jointe_activites_pkey PRIMARY KEY (id),
    CONSTRAINT piece_jointes_activite_fkey FOREIGN KEY (activite_id)
        REFERENCES activites (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE piece_jointes
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    fichier character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    cadre_developpement_id bigint,
    CONSTRAINT piece_jointes_pkey PRIMARY KEY (id),
    CONSTRAINT fk_piece_jointes_cadre FOREIGN KEY (cadre_developpement_id)
        REFERENCES cadre_developpements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE produits
(
    id BIGSERIAL,
    cadre_logique_id bigint NOT NULL,
    intitule character varying(255) NOT NULL,
    annee_debut_prevu integer,
    annee_fin_prevu integer,
    duree_travaux integer,
    cout_prevu integer,
    responsable character varying(255),
    contact_responsable character varying(255),
    statut_produit_id bigint,
    description character varying(255),
    date_debut_realisation date,
    date_fin_realisation date,
    cout_realisation integer,
    latitude double precision,
    longitude double precision,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    type_produit_id bigint,
    CONSTRAINT produits_pkey PRIMARY KEY (id),
    CONSTRAINT produits_cadre_logique_fkey FOREIGN KEY (cadre_logique_id)
        REFERENCES cadre_logiques (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT produits_statut_produit_fkey FOREIGN KEY (statut_produit_id)
        REFERENCES statut_produits (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT produits_type_produit_fkey FOREIGN KEY (type_produit_id)
        REFERENCES type_produits (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
CREATE TABLE produit_zone
(
    id BIGSERIAL,
    produit_id bigint NOT NULL,
    zone_id bigint NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT produit_zone_pkey PRIMARY KEY (produit_id, zone_id),
    CONSTRAINT produit_zone_unique UNIQUE (id),
	CONSTRAINT produit_zone_produit_id_fkey FOREIGN KEY (produit_id)
        REFERENCES produits (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT produit_zone_zone_id_fkey FOREIGN KEY (zone_id)
        REFERENCES zones (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
CREATE TABLE piece_jointe_produits
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    fichier character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    produit_id bigint,
    CONSTRAINT piece_jointe_produits_pkey PRIMARY KEY (id),
    CONSTRAINT piece_jointes_produit_fkey FOREIGN KEY (produit_id)
        REFERENCES produits (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE projets
(
    id BIGSERIAL,
    sigle character varying(255) NOT NULL,
    intitule character varying(255) NOT NULL,
    priorite_id bigint,
    institution_tutelle_id bigint,
    direction_agence character varying(255),
    contact character varying(255),
    cout double precision,
    annee_demarrage integer,
    date_debut_prevue date,
    date_fin_prevue date,
    duree integer,
    statut_projet_id bigint,
    date_debut_effective date,
    date_fin_effective date,
    projet_id bigint,
    cadre_developpement_id bigint,
    date_approbation date,
    date_signature date,
    date_mise_en_vigueur date,
    date_demarrage_effectif date,
    partenaires text,
    periode_prorogation text,
    duree_prorogation text,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT projets_pkey PRIMARY KEY (id),
	CONSTRAINT projets_priorite_fkey FOREIGN KEY (priorite_id)
        REFERENCES priorites (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	CONSTRAINT projets_institution_tutelle_fkey FOREIGN KEY (institution_tutelle_id)
        REFERENCES institution_tutelles (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	CONSTRAINT projets_statut_projet_fkey FOREIGN KEY (statut_projet_id)
        REFERENCES statut_projets (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	CONSTRAINT projets_cadre_developpement_fkey FOREIGN KEY (cadre_developpement_id)
        REFERENCES cadre_developpements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
CREATE TABLE piece_jointe_projets
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    fichier character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    projet_id bigint,
    CONSTRAINT piece_jointe_projets_pkey PRIMARY KEY (id),
    CONSTRAINT piece_jointes_projet_fkey FOREIGN KEY (projet_id)
        REFERENCES projets (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
CREATE TABLE projet_zone
(
    id BIGSERIAL,
    projet_id bigint NOT NULL,
    zone_id bigint NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT projet_zone_pkey PRIMARY KEY (projet_id, zone_id),
    CONSTRAINT projet_zone_unique UNIQUE (id),
	CONSTRAINT projet_zone_projet_id_fkey FOREIGN KEY (projet_id)
        REFERENCES projets (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT projet_zone_zone_id_fkey FOREIGN KEY (zone_id)
        REFERENCES zones (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE projet_cadre_logique
(
    id BIGSERIAL,
    projet_id bigint NOT NULL,
    cadre_logique_id bigint NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT projet_cadre_logique_pkey PRIMARY KEY (projet_id, cadre_logique_id),
    CONSTRAINT projet_cadre_logique_unique UNIQUE (id),
	CONSTRAINT projet_cadre_logique_cadre_logique_id_fkey FOREIGN KEY (cadre_logique_id)
        REFERENCES cadre_logiques (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT projet_cadre_logique_projet_id_fkey FOREIGN KEY (projet_id)
        REFERENCES projets (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
CREATE TABLE projet_etude_disponible
(
    id BIGSERIAL,
    projet_id bigint NOT NULL,
    etude_id bigint NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    fichier character varying(255) NOT NULL,
    CONSTRAINT projet_etude_disponible_pkey PRIMARY KEY (projet_id, etude_id),
    CONSTRAINT projet_etude_disponible_unique UNIQUE (id),
	CONSTRAINT projet_etude_disponible_projet_id_fkey FOREIGN KEY (projet_id)
        REFERENCES projets (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT projet_etude_disponible_etude_id_fkey FOREIGN KEY (etude_id)
        REFERENCES etudes (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE projet_etude_envisagee
(
    id BIGSERIAL,
    projet_id bigint NOT NULL,
    etude_id bigint NOT NULL,
    source_financement_id bigint NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT projet_etude_envisagee_pkey PRIMARY KEY (projet_id, etude_id),
    CONSTRAINT projet_etude_envisagee_unique UNIQUE (id),
	CONSTRAINT projet_etude_envisagee_projet_id_fkey FOREIGN KEY (projet_id)
        REFERENCES projets (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT projet_etude_envisagee_etude_id_fkey FOREIGN KEY (etude_id)
        REFERENCES etudes (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	CONSTRAINT projet_etude_envisagee_source_financement_id_fkey FOREIGN KEY (source_financement_id)
        REFERENCES source_financements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE recherche_financements
(
    id BIGSERIAL,
    projet_id bigint NOT NULL,
    source_financement_id bigint NOT NULL,
    bailleur_id bigint,
    statut_financement_id bigint,
    nature_financement_id bigint,
    montant numeric(15,2),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT recherche_financement_pkey PRIMARY KEY (id),
    CONSTRAINT recherche_financement_nature_financement_id_fkey FOREIGN KEY (nature_financement_id)
        REFERENCES nature_financements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT recherche_financement_projet_id_fkey FOREIGN KEY (projet_id)
        REFERENCES projets (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT recherche_financement_bailleur_id_fkey FOREIGN KEY (bailleur_id)
        REFERENCES bailleurs (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT recherche_financement_source_financement_id_fkey FOREIGN KEY (source_financement_id)
        REFERENCES source_financements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT recherche_financement_statut_financement_id_fkey FOREIGN KEY (statut_financement_id)
        REFERENCES statut_financements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE composantes
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    composante_id bigint,
	projet_id bigint,
    niveau integer,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT composantes_pkey PRIMARY KEY (id),
	CONSTRAINT composante_projet_id_fkey FOREIGN KEY (projet_id)
        REFERENCES projets (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
CREATE TABLE composante_produits
(
	id BIGSERIAL,
    indicateur_id bigint NOT NULL,
    composante_id bigint NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT composante_produits_pkey PRIMARY KEY (id),
    CONSTRAINT composante_produit_unique UNIQUE (indicateur_id, composante_id),
    CONSTRAINT composante_produit_composante_fkey FOREIGN KEY (composante_id)
        REFERENCES composantes (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT composante_produit_indicateur_fkey FOREIGN KEY (indicateur_id)
        REFERENCES indicateurs (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE plan_financements
(
    id BIGSERIAL,
    projet_id bigint NOT NULL,
	composante_id bigint,
    source_financement_id bigint,
    bailleur_id bigint,
    statut_financement_id bigint,
    nature_financement_id bigint,
    montant numeric(15,2),
	categorie_depense_id bigint,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT plan_financement_pkey PRIMARY KEY (id),
    CONSTRAINT plan_financement_nature_financement_id_fkey FOREIGN KEY (nature_financement_id)
        REFERENCES nature_financements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT plan_financement_projet_id_fkey FOREIGN KEY (projet_id)
        REFERENCES projets (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	CONSTRAINT plan_financement_composante_id_fkey FOREIGN KEY (composante_id)
        REFERENCES composantes (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT plan_financement_bailleur_id_fkey FOREIGN KEY (bailleur_id)
        REFERENCES bailleurs (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT plan_financement_source_financement_id_fkey FOREIGN KEY (source_financement_id)
        REFERENCES source_financements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT plan_financement_statut_financement_id_fkey FOREIGN KEY (statut_financement_id)
        REFERENCES statut_financements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	CONSTRAINT plan_financement_categorie_depense_id_fkey FOREIGN KEY (categorie_depense_id)
        REFERENCES categorie_depenses (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE budget_annuel_prevus
(
    id BIGSERIAL,
    plan_financement_id bigint NOT NULL,
    annee int NOT NULL,
	categorie_depense_id bigint,
    montant numeric(15,2),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT budget_annuel_prevu_pkey PRIMARY KEY (id),
    CONSTRAINT budget_annuel_prevu_plan_financement_id_fkey FOREIGN KEY (plan_financement_id)
        REFERENCES plan_financements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	CONSTRAINT budget_annuel_prevu_categorie_depense_id_fkey FOREIGN KEY (categorie_depense_id)
        REFERENCES categorie_depenses (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE budget_annuel_depenses
(
    id BIGSERIAL,
    plan_financement_id bigint NOT NULL,
    annee int NOT NULL,
	categorie_depense_id bigint,
    montant numeric(15,2),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT budget_annuel_depense_pkey PRIMARY KEY (id),
    CONSTRAINT budget_annuel_depense_plan_financement_id_fkey FOREIGN KEY (plan_financement_id)
        REFERENCES plan_financements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	CONSTRAINT budget_annuel_depense_categorie_depense_id_fkey FOREIGN KEY (categorie_depense_id)
        REFERENCES categorie_depenses (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE budget_annuels
(
    id BIGSERIAL,
    plan_financement_id bigint NOT NULL,
    annee int NOT NULL,
	categorie_depense_id bigint,
    montant numeric(15,2),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT budget_annuel_pkey PRIMARY KEY (id),
    CONSTRAINT budget_annuel_plan_financement_id_fkey FOREIGN KEY (plan_financement_id)
        REFERENCES plan_financements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	CONSTRAINT budget_annuel_categorie_depense_id_fkey FOREIGN KEY (categorie_depense_id)
        REFERENCES categorie_depenses (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);


CREATE TABLE projet_population_cible
(
    id BIGSERIAL,
    projet_id bigint NOT NULL,
    population_cible_id bigint NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    effectif bigint,
    CONSTRAINT projet_population_cible_pkey PRIMARY KEY (id),
	CONSTRAINT projet_population_cible_projet_id_fkey FOREIGN KEY (projet_id)
        REFERENCES projets (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT projet_population_population_cible_id_fkey FOREIGN KEY (population_cible_id)
        REFERENCES population_cibles (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE users
(
    id BIGSERIAL,
    name character varying(255)  NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp DEFAULT CURRENT_TIMESTAMP,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT users_pkey PRIMARY KEY (id),
    CONSTRAINT users_email_unique UNIQUE (email)
);
INSERT INTO users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES
(1,	'sysnise',	'dev@sysnise.ne',	NULL,	'$2y$12$zFB64bIUNXOLyTfE1qlkauOz30d6DnvcoXhBN0b//IqeVD7cb.X7W',	NULL,	NULL,	NULL);

CREATE TABLE roles
(
    id BIGSERIAL,
    name character varying(255) NOT NULL,
    label character varying(255),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT roles_pkey PRIMARY KEY (id),
    CONSTRAINT roles_name_unique UNIQUE (name)
);
INSERT INTO roles (id, name, label, created_at, updated_at) VALUES
(1,	'admin',	'admin',	NULL,	NULL);

CREATE TABLE role_user
(
    role_id bigint NOT NULL,
    user_id bigint NOT NULL,
    CONSTRAINT role_user_pkey PRIMARY KEY (role_id, user_id),
    CONSTRAINT role_user_role_id_foreign FOREIGN KEY (role_id)
        REFERENCES roles (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT role_user_user_id_foreign FOREIGN KEY (user_id)
        REFERENCES users (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
INSERT INTO role_user (role_id, user_id) VALUES
(1,	1);

CREATE TABLE permissions
(
    id BIGSERIAL,
    name character varying(255) NOT NULL,
    label character varying(255),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT permissions_pkey PRIMARY KEY (id),
    CONSTRAINT permissions_name_unique UNIQUE (name)
);
INSERT INTO permissions (id, name, label, created_at, updated_at) VALUES
(1,	'administration',	'administration',	NULL,	NULL);

CREATE TABLE permission_role
(
    permission_id bigint NOT NULL,
    role_id bigint NOT NULL,
    CONSTRAINT permission_role_pkey PRIMARY KEY (permission_id, role_id),
    CONSTRAINT permission_role_permission_id_foreign FOREIGN KEY (permission_id)
        REFERENCES permissions (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT permission_role_role_id_foreign FOREIGN KEY (role_id)
        REFERENCES roles (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE password_reset_tokens
(
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email)
);

CREATE TABLE sessions
(
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL,
    CONSTRAINT sessions_pkey PRIMARY KEY (id)
);

CREATE TABLE migrations
(
    id BIGSERIAL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL,
    CONSTRAINT migrations_pkey PRIMARY KEY (id)
);

CREATE TABLE jobs
(
    id BIGSERIAL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL,
    CONSTRAINT jobs_pkey PRIMARY KEY (id)
);

CREATE TABLE job_batches
(
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer,
    CONSTRAINT job_batches_pkey PRIMARY KEY (id)
);

CREATE TABLE failed_jobs
(
    id BIGSERIAL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT failed_jobs_pkey PRIMARY KEY (id),
    CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid)
);

CREATE TABLE cache
(
    key character varying(255),
    value text NOT NULL,
    expiration integer NOT NULL,
    CONSTRAINT cache_pkey PRIMARY KEY (key)
);

CREATE TABLE cache_locks
(
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL,
    CONSTRAINT cache_locks_pkey PRIMARY KEY (key)
);

CREATE OR REPLACE VIEW public.view_extraction_donnees
 AS
 SELECT di.id,
    di.nature_donnee_id,
    nd.intitule AS nature_donnee_intitule,
    di.indicateur_id,
    i.intitule AS indicateur_intitule,
    di.zone_id,
    z.intitule AS zone_intitule,
    di.source_indicateur_id,
    si.intitule AS source_indicateur_intitule,
    di.unite_indicateur_id,
    ui.intitule AS unite_indicateur_intitule,
    di.commentaire_valeur_indicateur_id,
    cvi.intitule AS commentaire_intitule,
    di.periode_id,
    p.intitule AS periode_intitule,
    di.valeur,
    string_agg(DISTINCT d.id::text, ', '::text) AS desagregation_ids,
    string_agg(DISTINCT d.intitule::text, ', '::text) AS desagregations
   FROM donnee_indicateurs di
     LEFT JOIN nature_donnees nd ON di.nature_donnee_id = nd.id
     LEFT JOIN indicateurs i ON di.indicateur_id = i.id
     LEFT JOIN zones z ON di.zone_id = z.id
     LEFT JOIN periodes p ON di.periode_id = p.id
     LEFT JOIN source_indicateurs si ON di.source_indicateur_id = si.id
     LEFT JOIN unite_indicateurs ui ON di.unite_indicateur_id = ui.id
     LEFT JOIN commentaire_valeur_indicateurs cvi ON di.commentaire_valeur_indicateur_id = cvi.id
     LEFT JOIN donnee_indicateur_desagregation did ON di.id = did.donnee_indicateur_id
     LEFT JOIN desagregations d ON did.desagregation_id = d.id
  GROUP BY di.id, di.nature_donnee_id, nd.intitule, di.indicateur_id, i.intitule, di.zone_id, z.intitule, di.source_indicateur_id, si.intitule, di.unite_indicateur_id, ui.intitule, di.commentaire_valeur_indicateur_id, cvi.intitule, di.periode_id, p.intitule, di.valeur
  ORDER BY i.intitule, z.intitule, p.intitule;

CREATE OR REPLACE VIEW public.view_cmr
 AS
 WITH RECURSIVE nodes AS (
         SELECT cd.id AS cadre_id,
            cd.intitule,
            NULL::bigint AS parent_id,
            1 AS niveau,
            cd.id AS cadre_developpement_id
           FROM cadre_developpements cd
        UNION ALL
         SELECT cl.id AS cadre_id,
            cl.intitule,
            ocd.cadre_developpement_id AS parent_id,
            2 AS niveau,
            ocd.cadre_developpement_id
           FROM orientation_cadre_developpements ocd
             JOIN cadre_logiques cl ON cl.id = ocd.cadre_logique_id
        UNION ALL
         SELECT cl_child.id AS cadre_id,
            cl_child.intitule,
            cl_child.cadre_logique_id AS parent_id,
            n_1.niveau + 1 AS niveau,
            n_1.cadre_developpement_id
           FROM cadre_logiques cl_child
             JOIN nodes n_1 ON cl_child.cadre_logique_id = n_1.cadre_id
        )
 SELECT n.cadre_developpement_id,
    n.cadre_id,
    n.intitule AS cadre_intitule,
    n.parent_id,
    n.niveau,
    i.id AS indicateur_id,
    i.intitule AS indicateur_intitule,
    di.valeur,
    z.intitule AS zone_intitule,
    u.intitule AS unite_intitule,
    s.intitule AS source_intitule,
    nd.intitule AS nature_donnee_intitule,
    p.intitule AS periode_intitule,
    string_agg(DISTINCT dsg.intitule::text, ', '::text) AS desagregations
   FROM nodes n
     LEFT JOIN cadre_mesure_resultats cmr ON cmr.cadre_logique_id = n.cadre_id
     LEFT JOIN indicateurs i ON i.id = cmr.indicateur_id
     LEFT JOIN donnee_indicateurs di ON di.indicateur_id = i.id
     LEFT JOIN zones z ON z.id = di.zone_id
     LEFT JOIN unite_indicateurs u ON u.id = di.unite_indicateur_id
     LEFT JOIN source_indicateurs s ON s.id = di.source_indicateur_id
     LEFT JOIN nature_donnees nd ON nd.id = di.nature_donnee_id
     LEFT JOIN periodes p ON p.id = di.periode_id
     LEFT JOIN donnee_indicateur_desagregation did ON did.donnee_indicateur_id = di.id
     LEFT JOIN desagregations dsg ON dsg.id = did.desagregation_id
  WHERE n.niveau >= 2
  GROUP BY n.cadre_developpement_id, n.cadre_id, n.intitule, n.parent_id, n.niveau, i.id, i.intitule, di.valeur, z.intitule, u.intitule, s.intitule, nd.intitule, p.intitule
  ORDER BY n.cadre_developpement_id, n.parent_id NULLS FIRST, n.cadre_id, i.id;

-----------------------Debut travaux alapriss
ALTER TABLE cadre_developpements
ADD COLUMN user_id BIGINT;

ALTER TABLE cadre_developpements
ADD CONSTRAINT fk_cadre_developpement_user
FOREIGN KEY (user_id)
REFERENCES users(id)
ON DELETE SET NULL;


ALTER TABLE projets
ADD COLUMN user_id BIGINT;

ALTER TABLE projets
ADD CONSTRAINT fk_projet_user
FOREIGN KEY (user_id)
REFERENCES users(id)
ON DELETE SET NULL;


ALTER TABLE nature_donnees
ADD COLUMN deleted_on timestamp null;


ALTER TABLE source_financements
ADD COLUMN deleted_on timestamp null;

ALTER TABLE type_desagregations
ADD COLUMN deleted_on timestamp null;

ALTER TABLE desagregations
ADD COLUMN deleted_on timestamp null;

ALTER TABLE periodes
ADD COLUMN deleted_on timestamp null;


ALTER TABLE unite_indicateurs
ADD COLUMN deleted_on timestamp null;

ALTER TABLE zones
ADD COLUMN deleted_on timestamp null;

ALTER TABLE statut_produits
ADD COLUMN deleted_on timestamp null;


ALTER TABLE type_produits
ADD COLUMN deleted_on timestamp null;

ALTER TABLE statut_activites
ADD COLUMN deleted_on timestamp null;

ALTER TABLE type_activites
ADD COLUMN deleted_on timestamp null;

ALTER TABLE commentaire_valeur_indicateurs
ADD COLUMN deleted_on timestamp null;

ALTER TABLE institution_tutelles
ADD COLUMN deleted_on timestamp null;

ALTER TABLE statut_projets
ADD COLUMN deleted_on timestamp null;

ALTER TABLE population_cibles
ADD COLUMN deleted_on timestamp null;

ALTER TABLE etudes
ADD COLUMN deleted_on timestamp null;

ALTER TABLE source_indicateurs
ADD COLUMN deleted_on timestamp null;

ALTER TABLE bailleurs
ADD COLUMN deleted_on timestamp null;

ALTER TABLE statut_financements
ADD COLUMN deleted_on timestamp null;

ALTER TABLE categorie_depenses
ADD COLUMN deleted_on timestamp null;

ALTER TABLE nature_financements
ADD COLUMN deleted_on timestamp null;



ALTER TABLE projets
ADD COLUMN deleted_on timestamp null;

ALTER TABLE donnee_indicateurs
ADD COLUMN statut character varying(50) null;

ALTER TABLE donnee_indicateurs
ADD COLUMN commentaire_rejet text null;

/* ------------- update 14/01/2026 abass ------------- */
CREATE TABLE devises
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT devises_pkey PRIMARY KEY (id),
    CONSTRAINT devises_intitule_unique UNIQUE (intitule)
);
INSERT INTO devises (intitule) VALUES
('USD'),
('EUR');

ALTER TABLE projets
ADD COLUMN cout_devise DOUBLE PRECISION,
ADD COLUMN devise_id BIGINT,
ADD CONSTRAINT projets_devise_fkey
FOREIGN KEY (devise_id)
REFERENCES devises (id)
MATCH SIMPLE
ON UPDATE CASCADE
ON DELETE CASCADE;

INSERT INTO population_cibles (intitule) VALUES
('Rurale Sédentaire'),
('Rurale Nomade'),
('Urbaine'),
('Totale');

ALTER TABLE budget_annuel
RENAME TO budget_annuels;

CREATE TABLE cloture_projets (
    id BIGSERIAL,
    projet_id BIGINT NOT NULL,
    cout_effectif DOUBLE PRECISION,
    date_debut_effectif DATE,
    date_fin_effectif DATE,
    duree_effectif INTEGER,
    rapport_achevement TEXT,
    conclusion_rapport_achevement TEXT,
    date_rapport_achevement DATE,
    rapport_cloture TEXT,
    conclusion_rapport_cloture TEXT,
    date_rapport_cloture DATE,
    date_fermeture_comptes DATE,
	reference_document_fermeture_comptes TEXT,
	created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT cloture_projets_pkey PRIMARY KEY (id),
    CONSTRAINT cloture_projets_projet_id_fkey 
        FOREIGN KEY (projet_id)
        REFERENCES projets (id)
        MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

/*----- la bonne view view_cadre_logique ------ */
CREATE OR REPLACE VIEW public.view_cadre_logique
 AS
 WITH RECURSIVE hierarchy AS (
         SELECT cl.id,
            cl.intitule,
            cl.cadre_logique_id AS parent_id,
            1 AS niveau
           FROM cadre_logiques cl
          WHERE (cl.id IN ( SELECT ocd.cadre_logique_id
                   FROM orientation_cadre_developpements ocd))
        UNION ALL
         SELECT child.id,
            child.intitule,
            child.cadre_logique_id AS parent_id,
            h.niveau + 1 AS niveau
           FROM cadre_logiques child
             JOIN hierarchy h ON child.cadre_logique_id = h.id
        )
 SELECT id,
    intitule,
    parent_id,
    niveau
   FROM hierarchy
  ORDER BY niveau, parent_id NULLS FIRST, id;

CREATE TABLE secteurs
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT secteurs_pkey PRIMARY KEY (id),
    CONSTRAINT secteurs_intitule_unique UNIQUE (intitule)
);
INSERT INTO secteurs (intitule) VALUES
('Agriculture');




-- 2026-01-16
ALTER TABLE users
ADD COLUMN institution_tutelle_id BIGINT;



ALTER TABLE users
ADD CONSTRAINT fk_institution_tutelle_id_user
FOREIGN KEY (institution_tutelle_id)
REFERENCES institution_tutelles(id)
ON DELETE SET NULL;



update users set institution_tutelle_id=1;

ALTER TABLE users ALTER COLUMN institution_tutelle_id SET NOT NULL;




ALTER TABLE cadre_developpements
ADD COLUMN institution_tutelle_id BIGINT;



ALTER TABLE cadre_developpements
ADD CONSTRAINT fk_institution_tutelle_id_cadre_developpements
FOREIGN KEY (institution_tutelle_id)
REFERENCES institution_tutelles(id)
ON DELETE SET NULL;



update cadre_developpements set institution_tutelle_id=1;

ALTER TABLE cadre_developpements ALTER COLUMN institution_tutelle_id SET NOT NULL;




ALTER TABLE projets
ADD COLUMN secteur_id BIGINT;



ALTER TABLE projets
ADD CONSTRAINT fk_projets_secteur
FOREIGN KEY (secteur_id)
REFERENCES secteurs(id)
ON DELETE SET NULL;



update projets set secteur_id=1;

ALTER TABLE projets ALTER COLUMN secteur_id SET NOT NULL;

<<<<<<< HEAD
-------------19/01/2026-----------
ALTER TABLE plan_financements
    ALTER COLUMN composante_id DROP NOT NULL,
    ALTER COLUMN source_financement_id DROP NOT NULL,
    ALTER COLUMN bailleur_id DROP NOT NULL,
    ALTER COLUMN statut_financement_id DROP NOT NULL,
    ALTER COLUMN nature_financement_id DROP NOT NULL,
    ALTER COLUMN categorie_depense_id DROP NOT NULL;

-------------------------------requete pour recupérer les produits (derniers noeud d'un cadre de resultat -------------
WITH RECURSIVE descendants AS (
    -- Nœud parent de départ
    SELECT 
        id,
        intitule,
        parent_id
    FROM view_cadre_logique
    WHERE id = :parent_id

    UNION ALL

    -- Récupération récursive des descendants
    SELECT 
        v.id,
        v.intitule,
        v.parent_id
    FROM view_cadre_logique v
    INNER JOIN descendants d
        ON v.parent_id = d.id
)
SELECT 
    d.id,
    d.intitule,
    d.parent_id
FROM descendants d
WHERE NOT EXISTS (
    SELECT 1
    FROM view_cadre_logique c
    WHERE c.parent_id = d.id
);

-----------------------function postgres getProduit
CREATE OR REPLACE FUNCTION get_produit_from_cmr(parent_node_id BIGINT)
RETURNS TABLE (
    id BIGINT,
    intitule VARCHAR,
    parent_id BIGINT
)
LANGUAGE sql
AS $$
WITH RECURSIVE descendants AS (
    SELECT
        id,
        intitule,
        parent_id
    FROM view_cadre_logique
    WHERE id = parent_node_id

    UNION ALL

    SELECT
        v.id,
        v.intitule,
        v.parent_id
    FROM view_cadre_logique v
    INNER JOIN descendants d
        ON v.parent_id = d.id
)
SELECT
    d.id,
    d.intitule,
    d.parent_id
FROM descendants d
WHERE NOT EXISTS (
    SELECT 1
    FROM view_cadre_logique c
    WHERE c.parent_id = d.id
);
$$;
=======



-- debut 29/01/26 par alapriss
-- DROP TABLE IF EXISTS public.cadre_developpement_institutions;

CREATE TABLE IF NOT EXISTS public.cadre_developpement_users
(
    id  bigserial,
    cadre_developpement bigint NOT NULL,
    userr bigint NOT NULL,
    user_id bigint NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT cadre_developpement_user_pkey PRIMARY KEY (id),
    CONSTRAINT cadre_developpement_user_cadre_developpement_user_key UNIQUE (cadre_developpement, userr),
    CONSTRAINT cadre_developpement_user_cadre_developpement_fkey FOREIGN KEY (cadre_developpement)
        REFERENCES public.cadre_developpements (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT cadre_developpement_user_user_fkey FOREIGN KEY (userr)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID,
    CONSTRAINT cadre_developpement_user_user_id_fkey FOREIGN KEY (user_id)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
)


CREATE TABLE IF NOT EXISTS public.projet_users
(
    id  bigserial,
    projet bigint NOT NULL,
    userr bigint NOT NULL,
    user_id bigint NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT projet_user_pkey PRIMARY KEY (id),
    CONSTRAINT projet_user_projet_user_key UNIQUE (projet, userr),
    CONSTRAINT projet_user_projet_fkey FOREIGN KEY (projet)
        REFERENCES public.projets (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT projet_user_user_fkey FOREIGN KEY (userr)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID,
    CONSTRAINT projet_user_user_id_fkey FOREIGN KEY (user_id)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
)


-- fin 29/01/26 par alapriss
>>>>>>> main

----------update abass 02/02/2026
DROP TABLE composante_indicateurs;
CREATE TABLE composante_produits
(
	id BIGSERIAL,
    produit_id bigint NOT NULL,
    composante_id bigint NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
	deleted_on timestamp null,
    CONSTRAINT composante_produits_pkey PRIMARY KEY (id),
    CONSTRAINT composante_produit_unique UNIQUE (produit_id, composante_id),
    CONSTRAINT composante_produit_composante_fkey FOREIGN KEY (composante_id)
        REFERENCES composantes (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT composante_produit_produit_fkey FOREIGN KEY (produit_id)
        REFERENCES cadre_logiques (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE statut_budgets
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
	deleted_on timestamp null,
    CONSTRAINT statut_budgets_pkey PRIMARY KEY (id),
    CONSTRAINT statut_budgets_intitule_unique UNIQUE (intitule)
);
INSERT INTO statut_budgets (intitule) VALUES
('Prévu'),
('Dépensé'),
('Budgetisé');

CREATE TABLE statut_montant_financements
(
    id BIGSERIAL,
    intitule character varying(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
	deleted_on timestamp null,
    CONSTRAINT statut_montant_financements_pkey PRIMARY KEY (id),
    CONSTRAINT statut_montant_financements_intitule_unique UNIQUE (intitule)
);
INSERT INTO statut_montant_financements (intitule) VALUES
('Mobilisé'),
('Consommé'),
('Recherché');


DROP TABLE budget_annuel_prevus;
DROP TABLE budget_annuel_depenses;
DROP TABLE budget_annuels;
DROP TABLE plan_financements;

CREATE TABLE projet_plan_financements
(
    id BIGSERIAL,
    projet_id bigint NOT NULL,
	composante_id bigint,
    source_financement_id bigint,
    bailleur_id bigint,
    statut_financement_id bigint,
    nature_financement_id bigint,
	categorie_depense_id bigint,
    montant numeric(15,2),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
	deleted_on timestamp null,
    CONSTRAINT projet_plan_financement_pkey PRIMARY KEY (id),
	CONSTRAINT projet_plan_financement_unique UNIQUE (projet_id, composante_id,source_financement_id,bailleur_id,statut_financement_id,nature_financement_id,categorie_depense_id),
    CONSTRAINT projet_plan_financement_nature_financement_id_fkey FOREIGN KEY (nature_financement_id)
        REFERENCES nature_financements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT projet_plan_financement_projet_id_fkey FOREIGN KEY (projet_id)
        REFERENCES projets (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	CONSTRAINT projet_plan_financement_composante_id_fkey FOREIGN KEY (composante_id)
        REFERENCES composantes (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT projet_plan_financement_bailleur_id_fkey FOREIGN KEY (bailleur_id)
        REFERENCES bailleurs (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT projet_plan_financement_source_financement_id_fkey FOREIGN KEY (source_financement_id)
        REFERENCES source_financements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT projet_plan_financement_statut_financement_id_fkey FOREIGN KEY (statut_financement_id)
        REFERENCES statut_financements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	CONSTRAINT projet_plan_financement_categorie_depense_id_fkey FOREIGN KEY (categorie_depense_id)
        REFERENCES categorie_depenses (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE projet_budget_annuels
(
    id BIGSERIAL,
    plan_financement_id bigint NOT NULL,
    annee int NOT NULL,
	statut_budget_id int NOT NULL,
	montant numeric(15,2),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
	deleted_on timestamp null,
    CONSTRAINT projet_budget_annuel_pkey PRIMARY KEY (id),
	CONSTRAINT projet_budget_annuel_unique UNIQUE (plan_financement_id,annee,statut_budget_id),
    CONSTRAINT projet_budget_annuel_plan_financement_id_fkey FOREIGN KEY (plan_financement_id)
        REFERENCES projet_plan_financements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	CONSTRAINT projet_budget_annuel_statut_budget_id_fkey FOREIGN KEY (statut_budget_id)
        REFERENCES statut_budgets (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

ALTER TABLE cadre_developpements
ADD COLUMN cout_total_financement bigint;

CREATE TABLE cd_financement_par_bailleurs
(
    id BIGSERIAL,
    cadre_developpement_id bigint NOT NULL,
	bailleur_id bigint,
    montant numeric(15,2),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
	deleted_on timestamp null,
    CONSTRAINT cd_financement_par_bailleur_pkey PRIMARY KEY (id),
	CONSTRAINT cd_financement_par_bailleur_cadre_developpement_id_fkey FOREIGN KEY (cadre_developpement_id)
        REFERENCES cadre_developpements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT cd_financement_par_bailleur_bailleur_id_fkey FOREIGN KEY (bailleur_id)
        REFERENCES bailleurs (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
CREATE UNIQUE INDEX cd_financement_par_bailleurs_unique_active ON cd_financement_par_bailleurs (cadre_developpement_id,bailleur_id) WHERE deleted_on IS NULL;

CREATE TABLE cd_financement_annuel_par_bailleurs
(
    id BIGSERIAL,
    plan_financement_id bigint NOT NULL,
    annee int NOT NULL,
	statut_montant_financement_id int NOT NULL,
	montant numeric(15,2),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
	deleted_on timestamp null,
    CONSTRAINT cd_financement_annuel_par_bailleurs_pkey PRIMARY KEY (id),
	CONSTRAINT cd_financement_annuel_par_bailleurs_plan_financement_id_fkey FOREIGN KEY (plan_financement_id)
        REFERENCES cd_financement_par_bailleurs (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	CONSTRAINT cd_financement_annuel_par_bailleurs_statut_montant_financement_id_fkey FOREIGN KEY (statut_montant_financement_id)
        REFERENCES statut_montant_financements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
CREATE UNIQUE INDEX cd_financement_annuel_par_bailleurs_unique_active ON cd_financement_annuel_par_bailleurs (plan_financement_id, annee, statut_montant_financement_id) WHERE deleted_on IS NULL;

CREATE TABLE cd_financement_par_resultats
(
    id BIGSERIAL,
    cadre_developpement_id bigint NOT NULL,
	cadre_logique_id bigint,
    montant numeric(15,2),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
	deleted_on timestamp null,
    CONSTRAINT cd_financement_par_resultat_pkey PRIMARY KEY (id),
	CONSTRAINT cd_financement_par_resultat_cadre_developpement_id_fkey FOREIGN KEY (cadre_developpement_id)
        REFERENCES cadre_developpements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT cd_financement_par_resultat_cadre_logique_id_fkey FOREIGN KEY (cadre_logique_id)
        REFERENCES cadre_logiques (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
CREATE UNIQUE INDEX cd_financement_par_resultats_unique_active ON cd_financement_par_resultats (cadre_developpement_id,cadre_logique_id) WHERE deleted_on IS NULL;

CREATE TABLE cd_financement_annuel_par_resultats
(
    id BIGSERIAL,
    plan_financement_id bigint NOT NULL,
    annee int NOT NULL,
	statut_montant_financement_id int NOT NULL,
	montant numeric(15,2),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
	deleted_on timestamp null,
    CONSTRAINT cd_financement_annuel_par_resultats_pkey PRIMARY KEY (id),
	CONSTRAINT cd_financement_annuel_par_resultats_plan_financement_id_fkey FOREIGN KEY (plan_financement_id)
        REFERENCES cd_financement_par_resultats (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	CONSTRAINT cd_financement_annuel_par_resultats_statut_montant_financement_id_fkey FOREIGN KEY (statut_montant_financement_id)
        REFERENCES statut_montant_financements (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
CREATE UNIQUE INDEX cd_financement_annuel_par_resultats_unique_active ON cd_financement_annuel_par_resultats (plan_financement_id, annee, statut_montant_financement_id) WHERE deleted_on IS NULL;

-- debut alpariss 20260218
-- 1. Ajout des colonnes à la table projets
ALTER TABLE public.projets 
ADD COLUMN dispose_organe_pilotage BOOLEAN DEFAULT NULL,
ADD COLUMN a_audit_regulier BOOLEAN DEFAULT NULL,
ADD COLUMN problemes_rencontres TEXT DEFAULT NULL,
ADD COLUMN solutions_proposees TEXT DEFAULT NULL,
ADD COLUMN recommandations TEXT DEFAULT NULL,
ADD COLUMN rapport_rempli_par VARCHAR(255) DEFAULT NULL,
ADD COLUMN rapport_date_remplissage DATE DEFAULT NULL;

-- 2. Table projet_pilotage_annees
CREATE TABLE public.projet_pilotage_annees (
    id BIGSERIAL PRIMARY KEY,
    projet_id BIGINT NOT NULL,
    annee INTEGER NOT NULL,
    nb_sessions_prevues INTEGER NOT NULL DEFAULT 0,
    nb_sessions_tenues INTEGER NOT NULL DEFAULT 0,
    nb_recommandations_formulees INTEGER NOT NULL DEFAULT 0,
    nb_recommandations_mises_oeuvre INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
    CONSTRAINT projet_pilotage_annees_projet_id_foreign 
        FOREIGN KEY (projet_id) REFERENCES public.projets(id) ON DELETE CASCADE,
    CONSTRAINT projet_pilotage_annees_projet_id_annee_unique 
        UNIQUE (projet_id, annee)
);

-- 3. Table projet_pilotage_sessions
CREATE TABLE public.projet_pilotage_sessions (
    id BIGSERIAL PRIMARY KEY,
    projet_pilotage_annee_id BIGINT NOT NULL,
    date_session DATE NOT NULL,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
    CONSTRAINT projet_pilotage_sessions_projet_pilotage_annee_id_foreign 
        FOREIGN KEY (projet_pilotage_annee_id) REFERENCES public.projet_pilotage_annees(id) ON DELETE CASCADE
);

-- 4. Table projet_audits_exercices
CREATE TABLE public.projet_audits_exercices (
    id BIGSERIAL PRIMARY KEY,
    projet_id BIGINT NOT NULL,
    exercice INTEGER NOT NULL,
    comptes_certifies BOOLEAN DEFAULT NULL,
    nb_recommandations_formulees INTEGER NOT NULL DEFAULT 0,
    nb_recommandations_mises_oeuvre INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
    CONSTRAINT projet_audits_exercices_projet_id_foreign 
        FOREIGN KEY (projet_id) REFERENCES public.projets(id) ON DELETE CASCADE,
    CONSTRAINT projet_audits_exercices_projet_id_exercice_unique 
        UNIQUE (projet_id, exercice)
);

-- 5. Table projet_rapports
CREATE TABLE public.projet_rapports (
    id BIGSERIAL PRIMARY KEY,
    projet_id BIGINT NOT NULL,
    type VARCHAR(255) NOT NULL,
    fichier VARCHAR(255) NOT NULL,
    date_rapport DATE DEFAULT NULL,
    description TEXT DEFAULT NULL,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
    CONSTRAINT projet_rapports_projet_id_foreign 
        FOREIGN KEY (projet_id) REFERENCES public.projets(id) ON DELETE CASCADE
);

-- fin alpariss 20260218