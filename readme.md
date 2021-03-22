## Projekt beskrivelse:
Dette er en test opgave.

Opgave 1: GitHub og Wordpress.

1. Start din egen lokale server op.

---

    Ved hjælp af XAMPP skal du starte din egen lokale server op, med den Wordpress mappe som er vedhæftet i opgaven.
    Du skal lave en ny database table med navn "wordpress", som du forbinder til Wordpress installationen.

2. GitHub repository

---

    Sørg for at den mappe i XAMPP er lavet til et GitHub repository.
    Vær opmærksom på at den mappe ikke er root mappen men theme mappen:
    \wp-content\themes\*DIT CHILD THEME*

3. GitIgnore

---

    Senere i opgaven skal du have node_modules i mappen og det skal vi ikke overfører over til GitHub.
    Sørg derfor for at oprette en .gitignore til mappen, som ignorer node_modules mappen.

4. Installér plugins på Wordpress

---

    Installér følgende plugins til Wordpress
    - Advanced Custom Fields
    - WooCommmerce

Opgave 2: Child Theme opsætning samt Custom Post Type i Wordpress

1. Lav child theme

---

    Opret et child theme udfra hvilket som helst parent theme.

2. Opsæt Bootstrap / SCSS / Gulp

---

    Opsæt Bootstrap på dit child theme så det kan benyttes.
    Samtidig med det skal du opsætte Gulp og Sass til projektet så du kan skrive SCSS.

    Derefter skal du sørge for at dit child theme får fat i main css filen, som bliver genereret af Gulp.

3. Opret et Custom Post Type

---

    I dit Child Theme skal du tilføje et Custom Post Type med navnet "Medarbejdere" samt taxonomy "Afdelinger" (functions.php)

    OBS: Sørg for at denne CPT (Custom Post Type) ikke har support til den klassiske Wordpress editor. Den skal ikke bruges til noget her.

4. Opret Custom Fields til denne Custom Post Type

---

    Ved hjælp af ACF (Advanced Custom Fields) skal du tilføje 2 custom fields til medarbejder CPT.
    1. Medarbejder stilling (Text field)
    2. Medarbejder direkte telefonnummer (Nummer)


5. Lav 8 eksempler

---

    Lav 8 eksempler på en medarbejder. En medarbejder skal have følgende informationer:
    1. Medarbejder navn (Titel på post)
    3. Medarbejder billede (Thumbnail) (Du skal anvende de billeder som ligger i mappen "Data" -> "billeder" -> "medarbejdere")
    4. Medarbejder stilling (ACF)
    5. Medarbejder direkte telefonnummer (ACF)
    6. Medarbejder afdeling (Taxonomy) (Eksempel - Udviklingsafdeling, Salgsafdeling etc.)

    Ud af de 8 medarbejdere skal du sørge for at du har 2 afdelinger med 4 medarbejdere i hver.
    Det kan være Udviklingsafdeling & Salgsafdeling.

# -----------------------------------------------

Opgave 3: Medarbejder side - Design

1. Ny sideskabelon og WP Query

---

    Opret en ny sideskabelon i koden, som importere både footer og header fra dit tema.
    OBS: Vi har vedlagt et design, som skal kopieres 1:1 på denne sideskabelon.
    Du kan finde designet på følgende sti:
    \Data\Billeder\medarbejderlisten.jpg

    Opret en ny side og anvend den nye sideskabelon

    På den nye sideskabelon skal du hente medarbejder listen med tilhørende information. (Se opgave 2 punkt 5)
    Anvend WP_Query til at hente medarbejderne og loop derefter igennem dem med PHP for at vise alle informationerne.

    Der skal både vises medarbejderens navn, billede, titel, afdeling og telefon nummer.
    Anvend både custom SCSS og Bootstrap til at opsætte siden.

2. Sortering efter kategori

---

    Lav en dropdown hvor du kan vælge de forskellige afdelinger, som en medarbejder kan være i (Kategorier).
    Derefter skal den køre en ny WP_Query (kan også anvende pre_get_posts), som kun tjekker efter den valgte afdeling.
    Hvis en bruger for eksempel kun vil se medarbejderne i "Udviklingsafdeling", skal de kunne trykke på denne dropdown og vælge "Udviklingsafdeling".

# BONUS OPGAVE

    Sørg for at den WP_Query til medarbejderne kun lytter efter URL og tager dens værdi til at køre WP_Query.
    Det gør at folk nu kan søge efter /medarbejdere/?afdeling=udviklingsafdeling
    Hvordan du sætter denne URL op er ikke så vigtig, men så længe en anden kan gå direkte til den URL for at se den bestemte afdelings medarbejdere.

