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

		csv_reader = csv.DictReader(file_csv, delimiter=';')

		# Remove espaços e torna minusculo
		headers = [head.strip().lower() for head in csv_reader.fieldnames]
		csv_reader.fieldnames = headers

		file_csv.readline()
		for row in csv_reader:

			# N° Layout						Plano
			# Código chapa ERP usada		Chapa
			# Descrição da chapa
			# Classificação da chapa
			# Espessura chapa e peça
			# Comprimento chapa
			# Largura Chapa
			# m² da chapa
			# Quantidade de chapa
			# m³ total plano				Plano
			# Carregamentos
			# Quantidade por corte
			# Aproveitamento
			# Ocupação Máquina
			# m² total
			# Custo R$/m²
			# Tempo corte
			# Máquina
			# Deposito
			# Cortes N1
			# Cortes N2
			# Cortes N3
			# % peça no plano
			# Código peça ERP				Peça
			# Descrição da peça
			# Comprimento da peça
			# Largura da peça
			# m² líquido peça
			# Quantidade programada
			# m² líquido total peça
			# m³ líquido total peça
			# m² bruto peça
			# Quantidade produzida
			# Peças superprodução
			# m² superprodução
			# Data embalagem
			# Referência do item
			# Lote
			# Lógica Ardis
			# Código chapa ERP Cadastro
			# Nível
			# Prioridade
			# Comprimento peça final
			# Largura peça final
			# % produzido
			# Nome arquivo data				Cabeçalho
			# Tipo dado
			# Usuário
			# Data processamento
			# Hora processamento
			# Unidade
			# Descrição Peça 2

			# Remove espaços, % e asteriscos
			row = dict((k, v.strip()) for k, v in row.items())
			row = dict((k, v.replace('%', '')) for k, v in row.items())
			row = dict((k, v.replace('*****', '100')) for k, v in row.items())

			if row['tipo dado'] == 'DATA_PEÇA':

				# Dados do projeto
				cabecalho = {
					'nome_arquivo'      : row['nome arquivo data'].upper(),
					'tempo_corte'     	: row['tempo corte'],
					'data_processamento': row['data processamento'],
					'hora_processamento': row['hora processamento'],
					'fabrica'           : row['unidade'].title(),
					# ----------
					'maquina'           : row['máquina'].title(),
					# ----------
					'usuario'           : row['usuário'].title(),
				}

				plano = {
					'numero_layout'              : int(row['n° layout']) if row['n° layout'].isdigit() else row['n° layout'],
					'metro_cubico_plano'         : float(row['m³ total plano']) if row['m³ total plano'] else row['m³ total plano'],
					'carregamentos'              : int(row['carregamentos']) if row['carregamentos'].isdigit() else row['carregamentos'],
					'quantidade_por_corte'       : row['quantidade por corte'],
					'aproveitamento'             : float(row['aproveitamento']) if row['aproveitamento'] else row['aproveitamento'],
					'percentual_ocupacao_maquina': float(row['ocupação máquina']) if row['ocupação máquina'] else row['ocupação máquina'],
					'metro_quadrado_chapa'       : float(row['m² da chapa']) if row['m² da chapa'] else row['m² da chapa'],
					'custo_por_metro'            : float(row['custo r$/m²']) if row['custo r$/m²'] else row['custo r$/m²'],
					'tempo_corte'                : row['tempo corte'],
					'deposito'                   : row['deposito'].upper(),
					'cortes_n1'                  : int(row['cortes n1']) if row['cortes n1'].isdigit() else row['cortes n1'],
					'cortes_n2'                  : int(row['cortes n2']) if row['cortes n2'].isdigit() else row['cortes n2'],
					'cortes_n3'                  : int(row['cortes n3']) if row['cortes n3'].isdigit() else row['cortes n3'],
					'percentual_peca_plano'      : float(row['% peça no plano']) if row['% peça no plano'] else row['% peça no plano'],
				}

				peca = {
					'codigo_peca'                      : int(row['código peça erp']) if row['código peça erp'].isdigit() else row['código peça erp'],
					# 'descricao_peca'                   : row['descrição da peça'],
					'descricao_peca'                   : row['descrição peça 2'],
					'comprimento_peca_final'           : int(row['comprimento peça final']) if row['comprimento peça final'].isdigit() else 0,
					'largura_peca_final'               : int(row['largura peça final']) if row['largura peça final'].isdigit() else 0,
					# ----------
					'referencia_item'                  : row['referência do item'],
					'comprimento_peca'                 : int(row['comprimento da peça']) if row['comprimento da peça'].isdigit() else row['comprimento da peça'],
					'largura_peca'                     : int(row['largura da peça']) if row['largura da peça'].isdigit() else row['largura da peça'],
					'espessura_peca'                   : float(row['espessura chapa e peça']) if row['espessura chapa e peça'] else row['espessura chapa e peça'],
					'quantidade_programada'            : int(row['quantidade programada']) if row['quantidade programada'].isdigit() else row['quantidade programada'],
					'metro_quadrado_liquido_peca'      : float(row['m² líquido peça']) if row['m² líquido peça'] else row['m² líquido peça'],
					'metro_quadrado_liquido_total_peca': float(row['m² líquido total peça']) if row['m² líquido total peça'] else row['m² líqido total peça'],
					'metro_cubico_liquido_total_peca'  : float(row['m³ líquido total peça']) if row['m³ líquido total peça'] else row['m³ líquido total peça'],
					'metro_quadrado_bruto_peca'        : float(row['m² bruto peça']) if row['m² bruto peça'] else row['m² bruto peça'],
					'quantidade_produzida'             : int(row['quantidade produzida']) if row['quantidade produzida'].isdigit() else row['quantidade produzida'],
					'pecas_superproducao'              : int(row['peças superprodução']) if row['peças superprodução'].isdigit() else 0,
					'metro_quadrado_superproducao'     : float(row['m² superprodução']) if row['m² superprodução'] else row['m² superprodução'],
					'lote'                             : int(row['lote']) if row['lote'].isdigit() else row['lote'],
					'logica_ardis'                     : row['lógica ardis'],
					'nivel'                            : int(row['nível']) if row['nível'].isdigit() else row['nível'],
					'prioridade'                       : int(row['prioridade']) if row['prioridade'].isdigit() else 0,
					'percentual_produzido'             : float(row['% produzido']) if row['% produzido'] else 0,
					'data_embalagem'                   : row['data embalagem'],
				}

				# Alterar para material?
				chapa = {
					'codigo_chapa_usado'   : int(row['código chapa erp usada']) if row['código chapa erp usada'].isdigit() else row['código chapa erp usada'],
					'descricao_chapa'      : row['descrição da chapa'],
					'classificacao_chapa'  : row['classificação da chapa'],
					'comprimento_chapa'    : int(row['comprimento chapa']) if row['comprimento chapa'].isdigit() else row['comprimento chapa'],
					'largura_chapa'        : int(row['largura chapa']) if row['largura chapa'].isdigit() else row['largura chapa'],
					'espessura_chapa'      : float(row['espessura chapa e peça']) if row['espessura chapa e peça'] else row['espessura chapa e peça'],
					# ----------
					'metro_quadrado_chapa' : float(row['m² da chapa']) if row['m² da chapa']else row['m² da chapa'],
					'quantidade_chapa'     : int(row['quantidade de chapa']) if row['quantidade de chapa'].isdigit() else row['quantidade de chapa'],
					# ----------
					'codigo_chapa_cadastro': int(row['código chapa erp cadastro']) if row['código chapa erp cadastro'].isdigit() else row['código chapa erp cadastro'],
				}

				insert = {}
				insert.update(cabecalho)
				insert.update(plano)
				insert.update(peca)
				insert.update(chapa)

				planos.append(insert)
		return planos


