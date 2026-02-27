1. Repartez des fichiers du site Web de votre laboratoire précédent.

2. Allez placer le fichier "composer.json" directement à l'entrée du
   dossier "inc" de votre laboratoire.

3. Ouvrez votre laboratoire dans VS Code.

4. Dans le terminal de VS Code, positionnez-vous dans le dossier "inc"
   de votre laboratoire à l'aide de la commande "cd", puis inscrivez
   la commande ci-dessous pour télécharger les dépendances listées dans
   le fichier "composer.json" que vous aviez précédemment placé dans le
   dossier "inc":
   
   docker run --rm -it -v "$(pwd):/app" composer update
   
5. Après l'exécution de cette précédente commande, un dossier "vendor"
   devrait être apparu dans votre dossier "inc", lequel contiendra les
   librairies PHP et dépendances nécessaires à la réalisation de votre
   laboratoire.