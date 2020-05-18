#pragma once
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <math.h>
#include <time.h>

//Definitions pour le tableau de solution
#define VIDE 0			//On ne connaît pas encore l'état de la case
#define PLEIN 1			//pas besoin d'explication
#define CROIX 2			//On est sûr que la case est vide
#define MARQUEUR 3		//c'est peut etre plein

#define ERROR -1
#define SIZEMAX 20
#define OK 100

/*////////////


////////////*/
typedef struct picross {
	int lignes;			//Le nombre de lignes de la solution.
	int colonnes;		//Le nombre de colonnes de la solution.
	int* solution;		//Le tableau contenant la solution.
	int nb_cases;		//Le nombre de cases à remplir au total.
	char** nb_lignes;	//La taille des cases à remplir par ligne.
	char** nb_colonnes;	//La taille des cases à remplir par colonne.
} picross;


/*/////////////////////////////////
ARGUMENTS:
	-adresse du picross a creer
	-le nombre de lignes du picross
	-le nombre de colonnes du picross
DESCRIPTION:
	créé un picross vide de taille lignes et colonnes
	à l'espace de memoire tmp avec des tableaux	vides
RETURN:
	OK si pas de probleme
	ERROR si probleme
////////////////////////////////*/
int Init_picross(picross* tmp, int lignes, int colonnes);

/*/////////////////////////////////
ARGUMENTS:
	-picross avec les informations a afficher

DESCRIPTION:
	affiche les informations de la structure 
	en question

RETURN:
	rien
/////////////////////////////////*/
void Afficher_picross(picross tmp);

/*/////////////////////////////////
ARGUMENTS:
	-un nombre maximum et minimum

DESCRIPTION:
	renvoie un nombre aléatoire ccmopris entre un max et un min tous les deux inclus

RETURN:
	le nombre aléatoire
/////////////////////////////////*/
int inter_rand(int min, int max);

/*////////////////////////////////
ARGUMENTS:
	-addresse du picross

DESCRIPTION:
	utilise le tableau solution d'un
	picross pour mettre a jour les tableau
	nb_colonnes et nb_lignes du picross

RETURN:
	rien
////////////////////////////////*/
void compter_taille_cases(picross* tmp);

/*////////////////////////////////
ARGUMENTS:
	-addresse du picross

DESCRIPTION:
	Il affiche les informations necessaires
	pour le php

RETURN:
	rien
////////////////////////////////*/
void affichage_random(picross resultat);

picross creation_random(float dificulte, int ligne, int colonne);