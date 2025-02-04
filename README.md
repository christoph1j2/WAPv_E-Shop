# WAPv E-Shop
**************************************************************************
# 1. Návrh architektury a obsahu
## A. Funkční stuktura webu
### Úvodní stránka (Home)
* Úvodní text
* Navigace
### Katalog produktů
* Stránka se specifickým typem zboží
* Možnost třídění (cena, velikost ...)
### Detail produktu
* Jednotlivý produkt
* Popis, technické specifikace, ...
* Možnost přidat do košíku
### Košík a objednávka
* Přehled vybraných položek
* Možnost upravit / odstranit
* Formulář pro zadání dodacích a fakturačních údajů
* Přehled celkové ceny a možnost volby platební metody (nefunkční feature)
### Uživatelský účet
* Registrace
* Přihlášení
### Administrace
* Správa produktů (CRUD)
* Práva objednávek a zákazníků (CRUD)
### Ostatní
* Kontakty, podmínky, ...
## B. Technická architektura (MVC)
### Modely
- Product
- User
- Order
- ...
### View
- Šablony s využitím Latte
### Kontrolery
- Presentery
- Obsluha jednotlivých požadavků uživatele
- Zpracování dat z modelů a předání do šablon
## C. Databázový návrh
* Tabulka `products`: ID, název, popis, cena, kategorie, fotografie, skladem
* Tabulka `users`: ID, jméno, email, heslo (hash), adresa, telefon
* Tabulka `orders`: ID, user_id, date, celková_cena, stav
* Tabulka `order_items`: ID, order_id, product_id, počet_kusů
# 2. Rozdělení rolí v týmu
## Člen A:
### Design & frontend
* Návrh UI/UX, wireframy, tvorba responzivního designu s využitím Bootstrapu
* Implementace šablon v Latte
* ...
## Člen B:
### Databáze a datové modely
* Návrh ER diagramu a vytvoření databázové struktury
* Implementace datobých modelů
* ...
## Člen C:
### Business logika - backend
* Vývoj controllerů (presenterů) dle MVC
* Implementace obchodní logiky (správa objednávek, registrace, přihlašování, správa košíku ...)
* Zajištění bezpečnosti (validace vstupů, ochrana proti XSS/SQL Injection, hashování hesel)
# 3. Plán řízení projektu - SCRUM
## Návrh harmonogramu (sprinty)
### Sprint 0 - Příprava a návrh
* Definovat požadavky
* Vytvořit wireframy a základní design
* Navrhnout databázový model
* Repozitář + základní prostředí Nette
### Sprint 1 - Implementace základní architektury
* Tvorba základní MVC struktury
* Připojení k DB
* Funkční homepage
### Sprint 2 - Realizace katalogu a detailu produktu
* Implementace zobrazení produktů (katalog)
* Vypracovat detail produktu (+přidat do košíku)
* Bootstrap pro responzivní design
### Sprint 3 - Košík a objednávkový proces
* Vytvořit funkční košík
* Implementovat objednávkový proces a formuláře
* Validace uživatelských vstupů a základní bezpečnostní kontroly
### Sprint 4 - Uživatelský účet a administrace
* Realizovat registraci, přihlášení
* Vypracovat základní admin UI
### Sprint 5 - Testování, optimalizace a příprava prezentace
* Unit testing všech funkcí
* Ladění, optimalizace
* Finalizace a příprava prezentace
**************************************************************************
* NOTE: Nefinální
