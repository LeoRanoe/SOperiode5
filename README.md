# SOperiode5

##opdracht
De opdracht voor periode 5 is om een CRUD (Create, Read, Update, Delete) applicatie in PHP met een MySQL database te ontwikkelen om een filmdatabase te beheren.

### Functionaliteiten
- Beheerders kunnen films toevoegen, bewerken en verwijderen.
- Gebruikers kunnen films bekijken en zoeken.
- Films worden gekenmerkt door titel, genre, regisseur, - releasejaar, beschrijving, poster en beoordeling.
- Gebruikers kunnen zoeken op titel, genre, regisseur en releasejaar.
- Mogelijkheid om afbeeldingen te uploaden voor posters.
- Gebruikers kunnen films beoordelen.
- Gebruikers kunnen films downloaden.
- Gebruikers kunnen films toevoengen aan favorites.
- Optionele integratie met een API voor film details.

### Directorystructuur uitleg:

- **`css/`**: Bevat CSS-bestanden voor opmaak van de gebruikersinterface.
- **`img/`**: Hier kunnen afbeeldingen worden opgeslagen, zoals posters voor films.
- **`includes/`**: Bevat bestanden met herbruikbare code, zoals de databaseverbinding (db_connection.php) en functies voor databasebewerkingen (functions.php).
- **`js/`**: Bevat JavaScript-bestanden voor eventuele client-side interactie.
- **`pages/`**: Bevat PHP-bestanden voor verschillende pagina's van de applicatie, zoals het toevoegen, bewerken, verwijderen, bekijken en zoeken van films.
- **`sql/`**: Bevat het SQL-script (database.sql) om de database te maken met de benodigde tabellen en relaties.
- **`.gitignore`**: Dit bestand geeft aan welke bestanden en mappen moeten worden genegeerd door Git bij het bijhouden van wijzigingen in de repository.
- **`index.php`**: Dit is de hoofdpagina van de applicatie waar gebruikers naartoe worden geleid wanneer ze de applicatie openen.
- **`README.md`**: Een markdown-bestand met instructies en informatie over het project.
