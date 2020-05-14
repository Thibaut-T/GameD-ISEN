#pragma once
#define VIDE 0 //On ne connaît pas encore l'état de la case
#define PLEIN 1 //pas besoin d'explication
#define CROIX 2 //On est sûr que la case est vide
#define MARQUEUR 3 //c'est peut etre plein
#define ERROR -1
#define SIZEMAX 20
#define OK 100

#define TailleTab 5

typedef struct picrosstest {
    int longueur;
    int tableau[TailleTab][TailleTab];
} PICROSSTEST;

typedef struct picross {
    int lignes; //Le nombre de lignes de la solution.
    int colonnes; //Le nombre de colonnes de la solution.
    int* solution; //Le tableau contenant la solution.
    int nb_cases; //Le nombre de cases à remplir au total.
    char* nb_lignes; //Le nombre de cases à remplir par ligne.
    char* nb_colonnes; //Le nombre de cases à remplir par colonne.
} picross;

int espacement(PICROSSTEST* picross, int caseini, int ordre);

void affichage(PICROSSTEST* picross);
