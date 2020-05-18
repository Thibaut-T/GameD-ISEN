#include "Header.h"
	
int main(int argc, char* argv[]) {
	int ligne=0, colonne=0, surface=0;
	float difficulte=0, poly=0;
	picross grille;
	srand(time(NULL));
	if (argv[1] == NULL || argv[2] == NULL || argv[3] == NULL) { // Si il y a eu un problème avec les arguments
		return;
	}

	else {
		difficulte = atof(argv[3]);
		ligne = atoi(argv[1]);
		colonne = atoi(argv[2]);
	}
	
	if (difficulte == 0) { // Si la personne n'a pas définie la difficulté
		difficulte = inter_rand(1, 3);
	}


	if (colonne == 0 && ligne == 0) {  // Si la taille de la grille n'a pas été définie
		switch ((int)difficulte) {
			case 1:ligne = 5; colonne = 5;  break;
			case 2:ligne = 10; colonne = 10; break;
			case 3:ligne = 15; colonne = 15;  break;
			default:;
		}
	}	


	printf("%d\n", ligne);
	printf("%d\n", colonne);

	if ((colonne <= 1 && ligne != 0) || (colonne != 0 && ligne <= 1) || colonne > 20 || ligne > 20) { // Si les valeurs renseignés ne sont pas bonnes
		return;
	}
	surface = ligne * colonne;
	for (int i = 0; i < 3; i++) { // Si l'algorithme est un échec, on s'autorise 3 essais pour trouver une grille valable avant de considérer que c'est impossible
			grille=creation_random(difficulte, ligne, colonne);
			if (grille.nb_cases == -1) {  // S'il est impossible de réer une grille
				affichage_random(grille);
				return;
			}
			else if (grille.nb_cases > 0) { // Si la grille est créer
				switch ((int)difficulte) {//on s'assure que la difficulté a été respecté
					case 1:poly = 0.4396869 + 0.07992 * surface - 0.0007592 * pow(surface, 2) + 2.4121547 * pow(10, -6) * pow(surface, 3) - 2.522 * pow(10, -9) * pow(surface, 4); break;
					case 2:poly = 13.9172643 - 0.171192639543 * surface + 0.00092356 * pow(surface, 2) - 2.2309688343 * pow(10, -6) * pow(surface, 3) + 1.973512562 * pow(10, -9) * pow(surface, 4); break;
					case 3:poly = 18.19517258 - 0.231568603 * surface + 0.00126518 * pow(surface, 2) - 3.05977149678 * pow(10, -6) * pow(surface, 3) + 2.696429 * pow(10, -9) * pow(surface, 4); break;
					default:;
				}
				if (difficulte >= ((surface - grille.nb_cases) * poly) / 100 && (difficulte - 1) < ((surface - grille.nb_cases) * poly) / 100) { // Si la grille est bonne
					affichage_random(grille);
					return;
				}
			}
	}
	return EXIT_SUCCESS;
}