# --------------------------------------------------
# Baixa na TOTVS
# Movimentação (deposito -> fabrica)
def send_totvs(planos):
	for plano in planos:
		# MD-PROT - Sinaliza que a operação será feita na base de PROTOTIPO
		base = 'MD-PROT'

		# Chave da operação, necessária para o servidor aceitar a conexão
		# codChave=128964ard
		cod_chave = '128964ard'

		# Item a ser movimentado estoque
		item = str(plano['codigo_chapa_usado'])

		# Depósito de origem
		dep_origem = 'ALM'

		# Local de origem
		fabrica = str(plano['fabrica']).split()
		fabrica = [value[0].upper() for value in fabrica]
		fabrica = ''.join(fabrica)

		if fabrica == 'FB':
			loc_origem = 'ALMB-A'
		elif fabrica == 'FV':
			loc_origem = 'ALMV-A'

		# dep_dest à deposito destino
		dep_destino = 'FAB'

		# Local destino
		loc_destino = ''

		# Quantidade deve ser na unidade de medida cadastrada no sistema
		quantidade = str(plano['metro_quadrado_bruto_peca']).replace('.', ',')

		# Emitente ARDIS
		# codEmitente=138449
		cod_emitente = str(138449)

		# ----------

		# Api para comunicação com o TOTVS
		api_totvs = 'http://192.168.0.26:8888/scripts/cgiip.exe/WService='+ base +'/rsapi/rsapi015web?codChave='+ cod_chave +'&Item='+ item +'&dep_orig='+ dep_origem +'&loc_orig='+ loc_origem +'&dep_dest='+ dep_destino +'&loc_dest='+ loc_destino +'&quantidade='+ quantidade +'&codEmitente=' + cod_emitente

		# response = requests.get(api)
		# response.content
		print(api_totvs)


# --------------------------------------------------
# Cadastrar no sistema de controle de chapas (php)
# Enviar para API
def send_php(planos):
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

# path = 'Relatórios'
# filename = f'{path}/29062022_070710_300622 - 12_FV_data.csv'

path = 'F:\Automação\ARDIS\Data\Eng'
os.chdir(path)

# Get files list
files = os.listdir(path)
files = [file for file in files if file.endswith('.csv')]

# Get the last file
latest_file = max(files, key=os.path.getctime)

planos = get_planos(latest_file)
print_planos(planos)
# send_totvs(planos)
# send_php(planos)

# # Lista arquivos do diretório
# for file in os.listdir():
# 	# Check whether file is in text format or not

# 	if file.endswith(".csv"):
# 		file_path = f"{file}"

# 		planos = get_planos(file_path)
# 		# send_php(planos)
# 		print_planos(planos)

# cwd = os.getcwd()  # Get the current working directory (cwd)
# files = os.listdir(cwd)  # Get all the files in that directory
# print("Files in %r: %s" % (cwd, files))