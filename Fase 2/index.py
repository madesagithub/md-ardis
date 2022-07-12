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
					'data_processamento': row['data processamento'],
					'hora_processamento': row['hora processamento'],
				}

				fabrica = {
					'fabrica': row['unidade'].title(),
				}

				maquina = {
					'maquina': row['máquina'].title(),
				}

				usuario = {
					'usuario': row['usuário'].title(),
				}

				deposito = {
					'deposito': row['deposito'].upper(),	# renomear
				}

				plano = {
					'numero_layout'              : int(row['n° layout']) if row['n° layout'].isdigit() else row['n° layout'],
					'quantidade_chapa'           : int(row['quantidade de chapa']) if row['quantidade de chapa'].isdigit() else row['quantidade de chapa'],
					'metro_quadrado_chapa'       : float(row['m² da chapa']) if row['m² da chapa'] else row['m² da chapa'],
					'aproveitamento'             : float(row['aproveitamento']) if row['aproveitamento'] else row['aproveitamento'],
					'carregamentos'              : int(row['carregamentos']) if row['carregamentos'].isdigit() else row['carregamentos'],
					'tempo_corte'                : row['tempo corte'],
					'metro_cubico_plano'         : float(row['m³ total plano']) if row['m³ total plano'] else row['m³ total plano'],
					'quantidade_por_corte'       : int(row['quantidade por corte']) if row['quantidade por corte'].isdigit() else row['quantidade por corte'],
					'percentual_ocupacao_maquina': float(row['ocupação máquina']) if row['ocupação máquina'] else row['ocupação máquina'],
					'custo_por_metro'            : float(row['custo r$/m²']) if row['custo r$/m²'] else row['custo r$/m²'],
					'cortes_n1'                  : int(row['cortes n1']) if row['cortes n1'].isdigit() else row['cortes n1'],
					'cortes_n2'                  : int(row['cortes n2']) if row['cortes n2'].isdigit() else row['cortes n2'],
					'cortes_n3'                  : int(row['cortes n3']) if row['cortes n3'].isdigit() else row['cortes n3'],
				}

				peca = {
					'codigo_peca'                      : int(row['código peça erp']) if row['código peça erp'].isdigit() else row['código peça erp'],
					'descricao_peca'                   : row['descrição peça 2'] if row['descrição peça 2'] else row['descrição da peça'],
					'comprimento_peca_final'           : int(row['comprimento peça final']) if row['comprimento peça final'].isdigit() else 0,
					'largura_peca_final'               : int(row['largura peça final']) if row['largura peça final'].isdigit() else 0,
				}

				produto ={
					'referencia_item'                  : row['referência do item'],
				}

				lote = {
					'lote'                             : int(row['lote']) if row['lote'].isdigit() else row['lote'],
				}

				# Alterar para material?
				chapa = {
					'codigo_chapa_usado'   : int(row['código chapa erp usada']) if row['código chapa erp usada'].isdigit() else row['código chapa erp usada'],
					'classificacao_chapa'  : row['classificação da chapa'],
					'descricao_chapa'      : row['descrição da chapa'],
					'comprimento_chapa'    : int(row['comprimento chapa']) if row['comprimento chapa'].isdigit() else row['comprimento chapa'],
					'largura_chapa'        : int(row['largura chapa']) if row['largura chapa'].isdigit() else row['largura chapa'],
					'espessura_chapa'      : float(row['espessura chapa e peça']) if row['espessura chapa e peça'] else row['espessura chapa e peça'],
					# ----------
					'metro_quadrado_chapa' : float(row['m² da chapa']) if row['m² da chapa']else row['m² da chapa'],
					# ----------
					'codigo_chapa_cadastro': int(row['código chapa erp cadastro']) if row['código chapa erp cadastro'].isdigit() else row['código chapa erp cadastro'],
				}

				ordem = {
					# Identificador da ordem
					# ----------
					'comprimento_peca'                 : int(row['comprimento da peça']) if row['comprimento da peça'].isdigit() else row['comprimento da peça'],
					'largura_peca'                     : int(row['largura da peça']) if row['largura da peça'].isdigit() else row['largura da peça'],
					'espessura_peca'                   : float(row['espessura chapa e peça']) if row['espessura chapa e peça'] else row['espessura chapa e peça'],
					'quantidade_programada'            : int(row['quantidade programada']) if row['quantidade programada'].isdigit() else row['quantidade programada'],
					'quantidade_produzida'             : int(row['quantidade produzida']) if row['quantidade produzida'].isdigit() else row['quantidade produzida'],
					'metro_quadrado_bruto_peca'        : float(row['m² bruto peça']) if row['m² bruto peça'] else row['m² bruto peça'],
					'metro_quadrado_liquido_peca'      : float(row['m² líquido peça']) if row['m² líquido peça'] else row['m² líquido peça'],
					'metro_quadrado_liquido_total_peca': float(row['m² líquido total peça']) if row['m² líquido total peça'] else row['m² líqido total peça'],
					'metro_cubico_liquido_total_peca'  : float(row['m³ líquido total peça']) if row['m³ líquido total peça'] else row['m³ líquido total peça'],
					'pecas_superproducao'              : int(row['peças superprodução']) if row['peças superprodução'].isdigit() else 0,
					'metro_quadrado_superproducao'     : float(row['m² superprodução']) if row['m² superprodução'] else row['m² superprodução'],
					'percentual_peca_plano'            : float(row['% peça no plano']) if row['% peça no plano'] else row['% peça no plano'],
					'logica_ardis'                     : row['lógica ardis'],
					'nivel'                            : int(row['nível']) if row['nível'].isdigit() else row['nível'],
					'prioridade'                       : int(row['prioridade']) if row['prioridade'].isdigit() else 0,
					'percentual_produzido'             : float(row['% produzido']) if row['% produzido'] else 0,
					'data_embalagem'                   : row['data embalagem'],
				}

				insert = {}
				insert.update(cabecalho)
				insert.update(fabrica)
				insert.update(deposito)
				insert.update(maquina)
				insert.update(usuario)
				insert.update(plano)
				insert.update(peca)
				insert.update(produto)
				insert.update(lote)
				insert.update(chapa)
				insert.update(ordem)

				planos.append(insert)
		return planos


