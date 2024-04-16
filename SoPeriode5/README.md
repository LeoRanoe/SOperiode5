# NATIN Periode 5 Film Database

## Opdracht
Ontwikkel een **CRUD (Create, Read, Update, Delete)** applicatie in PHP met een MySQL database om een filmdatabase te beheren.

### Functionaliteiten
- Beheerders kunnen films toevoegen, bewerken en verwijderen.
- Gebruikers kunnen films bekijken en zoeken.
- Films worden gekenmerkt door titel, genre, regisseur, - releasejaar, beschrijving, poster en beoordeling.
- Gebruikers kunnen zoeken op titel, genre, regisseur en releasejaar.
- Mogelijkheid om afbeeldingen te uploaden voor posters.
- Gebruikers kunnen films beoordelen.
- Optionele integratie met een API voor film details.


### Op te leveren producten:
- Logboek met voortgangsverslagen.
- Ontwerp van de database (ERD diagram).
- Functionele specificaties.
- Voltooide database met testdata.
- PHP code voor CRUD operaties.
- Gebruikersinterface met HTML, CSS en formulieren.
- Testplan en testresultaten.
- Presentatie van de applicatie.


## Project Starter Template

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

### Richtlijnen:

- **Gebruik van includes**: Scheid logica van presentatie door herbruikbare code in te sluiten, zoals de databaseverbinding en functies, in aparte bestanden in de includes/-map.
- **Databaseverbinding**: Zorg ervoor dat alle pagina's die databasefunctionaliteit nodig hebben, de databaseverbinding includeren vanuit `includes/db_connection.php`.
- **Bestandsnamen**: Geef PHP-bestanden zinvolle namen op basis van hun functie, bijvoorbeeld `add_movie.php`, `edit_movie.php`, enz.
- **Beveiliging**: Implementeer beveiligingsmaatregelen, zoals inputvalidatie en het voorkomen van SQL-injectie, in PHP-bestanden die met de database communiceren.
- **Documentatie**: Voeg commentaar toe aan je code om anderen (en jezelf) te helpen de code te begrijpen en te onderhouden.
- **Versiebeheer**: Gebruik Git voor versiebeheer. Het .gitignore-bestand helpt bij het negeren van onnodige bestanden, zoals inloggegevens voor de database.
- **Leesbaarheid**: Schrijf duidelijke, goed georganiseerde code die gemakkelijk te begrijpen en te onderhouden is.