# -----------------------------------------------

WooCommerce

# -----------------------------------------------

Opgave 4: Tilbuds produkter samt filtrering

1. Lav en ny side skabelon

---

    Lav en side skabelon mere som du kalder "Tilbud"
    Opret en ny side med titlen "Tilbud"

2. Importér datafilen fra mappen "Data", som hedder "tilbudsprodukter"

---

    Importér produkterne fra filen, du har modtaget i opgaven.

3. Vis alle produkter som er On Sale

---

    Vis alle produkterne i en række med produkt navn, beskrivelse, pris

4. Lav et filtreringssystem på siden

---

    Brugere skal kunne filtrere på produkterne som er On Sale.

    Filtreringer som de skal kunne lave er
    - Pris (Lav til høj og høj til lav)
    - Varekategori
    - Seneste produkter som er blevet oprettet

# -----------------------------------------------

Opgave 5: Udlejningsprodukter

1. Opret en varekategori

---

    Opret en varekategori som hedder "Udlejning"

2. Importér nye produkter

---

    Importér de vare under "udlejningsprodukter" filen, som du finder i opgave mappen under "Data".

    Tildel de forskellige produkter et billede, som du også har adgang til i opgave mappen.
    Tildel alle produkterne som du lige har tilføjet til din varekategori "Udlejning".

3. Custom Fields

---

    Lav custom fields så det er muligt at display "Daglig vejledende pris" - "Ugentlig vejledende pris" - "Månedlig vejledende pris"
    Der skal også være mulighed for at skrive et tilbud på de forskellige udlejningspriser.

    Selve opsætningen i Custom Fields styrer du helt selv, men tænk over hvordan det vil se ud for en, som skal sætte priser på et udlejningsprodukt, som de ikke har gjort før. Tænk user experience ind i strukturen af Custom Fields.

4. Gør det umuligt at købe udlejningsprodukter

---

    Du skal gøre det umuligt for brugere at kunne købe udlejningsprodukter direkte.

5. Gør det umuligt at skrive en normalpris og tilbudspris på udlejningsprodukter

---

    Gør det umuligt for admin at skrive en normal- eller tilbudspris på produktet, hvis produktet er et udlejningsprodukt.
    Normal- og tilbudspris er liggende ved "Product data" sektionen på et produkt.

6. Produkt side til udlejningsprodukter

---

    Opret en enkelt produkt side, som kun vises på udlejningsprodukterne, hvor du har følgende information på siden (Du bestemmer selv design):
    - Titlen på varen
    - Billede af varen
    - Beskrivelse af varen
    - Udlejningspriserne (Custom Fields)(Husk at vis tilbudsprisen også hvis den eksistere)
    - Relateret produkter

7. "Send en forespørgsel" sektion

---

    Brugerne kan ikke købe produktet, men de skal have mulighed for at sende en forespørgsel.

    Lav et input med "Email","Telefon nummer" og en knap "Send en forespørgsel".

    Når brugeren trykker på knappen skal du oprette en ny sektion under produktet men før relateret produkter, som viser følgende dynamiske besked.
    Bemærk indholdet i [] - Det skal være dynamisk indhold.

    "
    Du har sendt en forespørgsel fra [Email fra input] og [Telefon nummer fra input].
    Du har sendt en forespørgsel på følgende produkt:
    - [Produkt navn]
    - [Varekategori]
    - [Udlejningspriserne]
    - [Dato for forespørgsel]
    "

## Projekt struktur:

- Source
  | - Data
  | - billeder
  | - medarbejdere
  | - medarbejder_1.png
  | - medarbejder_2.png
  | - medarbejder_3.png
  | - medarbejder_4.png
  | - medarbejder_5.png
  | - medarbejder_6.png
  | - medarbejder_7.png
  | - medarbejder_8.png
  | - tilbudsprodukter
  | - product1.png
  | - product2.png
  | - product3.png
  | - udlejningsprodukter
  | - udlejningsprodukt_1.jpg
  | - udlejningsprodukt_2.jpg
  | - udlejningsprodukt_3.jpg
  | - tilbudsprodukter
  | - udlejningsprodukter
  | - tilbudsprodukter.csv
  | - udlejningsprodukter.csv
  | - wordpress (Alt til at starte Wordpress op)
  | - readme.md

## Bedømmelses kriterier:

- User Experience for Admin / Kunden
- Responsivt design
- Skalerbarhed
- Bedste praksis