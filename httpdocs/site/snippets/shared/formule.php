<script>
var theForm = document.forms["bankcalculator"];



function calculate () {

    var myVoorrijkosten = document.getElementById('voorrijkosten').value;
    var myAantalzitplaatsen = document.getElementById('aantalzitplaatsen').value;
    var myKeuze1leerofstof = document.getElementById('keuze1leerofstof').value;
    var myVastekussens = document.getElementById('vastekussens').value;
    var myLossekussens = document.getElementById('lossekussens').value;
    var myPrijskussens = document.getElementById('prijskussens').value;
    var myLosseofvastekussens = document.getElementById('losseofvastekussens').value;
    var myUitkomstaantalvastekussens = document.getElementById('uitkomstaantalvastekussens').value;
    var myUitkomstaantallossekussens = document.getElementById('uitkomstaantallossekussens').value;
    var myUitkomstontgeuren = document.getElementById('uitkomstontgeuren').value;
    var myUitkomstimpregneren = document.getElementById('uitkomstimpregneren').value;
    var myUitkomstreinigen = document.getElementById('uitkomstreinigen').value;
    var myEindtotaal = document.getElementById('eindtotaal').value;




//lerenbank

    if(document.getElementById('keuze1leerofstof').value == "leren bank") {
        //Do something

        var vastekussens = document.getElementById('vastekussens');
        var myVastekussens = 16.50;
        vastekussens.value = myVastekussens;

        var lossekussens = document.getElementById('lossekussens');
        var myLossekussens = 27.50;
        lossekussens.value = myLossekussens;

        var uitkomstaantallossekussens = document.getElementById('uitkomstaantallossekussens');
        var myUitkomstaantallossekussens = myAantalzitplaatsen * myLossekussens;
        uitkomstaantallossekussens.value = myUitkomstaantallossekussens;


        var uitkomstaantalvastekussens = document.getElementById('uitkomstaantalvastekussens');
        var myUitkomstaantalvastekussens = myAantalzitplaatsen * myVastekussens;
        uitkomstaantalvastekussens.value = myUitkomstaantalvastekussens;

    }

    if(document.getElementById('losseofvastekussens').value == "los") {

        var prijskussens = document.getElementById('prijskussens');
        var myPrijskussens = myUitkomstaantallossekussens + 0;
        prijskussens.value = myPrijskussens;

    }

    if(document.getElementById('losseofvastekussens').value == "vast") {

        var prijskussens = document.getElementById('prijskussens');
        var myPrijskussens = myUitkomstaantalvastekussens + 0;
        prijskussens.value = myPrijskussens;

    }
// einde leren bank

// Stoffen bank

    if(document.getElementById('keuze1leerofstof').value == "stoffen bank") {
        //Do something
        var vastekussens = document.getElementById('vastekussens');
        var myVastekussens = 11.00;
        vastekussens.value = myVastekussens;

        var lossekussens = document.getElementById('lossekussens');
        var myLossekussens = 16.50;
        lossekussens.value = myLossekussens;

        var uitkomstaantallossekussens = document.getElementById('uitkomstaantallossekussens');
        var myUitkomstaantallossekussens = myAantalzitplaatsen * myLossekussens;
        uitkomstaantallossekussens.value = myUitkomstaantallossekussens;

        var uitkomstaantalvastekussens = document.getElementById('uitkomstaantalvastekussens');
        var myUitkomstaantalvastekussens = myAantalzitplaatsen * myVastekussens;
        uitkomstaantalvastekussens.value = myUitkomstaantalvastekussens;
    }

    if(document.getElementById('losseofvastekussens').value == "los") {

        var prijskussens = document.getElementById('prijskussens');
        var myPrijskussens = myUitkomstaantallossekussens + 0;
        prijskussens.value = myPrijskussens;

    }

    if(document.getElementById('losseofvastekussens').value == "vast") {

        var prijskussens = document.getElementById('prijskussens');
        var myPrijskussens = myUitkomstaantalvastekussens + 0;
        prijskussens.value = myPrijskussens;

    }
// einde stoffen bank

// leren Fauteuil

    if(document.getElementById('keuze1leerofstof').value == "leren fauteuil") {
        //Do something
        var vastekussens = document.getElementById('vastekussens');
        var myVastekussens = 44.00;
        vastekussens.value = myVastekussens;

        var lossekussens = document.getElementById('lossekussens');
        var myLossekussens = 44.00;
        lossekussens.value = myLossekussens;

        var uitkomstaantallossekussens = document.getElementById('uitkomstaantallossekussens');
        var myUitkomstaantallossekussens = myAantalzitplaatsen * myLossekussens;
        uitkomstaantallossekussens.value = myUitkomstaantallossekussens;

        var uitkomstaantalvastekussens = document.getElementById('uitkomstaantalvastekussens');
        var myUitkomstaantalvastekussens = myAantalzitplaatsen * myVastekussens;
        uitkomstaantalvastekussens.value = myUitkomstaantalvastekussens;

    }

    if(document.getElementById('losseofvastekussens').value == "los") {

        var prijskussens = document.getElementById('prijskussens');
        var myPrijskussens = myUitkomstaantallossekussens + 0;
        prijskussens.value = myPrijskussens;

    }

    if(document.getElementById('losseofvastekussens').value == "vast") {

        var prijskussens = document.getElementById('prijskussens');
        var myPrijskussens = myUitkomstaantalvastekussens + 0;
        prijskussens.value = myPrijskussens;

    }

//einde leren fauteuil

//stoffen fauteuil

    if(document.getElementById('keuze1leerofstof').value == "stoffen fauteuil") {
        //Do something
        var vastekussens = document.getElementById('vastekussens');
        var myVastekussens = 22.00;
        vastekussens.value = myVastekussens;

        var lossekussens = document.getElementById('lossekussens');
        var myLossekussens = 22.00;
        lossekussens.value = myLossekussens;

        var uitkomstaantallossekussens = document.getElementById('uitkomstaantallossekussens');
        var myUitkomstaantallossekussens = myAantalzitplaatsen * myLossekussens;
        uitkomstaantallossekussens.value = myUitkomstaantallossekussens;

        var uitkomstaantalvastekussens = document.getElementById('uitkomstaantalvastekussens');
        var myUitkomstaantalvastekussens = myAantalzitplaatsen * myVastekussens;
        uitkomstaantalvastekussens.value = myUitkomstaantalvastekussens;

    }

    if(document.getElementById('losseofvastekussens').value == "los") {

        var prijskussens = document.getElementById('prijskussens');
        var myPrijskussens = myUitkomstaantallossekussens + 0;
        prijskussens.value = myPrijskussens;

    }

    if(document.getElementById('losseofvastekussens').value == "vast") {

        var prijskussens = document.getElementById('prijskussens');
        var myPrijskussens = myUitkomstaantalvastekussens + 0;
        prijskussens.value = myPrijskussens;

    }
//einde stoffen fauteuil

//leren eetstoelen

    if(document.getElementById('keuze1leerofstof').value == "leren eetstoel") {
        //Do something
        var vastekussens = document.getElementById('vastekussens');
        var myVastekussens = 22.00;
        vastekussens.value = myVastekussens;

        var lossekussens = document.getElementById('lossekussens');
        var myLossekussens = 22.00;
        lossekussens.value = myLossekussens;

        var uitkomstaantallossekussens = document.getElementById('uitkomstaantallossekussens');
        var myUitkomstaantallossekussens = myAantalzitplaatsen * myLossekussens;
        uitkomstaantallossekussens.value = myUitkomstaantallossekussens;

        var uitkomstaantalvastekussens = document.getElementById('uitkomstaantalvastekussens');
        var myUitkomstaantalvastekussens = myAantalzitplaatsen * myVastekussens;
        uitkomstaantalvastekussens.value = myUitkomstaantalvastekussens;

    }

    if(document.getElementById('losseofvastekussens').value == "los") {

        var prijskussens = document.getElementById('prijskussens');
        var myPrijskussens = myUitkomstaantallossekussens + 0;
        prijskussens.value = myPrijskussens;

    }

    if(document.getElementById('losseofvastekussens').value == "vast") {

        var prijskussens = document.getElementById('prijskussens');
        var myPrijskussens = myUitkomstaantalvastekussens + 0;
        prijskussens.value = myPrijskussens;

    }
//einde leren eetstoel



// leren hocker

    if(document.getElementById('keuze1leerofstof').value == "leren hocker") {
        //Do something
        var vastekussens = document.getElementById('vastekussens');
        var myVastekussens = 16.50;
        vastekussens.value = myVastekussens;

        var lossekussens = document.getElementById('lossekussens');
        var myLossekussens = 16.50;
        lossekussens.value = myLossekussens;

        var uitkomstaantallossekussens = document.getElementById('uitkomstaantallossekussens');
        var myUitkomstaantallossekussens = myAantalzitplaatsen * myLossekussens;
        uitkomstaantallossekussens.value = myUitkomstaantallossekussens;

        var uitkomstaantalvastekussens = document.getElementById('uitkomstaantalvastekussens');
        var myUitkomstaantalvastekussens = myAantalzitplaatsen * myVastekussens;
        uitkomstaantalvastekussens.value = myUitkomstaantalvastekussens;

    }

    if(document.getElementById('losseofvastekussens').value == "los") {

        var prijskussens = document.getElementById('prijskussens');
        var myPrijskussens = myUitkomstaantallossekussens + 0;
        prijskussens.value = myPrijskussens;

    }

    if(document.getElementById('losseofvastekussens').value == "vast") {

        var prijskussens = document.getElementById('prijskussens');
        var myPrijskussens = myUitkomstaantalvastekussens + 0;
        prijskussens.value = myPrijskussens;

    }	//eine leren hocker



// leren hocker

    if(document.getElementById('keuze1leerofstof').value == "stoffen hocker") {
        //Do something
        var vastekussens = document.getElementById('vastekussens');
        var myVastekussens = 11.00;
        vastekussens.value = myVastekussens;

        var lossekussens = document.getElementById('lossekussens');
        var myLossekussens = 11.00;
        lossekussens.value = myLossekussens;

        var uitkomstaantallossekussens = document.getElementById('uitkomstaantallossekussens');
        var myUitkomstaantallossekussens = myAantalzitplaatsen * myLossekussens;
        uitkomstaantallossekussens.value = myUitkomstaantallossekussens;

        var uitkomstaantalvastekussens = document.getElementById('uitkomstaantalvastekussens');
        var myUitkomstaantalvastekussens = myAantalzitplaatsen * myVastekussens;
        uitkomstaantalvastekussens.value = myUitkomstaantalvastekussens;

    }

    if(document.getElementById('losseofvastekussens').value == "los") {

        var prijskussens = document.getElementById('prijskussens');
        var myPrijskussens = myUitkomstaantallossekussens + 0;
        prijskussens.value = myPrijskussens;

    }

    if(document.getElementById('losseofvastekussens').value == "vast") {

        var prijskussens = document.getElementById('prijskussens');
        var myPrijskussens = myUitkomstaantalvastekussens + 0;
        prijskussens.value = myPrijskussens;

    }	//eine stoffen hocker



// stoffen eetstoelen
    if(document.getElementById('keuze1leerofstof').value == "stoffen eetstoelen") {
        //Do something
        var vastekussens = document.getElementById('vastekussens');
        var myVastekussens = 11.00;
        vastekussens.value = myVastekussens;

        var lossekussens = document.getElementById('lossekussens');
        var myLossekussens = 11.00;
        lossekussens.value = myLossekussens;

        var uitkomstaantallossekussens = document.getElementById('uitkomstaantallossekussens');
        var myUitkomstaantallossekussens = myAantalzitplaatsen * myLossekussens;
        uitkomstaantallossekussens.value = myUitkomstaantallossekussens;

        var uitkomstaantalvastekussens = document.getElementById('uitkomstaantalvastekussens');
        var myUitkomstaantalvastekussens = myAantalzitplaatsen * myVastekussens;
        uitkomstaantalvastekussens.value = myUitkomstaantalvastekussens;

    }

    if(document.getElementById('losseofvastekussens').value == "los") {

        var prijskussens = document.getElementById('prijskussens');
        var myPrijskussens = myUitkomstaantallossekussens + 0;
        prijskussens.value = myPrijskussens;

    }

    if(document.getElementById('losseofvastekussens').value == "vast") {

        var prijskussens = document.getElementById('prijskussens');
        var myPrijskussens = myUitkomstaantalvastekussens + 0;
        prijskussens.value = myPrijskussens;

    }

//einde stoffen eetstoelen

//impregneren
    if (document.getElementById('impregneren').checked) {

        var uitkomstimpregneren = document.getElementById('uitkomstimpregneren');
        var myUitkomstimpregneren = myAantalzitplaatsen * 5.50;
        uitkomstimpregneren.value = myUitkomstimpregneren; }
    else {
        var uitkomstimpregneren = document.getElementById('uitkomstimpregneren');
        var myUitkomstimpregneren = 0;
        uitkomstimpregneren.value = myUitkomstimpregneren;

    }

//ontgeuren
    if (document.getElementById('ontgeuren').checked) {

        var uitkomstontgeuren = document.getElementById('uitkomstontgeuren');
        var myUitkomstontgeuren = myAantalzitplaatsen * 5.50;
        uitkomstontgeuren.value = myUitkomstontgeuren; }
    else {
        var uitkomstontgeuren = document.getElementById('uitkomstontgeuren');
        var myUitkomstontgeuren = 0;
        uitkomstontgeuren.value = myUitkomstontgeuren;
    }

//Reinigen
    if (document.getElementById('reinigen').checked) {

        var uitkomstreinigen = document.getElementById('uitkomstreinigen');
        var myUitkomstreinigen = myAantalzitplaatsen * 5.50;
        uitkomstreinigen.value = myUitkomstreinigen; }
    else {
        var uitkomstreinigen = document.getElementById('uitkomstreinigen');
        var myUitkomstreinigen = 0;
        uitkomstreinigen.value = myUitkomstreinigen;
    }



// eind totaal




    var eindtotaal = document.getElementById('eindtotaal');
    var myEindtotaal = +myVoorrijkosten + +myUitkomstimpregneren + +myUitkomstontgeuren + +myUitkomstreinigen + +myPrijskussens ;
    eindtotaal.value = myEindtotaal.toFixed(2);




} //Einde calculate functie






