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
