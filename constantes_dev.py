# Verificar quantidade de retalhos no Banco de dados
# Autor: Tiago Lucas Flach
# Data: 12/01/2023

# CONSTANTES
# --------------------------------------------------

# Fase 1
PATH_1 = r"Fase 1/Files"

PATH_1_BACKUP = f"{PATH_1}/Backup"
PATH_1_POS_CONFERENCIA = f"{PATH_1}/Pos conferencia"

PATH_1_FV = f"{PATH_1}/FV"
PATH_1_FV_ARDIS = f"{PATH_1_FV}/FV_ARDIS"
PATH_1_FV_BACKUP = f"{PATH_1_FV}/FV_Backup"
PATH_1_FV_POS_CONFERENCIA = f"{PATH_1_FV}/FV_Pos conferencia"

PATH_1_FB = f"{PATH_1}/FB"
PATH_1_FB_ARDIS = f"{PATH_1_FB}/FB_ARDIS"
PATH_1_FB_BACKUP = f"{PATH_1_FB}/FB_Backup"
PATH_1_FB_POS_CONFERENCIA = f"{PATH_1_FB}/FB_Pos conferencia"

PATH_1_FV_SUB = f"{PATH_1_FV}/sub"
PATH_1_FB_SUB = f"{PATH_1_FB}/sub"


# Fase 2
PATH_2 = r"F:\Automação\ARDIS\Gerenciador Corte"								# Fabrica

PATH_2_NOVOS = f"{PATH_2}\\Data\\Novos"											# Fabrica
# PATH_2_NOVOS = f"{os.getcwd()}/Relatórios"
PATH_2_PRODUZIDOS = f"{PATH_2}\\Data\\Processados"								# Fabrica
PATH_2_PROBLEMAS = f"{PATH_2}\\Data\\Problemas"									# Fabrica
PATH_2_EXECUTAVEIS = f"{PATH_2}\\Executaveis"									# Fabrica
PATH_2_LOGS = f"{PATH_2_EXECUTAVEIS}"											# Fabrica

# API PHP
# --------------------------------------------------
API_PHP = 'http://localhost/md-ardis/Fase%204/public/api/v1/'
# API_PHP = 'http://' + socket.gethostbyname(socket.gethostname()) + '/md-ardis/Fase%204/public/api/v1/'

# API TOTVS
# --------------------------------------------------
BASE = 'MD-PROT'
CHAVE = '128964ard'
COD_EMITENTE = str(138449)
API_TOTVS = 'http://192.168.0.26:8888/scripts/cgiip.exe/WService='+ BASE +'/rsapi/rsapi015web?codChave=' + CHAVE + '?codEmitente=' + COD_EMITENTE