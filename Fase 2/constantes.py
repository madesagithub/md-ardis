# Verificar quantidade de retalhos no Banco de dados
# Autor: Tiago Lucas Flach
# Data: 12/01/2023

# CONSTANTES
# --------------------------------------------------
PATH = r"F:\Automação\ARDIS\Gerenciador Corte"									# Fabrica

PATH_NOVOS = f"{PATH}\\Data\\Novos"												# Fabrica
# PATH_NOVOS = f"{os.getcwd()}/Relatórios"
PATH_PRODUZIDOS = f"{PATH}\\Data\\Processados"									# Fabrica
PATH_PROBLEMAS = f"{PATH}\\Data\\Problemas"										# Fabrica
PATH_EXECUTAVEIS = f"{PATH}\\Executaveis"										# Fabrica
PATH_LOGS = f"{PATH_EXECUTAVEIS}"												# Fabrica

API_PHP = 'http://10.1.1.86:8080/md-ardis/Fase%203/public/api/v1/'				# Fabrica
# API_PHP = 'http://' + socket.gethostbyname(socket.gethostname()) + '/md-ardis/Fase%203/public/api/projeto'

# API TOTVS
# --------------------------------------------------
BASE = 'MD-PROT'
CHAVE = '128964ard'
COD_EMITENTE = str(138449)
API_TOTVS = 'http://192.168.0.26:8888/scripts/cgiip.exe/WService='+ BASE +'/rsapi/rsapi015web?codChave=' + CHAVE + '?codEmitente=' + COD_EMITENTE