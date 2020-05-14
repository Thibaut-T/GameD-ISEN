#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <conio.h>
#include <locale.h>
#include <string.h>
#define VIDE 0 //On ne connaît pas encore l'état de la case
#define PLEIN 1 //pas besoin d'explication
#define CROIX 2 //On est sûr que la case est vide
#define MARQUEUR 3 //c'est peut etre plein
#define Nbelement 3
#define TailleTab 15

typedef struct picrosstest {
    int longueur;
    int tableau[TailleTab];
} PICROSSTEST;

void affichage(PICROSSTEST* picross) {
    for (int i = 0; i < TailleTab; i++) {
        printf("\naffichage case %d : %d", i, picross->tableau[i]);
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

void evidences(PICROSSTEST* Picross, int* instruction, int debut, int longueur) {
    int taillecompresse = 0;
    //printf("evidences");
    for (int i = 0; i < Nbelement; i++) {
        taillecompresse += *(instruction + i) + 1;
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
                Picross->tableau[tmp + j + marge] = PLEIN;
                //printf("La %d eme case a ete modifié\n", tmp + j);
            }
            if (marge == 0 && tmp + *(instruction + i) + 1 <= longueur) {
                Picross->tableau[tmp + *(instruction + i)] = CROIX;
            }
        }
        tmp += *(instruction+i) + 1;
    }
}


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

int main() {
    setlocale(LC_ALL, "fr-FR");
    PICROSSTEST easypicross;
    for (int i = 0; i < TailleTab; i++) {
        easypicross.tableau[i] = 0;
    }
    easypicross.longueur = TailleTab;
    int instruction[Nbelement];
    instruction[0] = 3;
    instruction[1] = 3;
    instruction[2] = 1;
 
    

    easypicross.tableau[2] = CROIX;
    easypicross.tableau[12] = CROIX;
    //printf("%d\n", espacement(&easypicross, 0, 1));

    //printf("%d\n", espacement(&easypicross, 7 - 1, -1));
    solveur(&easypicross, &instruction, 0, easypicross.longueur -1);
    affichage(&easypicross);

}