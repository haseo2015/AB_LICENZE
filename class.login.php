<?php
/**
 * Created by PhpStorm.
 * User: fabio
 * Date: 17/04/2016
 * Time: 17:25
 */

namespace login;
include_once "class.utils.php";
use utils\utils;



class login
{
    protected $licenza;
    protected $user;
    protected $codici;
    protected $tabella;
    protected $numeroAttivazioni;

    function __construct()
    {

        $u = new utils();
        $u->connect();
        
        $this->licenza = (isset($_REQUEST['NL'])) ? $u->anti_injection($_REQUEST['NL']) : null;
        $this->user = (isset($_REQUEST['NU'])) ? $u->anti_injection($_REQUEST['NU']) : null;
        $this->numeroAttivazioni = (isset($_REQUEST['NA'])) ? $u->anti_injection($_REQUEST['NA']) : null;
        $this->feature = (isset($_REQUEST['feature'])) ? $u->anti_injection($_REQUEST['feature']) : null;

        $this->codici = "";
        $this->tabella = "ab_licenze";

        if (!empty($this->feature)) {
            switch($this->feature){
                default:
                    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><errore>Feature non riconosciuta</errore>";
                break;
                case "doLogin":
                    $this->doLogin($this->licenza,$this->user,'l');
                break;
                case "doRegister":
                    $this->doLogin($this->licenza,$this->user,'r');
                    break;
                case "generaCodici":
                    login::generaCodici($this->numeroAttivazioni);
                break;
                case "eliminaLicenza":
                    login::eliminaLicenza($this->licenza);
                break;
                case "checkLicenza":
                    login::checkLicenza($this->licenza);
                break;
                case "attivaLicenza":
                    login::attivaLicenza($this->licenza);
                break;
                case "disattivaLicenza":
                    login::disattivaLicenza($this->licenza);
                break;
                case "incrementaLicenza":
                    login::incrementaLicenza($this->licenza,$this->numeroAttivazioni);
                break;
            }
        }

        /*if (!empty($this->licenza) AND !empty($this->user)) {
            $this->doLogin($this->licenza,$this->user);
        } else {
            login::loginForm();
        }*/

        //$this->doLogin($this->licenza,$this->user);
    }

    public static function loginForm(){
        $html = '<form action="">
                <input type="text" name="NL">
                <input type="text" name="NU">
                <button type="submit">LOGIN</button>
                </form>';
        echo $html;
    }

    public function doLogin($licenza,$user,$mode="l"){
        //echo __CLASS__ . "/" . __FUNCTION__;
        $_dati = array();
        $dati = array();
        $ut = array();
        $numrec = 0;
        // controllo preventivo sul codice licenza. Se il codice è sbagliato esco.
        utils::SelectTabelle("ab_licenze",array("*"),"where NL = '" . $licenza . "'", null, null,$numrec,$_dati);
        if (count($_dati) == 0){
            echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><errore>Licenza errata</errore>";
            return;
        }
        // se il codice è giusto proseguo con il tentativo di login
        utils::SelectTabelle("ab_licenze",array("*"),"where NL = '" . $licenza . "' AND attivo > 0 AND NU= '". $user ."'", null, null,$numrec,$dati);
        if (count($dati) === 0){
            // controllo che non ci sia già un altro username
            utils::SelectTabelle("ab_licenze",array("NU"),"where attivo > 0 AND NL = '" . $licenza . "'", null, null,$numrec,$ut);
            if (count($ut) > 0){
                // se trovo un nome utente Errore
                echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><errore>Licenza già assegnata</errore>";
            } else {
                // se NON trovo un nome utente lo assegno ed effettuo la registrazione
                if (empty($ut[0]["NU"]) && $mode='r'){
                    utils::UpdateTabella("ab_licenze", array("NU" => $user, "NA" => 1, "attivo" => 1),"NL = '".$licenza."'");
                    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><messaggio>codice assegnato</messaggio>";
                }
            }
        } else {
        // ho trovato un utente, controllo il numero di licenze
            if ($dati[0]["NA"] <= $dati[0]["NAMAX"]){
                if($dati[0]["attivo"] > 0){
                    if ($mode == 'r'){
                        utils::UpdateTabella("ab_licenze", array("NU" => $user, "NA" => $dati[0]["NA"]+1),"NL = '".$licenza."'");
                        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><messaggio>Licenza registrata</messaggio>";
                    } else {
                        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><messaggio>login OK</messaggio>";
                    }
                } else {
                    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><errore>Licenza disattivata</errore>";
                }
            } else {
                if ($mode == 'r') {
                    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><errore>Limite licenze raggiunto</errore>";
                }else{
                    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><errore>Login errata</errore>";
                }
            }
        }

    }
    //##############################################################
    // ###################### FEATURES
    public function generaCodici($quanti=1){
        //echo __FUNCTION__;
        $stringaCodici = "";
        for($i=1;$i<=$quanti;$i++){
            $codice = utils::SessioneCasuale(8);
            utils::InsertTabella($this->tabella,array("NL" => $codice));
            $stringaCodici .= $codice ."<br>";
        }
        //utils::trace("IL TUO CODICE GENERATO: <strong>" . $codice . "</strong>");
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><messaggio>Codici generati:<br> ".$stringaCodici."</messaggio>";
    }

    public function eliminaLicenza($licenza){
        utils::DeleteTabella($this->tabella,"where NL = '".$licenza."'");
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><messaggio>Licenza cancellata</messaggio>";
    }

    public function checkLicenza($licenza){
        $dati = array();
        utils::SelectTabelle("ab_licenze",array("*"),"where NL = '" . $licenza . "'", null, null,$numrec,$dati);
        utils::trace($dati);
    }

    public function attivaLicenza($licenza){
        utils::UpdateTabella("ab_licenze", array("attivo" => 1),"NL = '".$licenza."'");
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><messaggio>Licenza attivata</messaggio>";
    }

    public function disattivaLicenza($licenza){
        utils::UpdateTabella("ab_licenze", array("attivo" => -1),"NL = '".$licenza."'");
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><messaggio>Licenza disattivata</messaggio>";
    }

    public function incrementaLicenza($licenza,$attivazioni){
        utils::UpdateTabella("ab_licenze", array("NAMAX" => $attivazioni),"NL = '".$licenza."'");
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><messaggio>Licenza incrementata di ".$attivazioni." attivazioni</messaggio>";
    }

}


$n = new login();