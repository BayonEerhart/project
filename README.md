# project
sosial media for planes 

## Download Instructies
Voordat je begint, zorg ervoor dat je de volgende vereisten geïnstalleerd hebt op je systeem:

- PHP
- phpMyAdmin
- Apache2
### Installatie Instructies:
1. #### Installeer Benodigde Software:

-Zorg ervoor dat PHP, phpMyAdmin en Apache2 zijn geïnstalleerd op je systeem. Zo niet, dan kun je ze installeren met behulp van de volgende commando's:

```bash
sudo apt update
sudo apt install php phpmyadmin apache2
```
2. #### Project Implementatie:

- Start je Apache-server en plaats dit project in de Apache-map. Deze bevindt zich doorgaans op /var/www/html/.
3. #### Database Setup:

- Ga naar de import map binnen dit project.
- Kopieer het import.sql bestand naar een locatie die toegankelijk is voor je MySQL-server.
- Importeer het SQL-bestand in je MySQL-database. Je kunt hiervoor phpMyAdmin of de MySQL-opdrachtregel gebruiken.
4. #### Configureer Databaseverbinding:

- Open het connect.php bestand in dit project.
- Werk het bestand bij met de juiste databaseverbinding details, inclusief de gebruikersnaam en het wachtwoord.
5. #### Toegang tot dit Project:

- Zodra alles is ingesteld, kun je toegang krijgen tot je project via een webbrowser. Typ eenvoudigweg de URL http://localhost/project in de adresbalk van je browser.