# Verificar quantidade de retalhos no Banco de dados
# Autor: Tiago Lucas Flach
# Data: 12/01/2023

# CONSTANTES
# --------------------------------------------------

# Fase 1
PATH_1 = r"F:/Programacao/07  Ardis"
PATH_1_ARDIS = f"{PATH_1}/Ardis" 
PATH_1_BACKUP = f"{PATH_1}/Backup"
PATH_1_POS_CONFERENCIA = f"{PATH_1}/pos-conferencia"

# Fase 2
PATH_2 = r"F:\Automação\ARDIS\Gerenciador Corte"								# Fabrica

PATH_2_NOVOS = f"{PATH_2}\\Data\\Novos"											# Fabrica
# PATH_2_NOVOS = f"{os.getcwd()}/Relatórios"
PATH_2_PRODUZIDOS = f"{PATH_2}\\Data\\Processados"								# Fabrica
PATH_2_PROBLEMAS = f"{PATH_2}\\Data\\Problemas"									# Fabrica
PATH_2_EXECUTAVEIS = f"{PATH}_2\\Executaveis"									# Fabrica
PATH_2_LOGS = f"{PATH_2_EXECUTAVEIS}"											# Fabrica

# API PHP
# --------------------------------------------------
API_PHP = 'http://10.1.1.86:8080/md-ardis/Fase%204/public/api/v1/'				# Fabrica
# API_PHP = 'http://' + socket.gethostbyname(socket.gethostname()) + '/md-ardis/Fase%204/public/api/projeto'

# API TOTVS
# --------------------------------------------------
BASE = 'MD-PROT'
CHAVE = '128964ard'
COD_EMITENTE = str(138449)
API_TOTVS = 'http://192.168.0.26:8888/scripts/cgiip.exe/WService='+ BASE +'/rsapi/rsapi015web?codChave=' + CHAVE + '?codEmitente=' + COD_EMITENTE