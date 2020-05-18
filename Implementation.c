#include "Header.h"

void Afficher_picross(picross tmp) {
	printf("\nNombre de cases remlpi : %d", tmp.nb_cases);
	printf("\nNombre de colonnes : %d", tmp.colonnes);
	printf("\nNombre de lignes : %d\n", tmp.lignes);

	//Premiere ligne de --
	printf("-");
	for (int i = 0; i <= tmp.lignes; i++)
		printf("--");
	printf("\n");
	//Affichage des valeurs a l'interieur du tableau
	for (int x = 0; x < tmp.lignes; x++) {
		printf("| ");
		for (int y = 0; y < tmp.colonnes; y++)
			if (tmp.solution[y + x * tmp.colonnes] == 0) {
				printf("  ");
			}
			else {
				printf("X ");
			}
		printf("|\n");
	}
	//Derniere ligne de --
	for (int i = 0; i <= tmp.lignes; i++)
		printf("--");
	printf("-");

	printf("\nTaille des cases sur les lignes :");
	for (int i = 0; i < tmp.lignes; i++)
		printf("\n%d ) %s", i + 1, tmp.nb_lignes[i]);

	printf("\nTaille des cases sur les colonnes:");
	for (int i = 0; i < tmp.colonnes; i++)
		printf("\n%d ) %s", i + 1, tmp.nb_colonnes[i]);
}

void affichage_random(picross resultat) {
	for (int x = 0; x < resultat.lignes; x++) {
		for (int y = 0; y < resultat.colonnes; y++) {
			printf("%d\n", resultat.solution[y + x * resultat.colonnes]);
		}
	}
	
	for (int i = 0; i < resultat.lignes; i++) {
		printf("%s\n", resultat.nb_lignes[i]);
	}

	for (int i = 0; i < resultat.colonnes; i++) {
		printf("%s\n", resultat.nb_colonnes[i]);
	}

	printf("%d\n", resultat.nb_cases);	
}

picross creation_random(float difficulte, int lignes, int colonnes) {
	picross resultat;
	int x, y;
	int cases_remplies = 0;
	int surface = lignes * colonnes;
	Init_picross(&resultat, lignes, colonnes);  // Création d'une structure de type picross
	if ((difficulte <= 2 && difficulte > 1 && surface <= 35) || (difficulte >2 && surface <=50)) {  // Dans certains cas il est impossible de créer une grille
		resultat.nb_cases = -1;
		return resultat;
	}
	if (difficulte != 0) {// Si la difficulté a été donnée
		int max = 5;
		float poly;   
		if (difficulte > 2) { // Calcul du polynome pour une grile difficile
			poly = 18.19517258 - 0.231568603 * surface + 0.00126518 * pow(surface, 2) - 3.05977149678 * pow(10, -6) * pow(surface, 3) + 2.696429 * pow(10, -9) * pow(surface, 4);
		}
		else if (difficulte <= 1) { // Calcul du polynome pour une grile facile
			poly = 0.4396869 + 0.07992 * surface - 0.0007592 * pow(surface, 2) + 2.4121547 * pow(10, -6) * pow(surface, 3) - 2.522 * pow(10, -9) * pow(surface, 4);
		}
		else { // Calcul du polynome pour une grile moyenne
			poly = 13.9172643 - 0.171192639543 * surface + 0.00092356 * pow(surface, 2) - 2.2309688343 * pow(10, -6) * pow(surface, 3) + 1.973512562 * pow(10, -9) * pow(surface, 4);
		}
		resultat.nb_cases = surface-((100*difficulte)/poly); // Calcule du nombre de case à noircir dans la grille en fonction de la difficulté et de la taille
		resultat.nb_cases *= 1+(inter_rand(0, 20) * pow(10, -2));  // Pour rendre les grilles différentes les unes par rapport aux autres on ajoute un nombre de case aléatoire
   		while (resultat.nb_cases <= colonnes && resultat.nb_cases<= lignes) {  // Dans certains cas la difficulté est trop grande pour pouvoir créer une grille. On 
																			   // réduit donc la difficulté pour avoir un nombre de cases positives
			if (difficulte <= 0.5) {		// On s'assure que la difficulté reste positve
				max = difficulte*10-1;
			}
			difficulte -= inter_rand(2, max)*pow(10, -1);	// On réduit la difficulté de manière aléatoire pour qu'une même situation de départ donne deux grilles totalement différentes
			resultat.nb_cases = surface - ((100 * difficulte) / poly);  // On calcule donc le nombre de cases à noircir
		}
	}
	
	while (cases_remplies < resultat.nb_cases) { // Création d'une grille aléatoirement en fonction du nombre de cases défini avant
		x = rand() % lignes;   // On cherche les coordonnées d'un point
		y = rand() % colonnes;
		if (resultat.solution[y + x * colonnes] == 0) // On noirict cette case si elle n'a pas encore été noircit
		{
			resultat.solution[y + x * colonnes] = PLEIN;
			cases_remplies++;
		}
	}

	//Partie ou on va compter la taille des cases presentes par ligne et par colonne
	compter_taille_cases(&resultat);
	//Afficher_picross(resultat);
	/*
	Envoie du picross trouvé au solveur
	if(aucune une solution n'a été trouvé ou qu'il y a deux solutions){
		resultat.nb_cases=-2;
		return resultat;
	}
	*/
	return resultat;
}