# --------------------------------------------------
# Baixa na TOTVS
# Movimentação (deposito -> fabrica)
def send_totvs(planos):
	for plano in planos:
		# MD-PROT - Sinaliza que a operação será feita na base de PROTÓTIPO
		base = 'MD-PROT'

		# Chave da operação, necessária para o servidor aceitar a conexão
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
path = os.getcwd() + '/Relatórios'
os.chdir(path)

# Get files list
files = os.listdir(path)
files = [file for file in files if file.endswith('.csv')]

# Get the last file
latest_file = max(files, key=os.path.getctime)

# ----------
planos = get_planos(latest_file)
print_planos(planos)
# send_totvs(planos)
send_php(planos)
# ----------
# General error: 1366 Incorrect integer value: &#039;CORTE 1X&#039; for column &#039;logica_ardis&#039; at row 1 (SQL: insert into `ordens` (`plano_id`, `peca_id`, `comprimento_peca`, `largura_peca`, `espessura_peca`, `quantidade_programada`, `quantidade_produzida`, `metro_quadrado_bruto_peca`, `metro_quadrado_liquido_peca`, `metro_quadrado_liquido_total_peca`, `metro_cubico_liquido_total_peca`, `pecas_superproducao`, `metro_quadrado_superproducao`, `percentual_peca_plano`, `lote_id`, `logica_ardis`, `nivel`, `prioridade`, `percentual_produzido`, `data_embalagem`, `updated_at`, `created_at`) values (3, 6, 613, 260, 15, 32, 140, 5.331238676, 0.15938, 5.10016, 0.0765024, 1, 0.17, 13.09748, 18, CORTE 1X, 0, 0, 22.9, 2022-07-06, 2022-07-11 13:44:27, 2022-07-11 13:44:27))