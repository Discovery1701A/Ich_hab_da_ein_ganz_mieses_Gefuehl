<?php
/**
 * Model zu Aufgabe 3
 * @author  Anna Rieckmann
 * @ Formular
 */
class Model
{
    private function secure($bezeichnung) # überprüft den input auf html
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
    function transferpost($bezeichnung) # transferirt bestimmte Elemente der Post in die Session
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
?>