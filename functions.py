# Verificar quantidade de retalhos no Banco de dados
# Autor: Tiago Lucas Flach
# Data: 13/01/2023

from os import walk
import csv
import json
import os

# --------------------------------------------------
# Varredura de arquivo em busca das informações de planos
def get_planos(filename):
	planos = []
	with open(filename, 'r', encoding='latin-1') as file_csv:

		csv_reader = csv.DictReader(file_csv, delimiter=';')

		# Remove espaços e torna minusculo
		headers = [head.strip().lower() for head in csv_reader.fieldnames]
		csv_reader.fieldnames = headers

		file_csv.readline()
		for row in csv_reader:

			# N° Layout						Plano
			# Código chapa ERP usada		Chapa ↓
			# Descrição da chapa
			# Classificação da chapa
			# Espessura chapa e peça
			# Comprimento chapa
			# Largura Chapa
			# m² da chapa
			# Quantidade de chapa
			# m³ total plano				Plano ↓
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
			# Código peça ERP				Peça ↓
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
			# Nome arquivo data				Cabeçalho ↓
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

			if row['tipo dado'] == 'DATA_PECA':
				# Dados do projeto
				cabecalho = {
					'nome_arquivo'      : row['nome arquivo data'].upper(),
					'data_processamento': row['data processamento'],
					'hora_processamento': row['hora processamento'],
				}

				fabrica = {
					'fabrica': row['unidade'].upper(),
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
					'codigo_peca'                : int(row['código peça erp']) if row['código peça erp'].isdigit() else row['código peça erp'],
					'descricao_peca'             : row['descrição peça 2'] if row['descrição peça 2'] else row['descrição da peça'],
					'comprimento_peca_final'     : int(row['comprimento peça final']) if row['comprimento peça final'].isdigit() else 0,
					'largura_peca_final'         : int(row['largura peça final']) if row['largura peça final'].isdigit() else 0,
				}

				produto ={
					'referencia_item'            : row['referência do item'],
				}

				lote = {
					'lote'                       : int(row['lote']) if row['lote'].isdigit() else row['lote'],
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
# Obter o último arquivo de um diretório
def get_lasted_file(dir, ext):
	script_path = os.path.dirname(os.path.realpath(__file__))
	dir = os.path.join(script_path, dir)
	
	os.chdir(dir)
	# Get files list
	files = os.listdir(dir)

	# Filter files by extension
	files = [file for file in files if file.endswith('.' + ext)]

	# Get the last file
	latest_file = None
	if len(files) > 0:
		latest_file = max(files, key=os.path.getctime)

	return latest_file


# --------------------------------------------------
# Imprime os planos em formato json
def print_planos(planos):
	# Converter dicionario em json
	planos = json.dumps(planos, indent = 4)

	print(planos)


# --------------------------------------------------
# Converter string para camel case
def to_camel_case(snake_str):
    components = snake_str.split('_')

    return components[0] + ''.join(x.title() for x in components[1:])