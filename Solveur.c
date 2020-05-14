#include "extraire.h"
#include "solveur.h"
#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <conio.h>
#include <locale.h>
#include <string.h>



void affichage(PICROSSTEST* picross) {
    for (int i = 0; i < TailleTab; i++) {
        printf("\naffichage case %d : %d", i, picross->tableau[i]);
    }
}

void Afficher_picross(picross tmp) {
    printf("\nNombre de cases remplie : %d", tmp.nb_cases);
    printf("\nNombre de colonnes remplie : %d", tmp.colonnes);
    printf("\nNombre de lignes remplie : %d\n", tmp.lignes);

    for (int x = 0; x < tmp.lignes; x++) {
        for (int y = 0; y < tmp.colonnes; y++)
            printf("%d ", tmp.solution[y + x * tmp.colonnes]);
        printf("\n");
    }
}

int espacement(PICROSSTEST* picross, int caseini, int ordre) {
    int nbvide = 0;
    int pos = caseini;
    while (picross->tableau[pos]!=CROIX && pos<picross->longueur && pos>=0){
        pos += ordre;
        nbvide++;
    }
    return nbvide;
}

int nombre_instructions(int* instructions, int ligne) {
    if (*instructions == 0)
        return 1;
    else {
        int nombre = 0;
        for (nombre; *(instructions + nombre) != 0; nombre++)
            return nombre;
    }
}

void evidences(picross* Picross, int* instruction, int debut, int longueur,int ligne) {
    int taillecompresse = 0;
    //printf("evidences");
    int Nbelement = nombre_instructions(instruction, ligne);
    for (int i = 0; i < Nbelement; i++) {
        taillecompresse += *(instruction + i + trouver_cases_max(instruction,Picross->nb_lignes)*ligne) + 1;
    }
    taillecompresse--;

    //printf("La taille compressée de la ligne est %d", taillecompresse);

    int tmp = debut;
    int marge = longueur - debut - taillecompresse +1;
    //printf("\n\nla marge est de %d", marge);
    for (int i = 0; i <= Nbelement; i++) {
        if (marge < *(instruction+i)) {
            //printf("\n%d", instruction[i] - marge);
            for (int j = 0; j < *(instruction+i) - marge; j++) {
                Picross->solution[tmp + j + marge + Picross->colonnes * ligne] = PLEIN;
                //printf("La %d eme case a ete modifié\n", tmp + j);
            }
            if (marge == 0 && tmp + *(instruction + i) + 1 <= longueur) {
                Picross->solution[tmp + *(instruction + i) + Picross->colonnes*ligne] = CROIX;
            }
        }
        tmp += *(instruction+i) + 1;
    }
}

int Init_picross(picross* tmp, int lignes, int colonnes) {
    if (lignes <= 0 || colonnes <= 0)return ERROR;
    //Déclaration des variables
    picross* resultat;
    int* tmp1;
    char* tmp2;
    char* tmp3;
    //Allocation de la mémoire pour les tableaux
    resultat = (picross*)malloc(sizeof(picross));
    tmp1 = (int*)malloc(sizeof(int) * lignes * colonnes);
    tmp2 = (char*)malloc(sizeof(char) * 20 * lignes);
    tmp3 = (char*)malloc(sizeof(char) * 20 * colonnes);
    //Check si les allocation on réussi
    if (!resultat || !tmp1 || !tmp2 || !tmp3)return ERROR;
    //On rends des tableux vide
    for (int x = 0; x < lignes; x++)
        for (int y = 0; y < colonnes; y++)
            tmp1[y + x * colonnes] = 0;
    //Assignation des valeurs aux variables

    resultat->lignes = lignes;
    resultat->colonnes = colonnes;
    resultat->nb_cases = 0;
    resultat->solution = tmp1;
    resultat->nb_lignes = tmp2;
    resultat->nb_colonnes = tmp3;
    *tmp = *resultat;
    return OK;
}

void Afficher_picross(picross tmp) {
    printf("\nNombre de cases remlpi : %d", tmp.nb_cases);
    printf("\nNombre de colonnes remlpi : %d", tmp.colonnes);
    printf("\nNombre de lignes remlpi : %d\n", tmp.lignes);

    for (int x = 0; x < tmp.lignes; x++) {
        for (int y = 0; y < tmp.colonnes; y++)
            printf("%d ", tmp.solution[y + x * tmp.colonnes]);
        printf("\n");
    }
}

