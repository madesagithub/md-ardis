from os import walk
import csv
from datetime import datetime
import json
import os
import socket
import requests

# --------------------------------------------------
# Varredura de arquivo em busca das informações de planos
def get_planos(filename):
	planos = []
	data = []
	with open(filename, 'r', encoding='latin-1') as file_csv:
		
		# Tratamento de dados do arquivo
		# for line in file_csv:
			
		# 	# Quebra de coluna
		# 	# line = line.split('\t')
			
		# 	# Remover porcentagem e asteriscos
		# 	line = [x.replace('%', '') for x in line]
		# 	line = [x.replace('****', '100') for x in line]

		# 	# Remover caracteres desnecessários
		# 	line = [i for i in line if i != '' and i != '\n']
			
		# 	# Remover espaços
		# 	line = [x.strip() for x in line]
			
		# 	data.append(line)


		

		csv_reader = csv.DictReader(file_csv, delimiter='\t')

		# Remove espaços e torna minusculo
		headers = [head.strip().lower() for head in csv_reader.fieldnames]
		csv_reader.fieldnames = headers

		

		file_csv.readline()
		for row in csv_reader:
			
			# Remove espaços, % e asteriscos
			row = dict((k, v.strip()) for k, v in row.items())
			row = dict((k, v.replace('%', '')) for k, v in row.items())
			row = dict((k, v.replace('*****', '100')) for k, v in row.items())
			
			# Layout
			# C�digo chapa ERP
			# Desc. da chapa
			# Fam�lia da chapa
			# Espessura
			# Comp. chapa
			# Larg. Chapa
			# m� da chapa
			# Qtd chapa
			# m� total plano
			# Carregamentos
			# Qtd por corte
			# Aproveitamento
			# Ocupa��o Maq.
			# m� chapa
			# Custo R$/m�
			# Tempo corte
			# M�quina
			# Deposito
			# Cortes N1
			# Cortes N2
			# Cortes N3
			# % pe�a plano
			# C�digo pe�a ERP
			# Descri��o da pe�a
			# Comp. pe�a
			# Largura pe�a
			# m� liq. pe�a
			# Qdt prog.
			# m�  liq. total
			# m� liq.  total
			# m� bruto pe�a
			# Qtd  produzida
			# P�s sup. prod.
			# m� sup. prod.
			# Data embalagem
			# Refer�ncia
			# Lote
			# L�gica
			# Cod. chapa ERP
			# N�vel
			# Prioridade
			# Comp. p� final
			# Larg. p� final
			# % produzido
			# Nome arquivo data
			# Tipo dado
			# Usu�rio
			# Data proc.
			# Hora proc.
			# Unidade


			if row['tipo dado'] == 'DATA_PECA':


				# Dados do projeto
				cabecalho = {
					# 'nome_projeto'      : row[].upper(),
					'nome_arquivo'      : row['nome arquivo data'].upper(),
					'maquina'           : row['máquina'].title(),
					# 'tempo_maquina'     : data[0][5].strip(),
					'tempo_corte'     	: row['tempo_corte'],
					'data_processamento': row['data proc.'],
					'hora_processamento': row['hora proc.'],
					'fabrica'           : row['fábrica'],
					'usuario'           : row['usuário'].title(),
				}

				# layout = {
				# 	'numero_plano'        : int(line[0]),
				# 	'codigo_material'     : int(line[1]),
				# 	'descricao_material'  : line[2],
				# 	'comprimento_material': int(line[3]),
				# 	'largura_material'    : int(line[4]),
				# 	'quantidade_material' : int(line[5]),
				# 	'aproveitamento'      : float(line[6]),
				# 	'area_material'       : float(line[7]),
				# 	'tempo_processo'      : line[8],
				# 	'familia_material'    : line[9],
				# }

				chapa = {
					'codigo_chapa'           : row['codigo chapa erp'],
					'descricao_chapa'        : row['desc. da chapa'],
					'familia_chapa'          : row['familia da chapa'],
					'espessura_chapa'        : row['espessura'],
					'comprimento_chapa'      : row['comp. chapa'],
					'largura_chapa'          : row['larg. chapa'],
					'metro_quadrado_da_chapa': row['m² da chapa'],      # ?
					'metro_quadrado_chapa'   : row['m² chapa'],         # ?
					'quantidade_chapa'       : row['qtd chapa'],
				}

				plano = {
					'metro_quadrado_plano' : row['m² total plano'],
					'carregamentos'        : row['carregamentos'],
					'quantidade_por_corte' : row['qtd por corte'],
					'aproveitamento'       : row['aproveitamento'],
					'ocupacao_maquina'     : row['ocupação máquina'],
					'metro_quadrado_chapa' : row['m² chapa'],         # ?
					'custo_por_metro'      : row['custo r$/m²'],
					'tempo_corte'          : row['tempo corte'],
					'maquina'              : row['máquina'],
					'deposito'             : row['depósito'],
					'cortes_n1'            : row['cortes n1'],
					'cortes_n2'            : row['cortes n2'],
					'cortes_n3'            : row['cortes n3'],
					'percentual_peca_plano': row['% peça plano'],
				}

				peca = {
					'codigo_peca'                      : row['código peça erp'],
					'descricao_peca'                   : row['descrição da peça'],
					'comprimento_peca'                 : row['comp. peça'],
					'largura_peca'                     : row['larg. peça'],
					'metro_quadrado_liquido_peca'      : row['m² liq. peça'],
					'quantidade_programada'            : row['qtd prog.'],
					'metro_quadrado_liquido_total'     : row['m² liq. total'],
					'metro_cubico_liquido_total'       : row['m³ liq. total'],
					'metro_quadrado_bruto_peca'        : row['m² bruto peça'],
					'quantidade_produzida'             : row['qtd  produzida'],
					'pecas_superiores_produzidas'      : row['pçs sup. prod.'],
					'metro_quadrado_superior_produzido': row['m² sup. prod.'],
					'data_embalagem'                   : row['data embalagem'],
					'referencia'                       : row['referencia'],	# referencia peca
				}

				peca = {
					'numero_peca'     : int(line[0]),
					'codigo_peca'     : line[1],
					'descricao_peca'  : line[2],
					'comprimento_peca': int(line[3]),
					'largura_peca'    : int(line[4]),
					'quantidade_peca' : int(line[5]),
					'produzido'       : float(line[6]),
					'area_material'   : float(line[7]),
					'ordem'           : int(line[8]) if line[8] else line[8],
					'item_pai'        : int(line[9]) if line[9] else line[9],
					'cod_cadastro'    : int(line[10]) if line[10] else line[10],
					'qtd_ordem'       : int(line[11]),
					'logica_ardis'    : int(line[12]),
					'data_embalagem'  : datetime.strptime(line[7], '%d/%m/%y').strftime('%d/%m/%Y'),
				}

				insert = {}
				insert.update(cabecalho)
				# insert.update(plano)
				insert.update(peca)

				planos.append(insert)


			print(planos)
			exit()
		exit()

		# Dados do projeto
		# Dados do cabeçalho do arquivo
		fabrica = data[0][0]
		cabecalho = {
			  'nome_projeto'      : data[0][0].upper(),
			  'maquina'           : data[0][1].strip().title(),
			  'data_processamento': data[0][2],
			  'tempo_maquina'     : data[0][5].strip(),
			# 'hora_processamento': data[0][2],
			  'usuario'           : data[0][3].title(),
			# 'fabrica'           : ,
		}

		# Tamanhos das arrays de dados
		lens = [len(line) for line in data[1:-1]]
		lens = list(set(lens))
		lens.sort()

		# Varredura dos dados
		for line in data[1:-1]:
			
			# Cabeçalhos = min(lens)
			# Plano
			if len(line) == min(lens):

				# Arquivo de entrada
				# line[0] = No.               = numero_plano
				# line[1] = Código            = codigo_material
				# line[2] = Desc. Material    = descricao_material
				# line[3] = Comp.             = comprimento_material
				# line[4] = Larg.             = largura_material
				# line[5] = Qtd.              = quantidade_material
				# line[6] = %                 = aproveitamento
				# line[7] = m²                = area_material
				# line[8] = tempo de processo = tempo_processo
				# line[9] = Tipo de material  = familia_material

				plano = {
					'numero_plano'        : int(line[0]),
					'codigo_material'     : int(line[1]),
					'descricao_material'  : line[2],
					'comprimento_material': int(line[3]),
					'largura_material'    : int(line[4]),
					'quantidade_material' : int(line[5]),
					'aproveitamento'      : float(line[6]),
					'area_material'       : float(line[7]),
					'tempo_processo'      : line[8],
					'familia_material'    : line[9],
				}

			else:
				# Peça = max(lens)
				# line[0]  = #               = numero_peca
				# line[1]  = Código          = codigo_peca
				# line[2]  = Descrição       = descricao_peca
				# line[3]  = Comp.           = comprimento_peca
				# line[4]  = Larg.           = largura_peca
				# line[5]  = Qtd.            = quantidade_peca
				# line[6]  = Produzido       = produzido
				# line[7]  = m²              = area_material
				# line[8]  = Ordem           = ordem
				# line[9]  = item            = item_pai
				# line[10] = Código cadastro = cod_cadastro
				# line[11] = quantidade      = qtd_ordem
				# line[12] = lógica          = logica_ardis

				peca = {
					'numero_peca'     : int(line[0]),
					'codigo_peca'     : line[1],
					'descricao_peca'  : line[2],
					'comprimento_peca': int(line[3]),
					'largura_peca'    : int(line[4]),
					'quantidade_peca' : int(line[5]),
					'produzido'       : float(line[6]),
					'area_material'   : float(line[7]),
					'ordem'           : int(line[8]) if line[8] else line[8],
					'item_pai'        : int(line[9]) if line[9] else line[9],
					'cod_cadastro'    : int(line[10]) if line[10] else line[10],
					'qtd_ordem'       : int(line[11]),
					'logica_ardis'    : int(line[12]),
					'data_embalagem'  : datetime.strptime(line[7], '%d/%m/%y').strftime('%d/%m/%Y'),
				}

				insert = {}
				insert.update(cabecalho)
				insert.update(plano)
				insert.update(peca)

				planos.append(insert)

		return planos


