# AB_LICENZE
Servizio di Login basato su licenza e nome utente con un massimo di attivazioni.
Servizi:

– Registrazione (passo numero licenza e nome utente):
    Controllo numero Licenza:
    NL è valido e NU vuoto → aggiungo NU / NA +1 / Attivo SI
    NL non è valido → ERRORE
    NL è valido e NU è già presente
    NU è diverso → ERRORE
    NU è uguale
    Se NA è < 2 → NA +1
    Se NA è == 2 → ERRORE

– Login (passo numero licenza e nome utente):
  Controllo numero Licenza e Nome Utente
  NL non è valido → ERRORE
  NL è valido
  NU è diverso → ERRORE
  NU è uguale
  Se Attivo è == SI → Log­in OK
  Se Attivo è == NO → ERRORE

- 18.04.16 :: FEATURE
Le feature si utilizzano chiamando in stringa il parametro feature con il nome della feature e i parametri annessi
- generaCodici[NA] = genera [NA] codici
- eliminaLicenza[NL] = elimina la licenza specificata
- checkLicenza [NL] = restituisce i dati associati a quella licenza
- attivaLicenza [NL] = attiva la licenza impostando il parametro attivo a 1
- disattivaLicenza [NL] = disattiva la licenza impostando il parametro attivo a -1
- incrementaLicenza [NL, NA] = incrementa il numero di attivazioni massime [NAMAX] della licenza [NL]

- 19.04.16 :: INSTALLAZIONE
- basta richiamare/includere la classe login per farla funzionare. In caso di necessità di index, creare file index e
includere la classe login.
- aggiunto servizio di login: ?feature=doLogin [NU, NL]

- 21.04.16 :: AGGIORNAMENTO
- aggiunta feature registrazione nome chiamata doRegister
- migliorata la classe login con aggiunta parametri per registrazione