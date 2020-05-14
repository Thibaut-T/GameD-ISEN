#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "extraire.h"

int trouver_cases_max(char* nb[], int colignes) {
    int cases_max = 0, compteur = 0;
    for (int i = 0; i < colignes; i++) { //On détermine le nombre maximum de chiffres d'une seule ligne ou colonne, pour ensuite utiliser ce nombre dans un malloc() plus bas.
        compteur = ((strlen(*(nb + i))) + 1) / 2;
        if (compteur > cases_max)
            cases_max = compteur;
    }
    return cases_max;
}

int* extraire_nombres(char* nb[], int colignes, int cases_max) { //La fonction sert à extraire les nombres sur le côté de la grille : le premier paramètre est pour les nombres sur les lignes ou les colonnes, le deuxième paramètre est le nombre de colonnes ou de lignes du picross et le 3ème le nombre de cases maximum par ligne ou colonne calculé avec la fonction trouver_cases_max.  
    int* nb_lignes_int = (int*)malloc(sizeof(int) * cases_max * colignes);
    int fini = 0;
    char* chaine;
    char* end;
    for (int i = 0; i < colignes; i++) { //Ici, on stocke les nombres de type int dans un double tableau.
        fini = 0;
        chaine = *(nb + i);
        for (int j = 0; j < cases_max; j++) {
            strtol(chaine, &end, 10);
            if (*end == NULL && fini == 0) { //Quand il n'y a ou qu'il ne reste qu'un seul chiffre, on le stocke et fini passe à 1.
                *(nb_lignes_int + j + i * colignes) = (int)strtol(chaine, &end, 10);
                chaine = end;
                fini = 1;
            }
            else if (*chaine != NULL && fini == 0) { //Tant qu'il y a un minimum de 2 chiffres, on passe dans ce if pour stocker.
                *(nb_lignes_int + j + i * colignes) = (int)strtol(chaine, &end, 10);
                chaine = end;
            }
            else //Quand fini a été déclenché, on remplit le reste de la ligne par des 0.
                *(nb_lignes_int + j + i * colignes) = 0;
        }
    }
    return nb_lignes_int;
}