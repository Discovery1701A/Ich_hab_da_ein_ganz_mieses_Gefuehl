<?php
/**
 * Datei zu Aufgabe 2
 * @author  Anna Rieckmann
 * @ Formular
 */
class View
{
    function __construct($titlename,$model,$controller)
    {
        $this->model = $model;
        $this->controller = $controller;
        $this->titlename = $titlename;
    }
    function severInfomationen()
    {
        echo "ServerSignature: " . $_SERVER['SERVER_SIGNATURE'] . "<br>";
        echo "ServerSoftware (ServerTokens): " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
        echo "DocumentRoot: " . $_SERVER['DOCUMENT_ROOT'] . "<br><br><br><br></body>";
    }
    function titel()
    {
        echo "<h1 align=\"center\"> $this->titlename </h1><br>"; # Überschrift ausrichtung center
    }
    function eingabefelderband($bandAnzahl, $titelAnzahlliste)
    {
        for ($i = 1; $i <= $bandAnzahl; $i++) 
        {
            echo "<div align=\"center\">
            <label for=\"Band\">Band: </label><input type=\"text\" name=\"Veranstalltungsplan[$i" . "Band]\" id=\"Veranstalltungsplan[$i" . "Band]\" value = \"" . $_SESSION["Veranstalltungsplan"][$i . "Band"] . "\" ></div>";
            $this->senden("+", $i . "+");
            $this->senden("-", $i . "-");
            $titelAnzahl = $titelAnzahlliste[$i . "Band"];
            for ($e = 1; $e <= $titelAnzahl; $e++) 
            {
                echo "<div align=\"center\"><label for=\"Titel\">Titel: </label><input type=\"text\" name=\"Veranstalltungsplan[$e" . "Titel" . $i . "Band]\" id=\"Veranstalltungsplan[$e" . "Titel]\" value = \"" . $_SESSION["Veranstalltungsplan"][$e . "Titel" . $i . "Band"] . "\" >
                <label for=\"Länge\">Länge: </label><input type=\"number\" name=\"Veranstalltungsplan[$e" . "Minuten" . $i . "Band]\" id= \"Veranstalltungsplan[$e" . "Minuten" . $i . "Band]\"min=\"0\" max=\"59\" value = \"" . $_SESSION["Veranstalltungsplan"][$e . "Minuten" . $i . "Band"] . "\"> :
                <input type=\"number\" name=\"Veranstalltungsplan[$e" . "Sekunden" . $i . "Band]\" id= \"Veranstalltungsplan[$e" . "Sekunden" . $i . "Band]\" min=\"0\" max=\"59\" value = \"" . $_SESSION["Veranstalltungsplan"][$e . "Sekunden" . $i . "Band"] . "\" >
                <br><br></div>"; # variable eigabefelder
            }
        }
    }
    function eingabefelder($was, $namepost, $typ, $inhalt)
    {
        echo "<div align=\"center\"><label for=\"$namepost\">$was: </label>        
        <input type=\"$typ\" name=\"$namepost\" id=\"$namepost\" value = \"$inhalt\"><br><br></div>"; # variable eigabefelder
    }
    function datum($name, $was)
    {
        echo "<div align=\"center\"><label for=\"$name" . "[Datumfrom]\">$was: </label>  <input type=\"date\"name=\"$name" . "[Datumfrom]\"id=\"$name" . "[Datumfrom]\"></div> "; # Sende Button
        echo "<div align=\"center\"><label for=\"$name" . "[Datumto]\">$was: </label>  <input type=\"date\"name=\"$name" . "[Datumto]\"id=\"$name" . "[Datumto]\"></div> "; # Sende Button
    }
    function ausgabe($inhalt)
    {
        echo "<div align=\"center\">$inhalt<br><br></div>"; # wiedergabe der Eintraege 
    }
    function textarea($was, $namepost, $inhalt) # erstellt eine textarea
    {
        echo "<div align=\"center\"><label for=\"$namepost\">$was: </label>        
        <textarea name=\"$namepost\" rows=\"5\" cols=\"40\" value = \"$inhalt\"></textarea><br><br></div>"; # variable eigabefelder
    }
    function senden($aktion, $name) #sende button
    {
        echo "<div align=\"center\"><input type=\"submit\"name=\"$name\" value=\"$aktion\"style=\"background-color:#8df6ff;border-radius:12px;\"></div> "; # Sende Button 
    }
    function datumAusgabe()
    {
        if (!empty($_SESSION["Beschreibung"]["Datumfrom"]) && !empty($_SESSION["Beschreibung"]["Datumto"])) 
        {
            $datums = "ab den " . $_SESSION["Beschreibung"]["Datumfrom"] . " bis zum " . $_SESSION["Beschreibung"]["Datumto"];
        } elseif (!empty($_SESSION["Beschreibung"]["Datumfrom"])) 
        {
            $datums = "den " . $_SESSION["Beschreibung"]["Datumfrom"];
        } elseif (!empty($$_SESSION["Beschreibung"]["Datumto"])) 
        {
            $datums = "den " . $_SESSION["Beschreibung"]["Datumto"];
        } 
        else 
        {
            $datums = "";
        }
        return $datums;
    }
    function formKopf($methode, $action)
    {
        echo "<form method=\"$methode\" action=\"$action\">";
    }
    function seiteEins()
    {
        $this->controller->rechnerBand(); # anzahl der felder wird berechnet
        $this->controller->rechnerTitel($_SESSION["anzahl"]); # anzahl der felder wird berechnet
        $this->eingabefelderband($_SESSION["anzahl"], $_SESSION["titelanzahl"]); # band, title länge felder
        $this->senden("speichern", "speichern");
        $this->senden("Ausdruck", "Ausdruck");
        echo "<div align=\"center\"><a href= index.php?add=1>Einzufügen</a><br><br></div>"; # link fügt eine weitere zeile ein
        echo "<div align=\"center\"><a href= index.php?add=21>abziehen</a><br><br></div>"; # link fügt eine weitere zeile ein
    }
    function seiteZwei()
    {
        $this->eingabefelder("Name", "Beschreibung[Name]", "text", "GuteFrage");
        $this->eingabefelder("Ort", "Beschreibung[Ort]", "text", "Seattel");
        $this->datum("Beschreibung", "Datum");
        $this->textarea("Beschreibung", "Beschreibung[Beschreibung]", "Huhuhuhuhuhuh");
        $this->senden("weiter", "weiter");
    }
    function seiteDrei()
    {
        $this->ausgabe("Name: " . $_SESSION["Beschreibung"]["Name"]);
        $this->ausgabe("Ort: " . $_SESSION["Beschreibung"]["Ort"]);
        $this->ausgabe($this->datumausgabe());
        $this->ausgabe("Beschreibung: " . $_SESSION["Beschreibung"]["Beschreibung"]);
        for ($i = 1; $i <= $_SESSION["anzahl"]; $i++) 
        {
            $this->ausgabe("Band: " . $_SESSION["Veranstalltungsplan"][$i . "Band"]);
            for ($e = 1; $e <= $_SESSION["titelanzahl"][$i . "Band"]; $e++) 
            {
                $this->ausgabe(" Titel: " . $_SESSION["Veranstalltungsplan"][$e . "Titel" . $i . "Band"] . " Länge: " . $_SESSION["Veranstalltungsplan"][$e . "Minuten" . $i . "Band"] . " : " . $_SESSION["Veranstalltungsplan"][$e . "Sekunden" . $i . "Band"] . " min");
            }
        }
        $this->ausgabe($this->controller->rechnerZeit());
    }
}
class Model
{
    function secure($bezeichnung)
    {
        if (is_array($bezeichnung)) {
            $request = array();
            foreach ($bezeichnung as $key => $parameter) 
            {
                $request[$key] = strip_tags(trim(addslashes(htmlspecialchars($parameter))));
            }
            return $request;
        }
        else
        {
            $request= htmlspecialchars($bezeichnung);
            return $request;
        }
    }
    function transferpost($bezeichnung) # transferirt bestimmte Post in die Session
    {
        if (!empty($_POST[$bezeichnung])) 
        {
            $_SESSION[$bezeichnung] = $this->secure($_POST[$bezeichnung]);
        }
    }
    function transferget($bezeichnung) # transferirt bestimmte Get in die Session
    {
        if (!empty($_GET[$bezeichnung])) 
        {
            $_SESSION[$bezeichnung] = $this->secure($_GET[$bezeichnung]);
        }
    } 
}
class Controller
{
    function __construct($startanzahl)
    {
        $this->startanzahl = $startanzahl; 
    }
    function rechnerBand() # berechnet die anzahl der felder
    {
        if ($_SESSION["add"] == 1) 
        {
            $_SESSION["anzahl"] = intval($_SESSION["anzahl"]) + 1;
            $_SESSION["add"] = " ";
        }
        if (empty($_SESSION["add"]) ) 
        {
            $_SESSION["anzahl"] = $this->startanzahl;
        }
        if ($_SESSION["add"] == 21 && $_SESSION["anzahl"] > 1) 
        {
            $_SESSION["add"] = " ";
            $_SESSION["anzahl"] = intval($_SESSION["anzahl"]) - 1;
        }
    }
    function rechnerTitel($bandAnzahl)
    {
        for ($i = 1; $i <= $bandAnzahl; $i++) {
            if (empty($_SESSION["titelanzahl"][$i . "Band"])) 
            {
                $_SESSION["titelanzahl"][$i . "Band"] = 1;
            }
            if (!empty($_POST[$i . "+"]) && $_POST[$i . "+"] == "+") 
            {
                $_SESSION["titelanzahl"][$i . "Band"] += 1;
            } elseif (!empty($_POST[$i . "-"]) && $_POST[$i . "-"] == "-" && 1 < $_SESSION["titelanzahl"][$i . "Band"]) 
            {
                $_SESSION["titelanzahl"][$i . "Band"] -= 1;
            }
        }
    }
    function rechnerZeit()
    {
        for ($i = 1; $i <= $_SESSION["anzahl"]; $i++) 
        {
            for ($e = 1; $e <= $_SESSION["titelanzahl"][$i . "Band"]; $e++) 
            {
                $gesamtMinuten += intval($_SESSION["Veranstalltungsplan"][$e . "Minuten" . $i . "Band"]);
                $gesamtSekunden += intval($_SESSION["Veranstalltungsplan"][$e . "Sekunden" . $i . "Band"]);
            }
        }
        if ($gesamtSekunden > 59) 
        {
            if ($gesamtSekunden % 60 == 0) 
            {
                $gesamtMinuten += $gesamtSekunden / 60;
                $gesamtSekunden -= $gesamtSekunden;
            } 
            else 
            {
                $gesamtMinuten += ($gesamtSekunden - ($gesamtSekunden % 60)) / 60;
                $gesamtSekunden -= ($gesamtSekunden - ($gesamtSekunden % 60));
            }
        }
        if ($gesamtMinuten > 59) 
        {
            if ($gesamtMinuten % 60 == 0) 
            {
                $gesamtStunde += $gesamtMinuten / 60;
                $gesamtMinuten -= $gesamtMinuten;
            } 
            else 
            {
                $gesamtStunde += ($gesamtMinuten - ($gesamtMinuten % 60)) / 60;
                $gesamtMinuten -= ($gesamtMinuten - ($gesamtMinuten % 60));
            }
            $gesamtzeitausgabe = ($gesamtStunde . ":" . $gesamtMinuten . ":" . $gesamtSekunden) . " std.";
        } 
        else 
        {
            $gesamtzeitausgabe = ($gesamtMinuten . ":" . $gesamtSekunden) . " min.";
        }
        return $gesamtzeitausgabe;
    }
}
?>