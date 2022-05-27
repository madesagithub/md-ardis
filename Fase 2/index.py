import csv
from datetime import datetime
import json
import os
import requests

# varredura de diretório

# Lista arquivos do diretório atual
# cwd = os.getcwd()  # Get the current working directory (cwd)
# files = os.listdir(cwd)  # Get all the files in that directory
# print("Files in %r: %s" % (cwd, files))

planos = []

filename = 'Fase 2/FV25052205_23_22_LAYOUT.txt'
data = []
with open(filename, 'r') as file_txt:
	for line in file_txt:
		
		line = line.split('\t')
		
		# Remover porcentagem e asteriscos
		line = [x.replace('%', '') for x in line]
		line = [x.replace('*****', '100') for x in line]

		# Remover caracteres desnecessários
		line = [i for i in line if i != '' and i != '\n']
		
		# Remover espaços
		line = [x.strip() for x in line]
		
		data.append(line)

	# Dados do cabeçalho do arquivo
	cabecalho = {
		'nome_projeto': data[0][0].upper(),
		'maquina': data[0][1].split(':')[1].strip().title(),
		# 'tempo_maquina': data[0][2],
		'data_processamento': data[0][2],
		# 'hora_processamento': data[0][2],
		'usuario': data[0][3].title(),
	}

	# Tamanhos das arrays de dados
	lens = [len(line) for line in data[1:-1]]
	lens = list(set(lens))
	lens.sort()

	for line in data[1:-1]:
		
		# Cabeçalhos = max(lens)
		# Projeto
		if len(line) == max(lens):

			# Arquivo de entrada
			# line[0]	= No.				= numero_plano
			# line[1] 	= %					= aproveitamento
			# line[2] 	= Desc. Material	= descricao_material
			# line[3] 	= Código			= codigo_material
			# line[4]	= Comp.				= comprimento_material
			# line[5]	= Larg.				= largura_material
			# line[6]	= Qtd.				= quantidade_material
			# line[7]	= m²				= area_material
			# line[8]	= tempo				= tempo

			plano = {
				'numero_plano': int(line[0]),
				'aproveitamento': float(line[1]),
				'descricao_material': line[2],
				'codigo_material': int(line[3]),
				'comprimento_material': int(line[4]),
				'largura_material': int(line[5]),
				'quantidade_material': int(line[6]),
				# 'area_material': int(line[6])
				# 'tempo': int(line[6])
			}

		else:
			# Plano = min(lens)

			# Arquivo de entrada
			# line[0]	= #				= numero_peca
			# line[1] 	= Código		= codigo_peca
			# line[2] 	= Descrição		= descricao_peca
			# line[3]	= Comp.			= comprimento_peca
			# line[4]	= Larg.			= largura_peca
			# line[5] 	= Qtd.			= quantidade_peca
			# line[6]	= Ordem			= ordem
			# line[6]	= Data			= data_embalagem
			# line[7]	= Produzido		= produzido

			peca = {
				'numero_peca': int(line[0]),
				'codigo_peca': line[1],
				'descricao_peca': line[2],
				'comprimento_peca': int(line[3]),
				'largura_peca': int(line[4]),
				'quantidade_peca': int(line[5]),
				'ordem': int(line[6]),
				'data_embalagem': datetime.strptime(line[7], '%d/%m/%y').strftime('%d/%m/%Y'),
				'produzido': float(line[8])
			}

			insert = {}
			insert.update(cabecalho)
			insert.update(plano)
			insert.update(peca)

			planos.append(insert)


# Baixa na TOTVS
for plano in planos:
	quantidade = (plano['comprimento_peca'] / 1000) * (plano['largura_peca'] / 1000) * plano['quantidade_peca']
	api_totvs = 'http://192.168.0.26:8888/scripts/cgiip.exe/WService=MD/rsapi/rsapi015web?codChave=128964ard&Item=' + str(plano['codigo_material'])  + '&dep_orig=ALM&loc_orig=ALMB-A&dep_dest=FAB&loc_dest=&quantidade=' + str(quantidade) + '&codEmitente=138449'
	
	# response = requests.get(api)
	# response.content
	# print(api_totvs)



# Converter dicionario em json
planos = json.dumps(planos, indent = 4)

# Cadastrar no sistema de controle de chapas (php)
api_endpoint = 'http://localhost/md-ardis/Fase%203/public/api/projeto'
api_endpoint = 'http://localhost:8080/md-ardis/Fase%203/public/api/projeto'
api_headers = {
	'Content-Type': 'application/json',
}

post = requests.post(url=api_endpoint, headers=api_headers, json=planos)
# print(post.json())
print(post.content)
print(post.status_code)

# for ordem in ordens:
# 	print('{')
# 	for line in ordem:
# 		print('\t', line, ':', ordem[line])
# 	print('}')
# print(ordens)