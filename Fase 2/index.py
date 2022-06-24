import csv
from datetime import datetime
import json
import os
import socket
import requests

# varredura de diretório

# Lista arquivos do diretório atual
# cwd = os.getcwd()  # Get the current working directory (cwd)
# files = os.listdir(cwd)  # Get all the files in that directory
# print("Files in %r: %s" % (cwd, files))

planos = []

# filename = 'Fase 2/FV25052205_23_22_LAYOUT.txt'
filename = 'Fase 2/RELATORIO_PEÇAS.TXT'
data = []
with open(filename, 'r') as file_txt:
	for line in file_txt:
		
		line = line.split('\t')
		
		# Remover porcentagem e asteriscos
		line = [x.replace('%', '') for x in line]
		line = [x.replace('****', '100') for x in line]

		# Remover caracteres desnecessários
		line = [i for i in line if i != '' and i != '\n']
		
		# Remover espaços
		line = [x.strip() for x in line]
		
		data.append(line)

	# Dados do projeto
	# Dados do cabeçalho do arquivo
	fabrica = data[0][0]
	cabecalho = {
		'nome_projeto': data[0][0].upper(),
		'maquina': data[0][1].strip().title(),
		'data_processamento': data[0][2],
		'tempo_maquina': data[0][5].strip(),
		# 'hora_processamento': data[0][2],
		'usuario': data[0][3].title(),
		# 'fabrica': ,
	}

	# Tamanhos das arrays de dados
	lens = [len(line) for line in data[1:-1]]
	lens = list(set(lens))
	lens.sort()

	for line in data[1:-1]:
		
		# Cabeçalhos = min(lens)
		# Plano
		if len(line) == min(lens):

			# Arquivo de entrada
			# line[0]	= No.					= numero_plano
			# line[1] 	= %						= aproveitamento
			# line[2] 	= Desc. Material		= descricao_material
			# line[3] 	= Código				= codigo_material
			# line[4]	= Comp.					= comprimento_material
			# line[5]	= Larg.					= largura_material
			# line[6]	= Qtd.					= quantidade_material
			# line[7]	= tempo de processo		= tempo_processo
			# line[8]	= m²					= area_material

			plano = {
				'numero_plano': int(line[0]),
				'aproveitamento': float(line[1]),
				'descricao_material': line[2],
				'codigo_material': int(line[3]),
				'comprimento_material': int(line[4]),
				'largura_material': int(line[5]),
				'quantidade_material': int(line[6]),
				'tempo_processo': line[7],
				'area_material': float(line[8])
			}

		else:
			# Peça = max(lens)

			# Arquivo de entrada
			# line[0]	= #					= numero_peca
			# line[1] 	= Código			= codigo_peca
			# line[2] 	= Descrição			= descricao_peca
			# line[3]	= Comp.				= comprimento_peca
			# line[4]	= Larg.				= largura_peca
			# line[5] 	= Qtd.				= quantidade_peca
			# line[6]	= Ordem				= ordem
			# line[7]	= Data				= data_embalagem
			# line[8]	= Produzido			= produzido
			# line[9]	= Código cadastro	= cod_cadastro

			peca = {
				'numero_peca': int(line[0]),
				'codigo_peca': line[1],
				'descricao_peca': line[2],
				'comprimento_peca': int(line[3]),
				'largura_peca': int(line[4]),
				'quantidade_peca': int(line[5]),
				'ordem': int(line[6]) if line[6] else line[6],
				'data_embalagem': datetime.strptime(line[7], '%d/%m/%y').strftime('%d/%m/%Y'),
				'produzido': float(line[8]),
				'cod_cadastro': int(line[9]) if line[9] else line[9]
			}

			insert = {}
			insert.update(cabecalho)
			insert.update(plano)
			insert.update(peca)

			planos.append(insert)


# --------------------------------------------------
# Baixa na TOTVS
# Movimentação (deposito -> fabrica)
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
	# print(api_totvs)


# --------------------------------------------------
# Cadastrar no sistema de controle de chapas (php)

# Converter dicionario em json
planos = json.dumps(planos, indent = 4)
print(planos)


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