/*
void solveur(PICROSSTEST* picroSSSS, int* instruction, int debut, int longueur) { //pour l'instant un void, apres il retournera si il a trouvé ou non une chose a modifier
   
    int casevide = 0;
        for (int testcasei = debut; testcasei <= longueur; testcasei++)//on parcourt toute les cases pour essayer de trouver un "vide" sur la ligne, sinon, pas la peine de continuer et de chercher a modifier
        {
            if (picroSSSS->tableau[testcasei] == VIDE) casevide++;
        }
    if (casevide){ //si il y a au moins une case a remplir, on remplit, sinon, pas la peine

        evidences(picroSSSS, instruction, debut,longueur); //(on le fait quand meme, meme s'il est refait dans solveur pour les cas ou il n'y a qu'une instruction)
        if (Nbelement == 1) {
            for (int i = 0; i <= longueur; i++) {
                if (picroSSSS->tableau[i] == PLEIN) {
                    //car nombre element vaut 1, l'instruction dans cette ligne est donc *instruction
                    for (int k = 0; k <= longueur - *instruction; k++) {
                        if (i - k - 1 < 0) {
                            picroSSSS->tableau[longueur - (k - i)] = CROIX;
                        }
                        if (k <= i - *instruction) {
                            picroSSSS->tableau[k] = CROIX;
                        }
                    }
                }
                if (picroSSSS->tableau[i] == CROIX && *instruction > longueur - i) {
                    for (int k = i; k <= longueur; k++)
                    {
                        picroSSSS->tableau[k] = CROIX;
                    }
                    evidences(picroSSSS, instruction, 0, i - 1);
                    //printf("\nTest\n");
                }
                if (picroSSSS->tableau[i] == CROIX && *instruction > i) {
                    for (int k = 0; k <= i; k++)
                    {
                        picroSSSS->tableau[k] = CROIX;
                    }
                    evidences(picroSSSS, instruction, i + 1, longueur);
                }
            }

            int i = 0; int j = longueur;
            int modif = 0;
            while (i < longueur && j>0 && modif == 0)
            {
                if (picroSSSS->tableau[i] == PLEIN && picroSSSS->tableau[j] == PLEIN) { //rajouter une verification si j-i plus grand que instruction 

                    for (int k = i; k <= j; k++)
                    {
                        picroSSSS->tableau[k] = PLEIN; //il faudra peut etre verifier que ce n'est pas une case "CROIX" auquel cas -> remonter une erreur car impossible
                    }
                    modif = 1;
                }
                if (picroSSSS->tableau[i] != PLEIN) {
                    i++;
                }
                if (picroSSSS->tableau[j] != PLEIN) {
                    j--;
                }
            }
        }
        if (picroSSSS->tableau[debut] != CROIX) {
           
            if (espacement(picroSSSS, debut, 1) < *instruction) {
               
                int espace = espacement(picroSSSS, debut, 1);
                for (int k = debut; k < debut + espace; k++) {
                    picroSSSS->tableau[k] = CROIX;
                    
                }
                solveur(picroSSSS, instruction, espace +1 + debut, longueur);
            }
        }
        if (picroSSSS->tableau[longueur] != CROIX) {
            printf("\n%d", espacement(picroSSSS, longueur, -1));
            if (espacement(picroSSSS, longueur, -1) < *(instruction + Nbelement - 1)) {

                int espace = espacement(picroSSSS, longueur, -1);
                for (int k = longueur-espace; k <=longueur; k++) {
                    picroSSSS->tableau[k] = CROIX;

                }
                solveur(picroSSSS, instruction, debut, longueur - espace- 1);
            }
        }
    }

   
}
*/

int main() {
    setlocale(LC_ALL, "fr-FR");


    int colonnes = 5;
    int lignes = 5;
    picross* Piiicross;
    Init_picross(Piiicross, lignes, colonnes);

    char* nb_lignes[5];
    *nb_lignes = "1";
    *(nb_lignes + 1) = "1 3";
    *(nb_lignes + 2) = "3";
    *(nb_lignes + 3) = "4";
    *(nb_lignes + 4) = "1 1 1";

    int cases_max = trouver_cases_max(nb_lignes, colonnes);
    int* nb_lignes_int = extraire_nombres(nb_lignes, colonnes, cases_max);
    
    

    //printf("%d\n", espacement(&easypicross, 0, 1));

    //printf("%d\n", espacement(&easypicross, 7 - 1, -1));
    //solveur(&easypicross, &instruction, 0, easypicross.longueur -1);
    for (int i = 0; i <lignes ; i++)
    {
        evidences(Piiicross, extraire_nombres(nb_lignes, colonnes, cases_max), 0, colonnes - 1, i);
    }
    Afficher_picross(*Piiicross);

}