# --------------------------------------------------
# Baixa na TOTVS
# Movimentação (deposito -> fabrica)
def send_totvs(planos):
	for plano in planos:
		# MD-PROT - Sinaliza que a operação será feita na base de PROTOTIPO
		sistema = 'MD-PROT'

		# Chave da operação, necessária para o servidor aceitar a conexão
		# codChave=128964ard
		cod_chave = '128964ard'

		# Item a ser movimentado estoque
		item = str(plano['codigo_material'])

		# Depósito de origem
		dep_origem = 'ALM'

		# Local de origem
		fabrica = 'FB'
		if fabrica == 'FB':
			loc_origem = 'ALMB-A'
		elif fabrica == 'FV':
			loc_origem = 'ALMV-A'

		# dep_dest à deposito destino
		dep_destino = 'FAB'
		# Local destino
		loc_destino = ''

		# Quantidade deve ser na unidade de medida cadastrada no sistema
		quantidade = (plano['comprimento_peca'] / 1000) * (plano['largura_peca'] / 1000) * plano['quantidade_peca']
		quantidade = str(quantidade)

		# Emitente ARDIS
		# codEmitente=138449
		cod_emitente = str(138449)

		# ----------

		# Api para comunicação com o TOTVS
		api_totvs = 'http://192.168.0.26:8888/scripts/cgiip.exe/WService=MD-PROT/rsapi/rsapi015web?codChave='+ cod_chave +'&Item='+ item +'&dep_orig='+ dep_origem +'&loc_orig='+ loc_origem +'&dep_dest='+ dep_destino +'&loc_dest='+ loc_destino +'&quantidade='+ quantidade +'&codEmitente=' + cod_emitente
		print(api_totvs)
		
		# response = requests.get(api)
		# response.content
		print(api_totvs)