int inter_rand(int min, int max) {
	int val = (int)(rand() % ((max +1) - (min)) + min);
	return val;
}





void compter_taille_cases(picross* tmp) {
	int taille_bloc = 0;            //taille d'un ensemble de blocs present sure une ligne ou une colonne    
	int x = 0;
	int y = 0;
	int size = 0;
	char buffer[SIZEMAX];
	int colonnes = tmp->colonnes;
	int lignes = tmp->lignes;
	while (y < colonnes)  { // Pour chaque colonnes
		if (tmp->solution[y + x * colonnes] == PLEIN)taille_bloc += 1; // On vérifie si la case est noircit
		else {  // Si elle ne l'est pas
			if (taille_bloc != 0)  // Si l'ensemble de blocs n'est pas égale à 0 on met le nombre dans une chaine de caractère
				size += sprintf_s(buffer + size, 20 - size, "%d ", taille_bloc);  
			taille_bloc = 0;
		}

		x += 1;

		if (x == lignes) { // Si on est arrivé à la fin de la colonne
			if (taille_bloc != 0) // Si l'ensemble de blocs n'est pas égale à 0 on met le nombre dans une chaine de caractère
				size += sprintf_s(buffer + size, 20 - size, "%d ", taille_bloc);

			strcpy_s(tmp->nb_colonnes[y], SIZEMAX, buffer); // On met la chaine de caractère créée dans le tableau de char
			strcpy_s(buffer, SIZEMAX, "                   ");
			taille_bloc = 0;
			x = 0; y += 1;
			size = 0;
		}

	}

	x = 0; // On réinitailise les variables
	y = 0;
	size = 0;
	taille_bloc = 0;

	while (x < lignes) {  // On utilise le même fonctionnement pour les lignes
		if (tmp->solution[y + x * colonnes] == PLEIN)taille_bloc += 1;
		else {
			if (taille_bloc != 0)
				size += sprintf_s(buffer + size, 20 - size, "%d ", taille_bloc);
			taille_bloc = 0;
		}

		y += 1;

		if (y == colonnes) {
			if (taille_bloc != 0)
				size += sprintf_s(buffer + size, 20 - size, "%d ", taille_bloc);

			strcpy_s(tmp->nb_lignes[x], SIZEMAX, buffer);
			strcpy_s(buffer, SIZEMAX, "                   ");
			taille_bloc = 0;
			y = 0; x += 1;
			size = 0;
		}

	}

}


int Init_picross(picross* tmp, int lignes, int colonnes) {
	if (lignes <= 0 || colonnes <= 0)return ERROR;
	//Déclaration des variables
	picross* resultat;
	int* tmp1;
	char** tmp2;
	char** tmp3;
	//Allocation de la mémoire pour les tableaux
	resultat = (picross*)malloc(sizeof(picross));

	tmp1 = (int*)malloc(sizeof(int) * lignes * colonnes);

	tmp2 = (char**)malloc(sizeof(char*) * lignes);
	for (int i = 0; i < lignes; i++)
		tmp2[i] = (char*)malloc(sizeof(char) * SIZEMAX);

	tmp3 = (char**)malloc(sizeof(char*) * colonnes);
	for (int i = 0; i < colonnes; i++)
		tmp3[i] = (char*)malloc(sizeof(char) * SIZEMAX);

	//Check si les allocation on réussi
	if (!resultat || !tmp1 || !tmp2 || !tmp3)return ERROR;
	//On rends des tableux vide
	for (int x = 0; x < lignes; x++)
		for (int y = 0; y < colonnes; y++)
			tmp1[y + x * colonnes] = 0;

	for (int i = 0; i < lignes; i++) {
		sprintf_s(tmp2[i], SIZEMAX, "%d", 0);
		tmp2[i];
	}

	for (int i = 0; i < colonnes; i++) {
		sprintf_s(tmp3[i], SIZEMAX, "%d", 0);
		tmp3[i];
	}

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