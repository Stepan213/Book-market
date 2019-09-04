<h1>Online burza učebnic</h1>
Webová aplikace, která umožňuje uživatelům přidávat a prohlížet inzeráty s nabídkami učebnic pro střední školy.

<h2>Instalace na server</h2>

<h3>Požadavky</h3>
<ul>
	<li>PHP 7</li>
	<li>MySQL</li>
	<li>Aspoň 5GB místa v úložišti (uživatelská data zahrnují fotky)</li>
</ul>

<h3>Příprava MySQL databáze</h3>
1. Oprávnění MySQL účtu projektu nastavte minimálně na SELECT, INSERT, UPDATE, DELETE<br>
2. Do databáze nahrajte oba soubory ze složky /mysql

<h3>Personalizace dokumentů</h3>
1. V souboru about.php uveďte kontaktní e-mail.<br>
2. Je třeba přidat obsah ohledně zásad ochrany osobních údajů do souboru gdpr.php<br>
3. Ideálně by měl vzniknout ještě dokument týkající se všeobecných smluvních podmínek. (Např. vyhrazení si práva na úpravu/výmaz dat uživatelů bez udání důvodu)

<h3>Přesun souborů na webserver</h3>
1. V souboru /php-chunks/mysql-credentials.php upravte přístupové údaje do MySQL databáze.<br>
2. Obsah složky /www zkopírujte do adresáře webserveru. (většinou www/)

<h2>Testování</h2>
Spuštěním skriptu [vasedomena]/mysql-test.php ověříte funkčnost spojení s MySQL databází.<br>

<h2>Deployment</h2>
Add additional notes about how to deploy this on a live system

<h2>Použité technologie</h2>
<ul>
	<li>MySQL</li>
	<li>Apache 2.4.39</li>
	<li>HTML5</li>
	<li>CSS3/SASS</li>
	<li>PHP 7.3.8</li>
	<li>JavaScript</li>
</ul>

<h2>Autoři</h2>
Programování - Štěpán Cimler<br>
Návrhy, testy, propagace - Jaroslav Pazourek, Lucie Procházková, Bára Motyčková, František Záhorec, Albert Bílek, Klára Hávová

<h2>Licence</h2>
Projekt je licencován pod licencí MIT License - pro detaily si přečtěte dokument LICENSE v hlavní složce projektu.