# --------------------------------------------------
# Cadastrar no sistema de controle de chapas (php)
# Enviar para API
def send_php():
	# Converter dicionario em json
	planos = json.dumps(planos, indent = 4)

	ip_address = socket.gethostbyname(socket.gethostname())
	api_endpoint = 'http://' + ip_address + '/md-ardis/Fase%203/public/api/projeto'
	# api_endpoint = 'http://' + ip_address + ':8080/md-ardis/Fase%203/public/api/projeto'
	api_headers = {
		'Content-Type': 'application/json',
	}

	post = requests.post(url=api_endpoint, headers=api_headers, json=planos)
	# print(post.json())
	print(post.content)
	print(post.status_code)


# --------------------------------------------------
# Imprime os planos em formato json
def print_planos(planos):
	# Converter dicionario em json
	planos = json.dumps(planos, indent = 4)

	print(planos)


# --------------------------------------------------
# Main

path = 'Relatórios'
# os.chdir(path)

# Lista arquivos do diretório
# for file in os.listdir():
# 	# Check whether file is in text format or not
# 	if file.endswith(".txt"):
# 		file_path = f"{file}"

# 		get_planos(file_path)
		# planos = send_php()
		# print_planos(planos)

# cwd = os.getcwd()  # Get the current working directory (cwd)
# files = os.listdir(cwd)  # Get all the files in that directory
# print("Files in %r: %s" % (cwd, files))

# filename = 'Fase 2/FV25052205_23_22_LAYOUT.txt'
# filename = 'Fase 2/RELATORIO_PEÇAS.TXT'
# filename = 'Relatórios/G20070515Z.1_-_50006272022_151536_FV.csv'

filename = f'{path}/29062022_070710_300622 - 12_FV_data.csv'
# filename = f'{path}/29062022_082952_300622 - 12_FV_data.csv'

get_planos(filename)