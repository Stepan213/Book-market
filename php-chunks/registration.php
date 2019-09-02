<p>Teď něco o tobě:</p>

E-Mail:<br>
<input type="email" name="mail" value="" required oninput="registerAutofill(this.value)"><br>

Jméno:<br>
<input type="text" id="username" name="username" value="" required><br>

Další kontakt(y) (FB, Snapchat, Telefon, atd.):<br>
<input type="text" id="othercontact" name="othercontact" value=""><br>

Heslo (pro pozdější editaci inzerátu):<br>
<input type="password" name="password" value="" required><br>

<label>
  Souhlasím se zveřejněním výše uvedených údajů.
  <input type="checkbox" name="legal[]" value="publish" required>
  <span></span>
</label>
<label>
  Souhlasím se <a href="gdpr.php">zpracováním osobních údajů</a><!-- a <a href="">smluvními podmínkami</a>-->.
  <input type="checkbox" name="legal[]" value="documents" required>
  <span></span>
</label><br>