</script>

<form method="post" id="bankcalculator">
    <span style="display:none;">  Subject: <input name="subject" type="text" value="Aanvraag via Bank-Reinigen.nl - Calculator" /><input id="voorrijkosten" value="67.00"></span>

    Soort meubel: <select id="keuze1leerofstof" onchange="calculate()" name="keuze1leerofstof">
        <option value="maakkeuze">Maak uw keuze</option>
        <option value="leren bank" name="Leren bank">Leren bank</option>
        <option value="leren fauteuil">Leren fauteuil</option>
        <option value="leren eetstoel">Leren eetstoelen</option>
        <option value="leren hocker">Leren hocker</option>
        <option value="stoffen bank">Stoffen bank</option>
        <option value="stoffen fauteuil">Stoffen fauteuil</option>
        <option value="stoffen eetstoelen">Stoffen eetstoelen</option>
        <option value="stoffen hocker">Stoffen Hocker</option>
    </select>
    <br />
    Aantal zitplaatsen:
    <select id="aantalzitplaatsen" onchange="calculate()" name="aantalzitplaatsen">
        <option value="maakkeuze">Maak uw keuze</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">2,5</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>


    </select>
    <br />
    Losse kussens of vaste kussens: <select id="losseofvastekussens" onchange="calculate()" name="losseofvastekussens">
        <option value="maakkeuze">Maak uw keuze</option>
        <option value="los">Losse kussens</option>
        <option value="vast">Vaste kussens</option>
    </select>
    <br />

    <div class="verbergen">Kosten per vast kussen <input id="vastekussens"> - Verborgen <br />
        Kosten per los kussen <input id="lossekussens"> - Verborgen </div>

    Wat wilt u laten doen: <br />

    <div class="checkkeuzecalc1">Reinigen<input type="checkbox" value="5" id="reinigen" name="reinigen" onchange="calculate()"> <div class="verbergen">Uitkomst <input id="uitkomstreinigen"></div></div>

    <div class="checkkeuzecalc">Ontgeuren<input type="checkbox" value="5" id="ontgeuren" name="ontgeuren" onchange="calculate()"> <div class="verbergen">Uitkomst <input id="uitkomstontgeuren"></div></div>

    <div class="checkkeuzecalc3">Impregneren<input type="checkbox" value="5" id="impregneren" name="impregneren" onchange="calculate()"> <div class="verbergen">Uitkomst <input id="uitkomstimpregneren"></div></div>


    <div class="verbergen">Kosten aantal vaste kussens <input id="uitkomstaantalvastekussens" value="0"> - Verborgen <br />
        Kosten aantal losse kussens <input id="uitkomstaantallossekussens" value="0"> - Verborgen <br />
        Prijs kussens zien <input id="prijskussens"> - Verborgen</div>



    <div class="dikgedrukt">Totaalprijs: &euro; <input id="eindtotaal" name="eindtotaal"></div>

    <h2>Maak een afspraak!</h2>
    Laat uw gegevens achter en wij nemen zo spoedig mogelijk contact met u op!
    <br />

    Naam: <input id="naam" name="naam" type="text" /><br />
    Email: <input name="email" type="text" required/><br />
    Straat + Huisnummer: <input name="adres" type="text" /><br />
    Postcode + Woonplaats: <input type="text" name="postcodeplaats" id="postcodeplaats" /><br />
    Telefoonnummer: <input name="telefoonnummer" id="telefoonnummer"/><br />
    Ik ga akkoord met de <a href="/cookieverklaring/">cookie verklaring</a> en <a href="/privacyverklaring/">privacy statement</a>.<input type="checkbox" required id="geenrbot"/><br />
    <br />
    <input type="submit" value="Verzenden">
</form>