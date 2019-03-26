# test-sf4

J'ai crée une commander qui permet d'extraire les mandataires cités dans une annonces et de rechercher dans un index fulltext
depuis la table mandataire_test, elle extrait les mandataires du champs commentaires et les mets dans une table de base 
de données nommée Mandataire:

php bin/console app:get-mandataire

il faut créer la base de données et après l'hydrater avec les fichiers sql annonces et mandataires_test
