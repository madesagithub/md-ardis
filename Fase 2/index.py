from ast import Continue
import csv
from datetime import datetime
import os
import requests

# varredura de diretório

# Lista arquivos do diretório atual
# cwd = os.getcwd()  # Get the current working directory (cwd)
# files = os.listdir(cwd)  # Get all the files in that directory
# print("Files in %r: %s" % (cwd, files))

ordens = []

filename = 'Fase 2/FV25052205_23_22_LAYOUT.txt'
data = []
with open(filename, 'r') as file_txt:
	for line in file_txt:
		line = line.split('\t')

		# Remover porcentagem e asteriscos
		line = [x.replace('%', '') for x in line]
		line = [x.replace('*****', '') for x in line]

		# Remover caracteres desnecessários
		line = [i for i in line if i != '' and i != '\n']

		# Remover espaços
		line = [x.strip() for x in line]

		data.append(line)

	# Dados do cabeçalho do arquivo
	cabecalho = {
		'nome': data[0][0].upper(),
		'maquina': data[0][1].split(':')[1].strip().title(),
		'data_processamento': data[0][2],
		'usuario': data[0][3].title(),
	}

	# Tamanhos das arrays de dados
	lens = [len(line) for line in data[1:-1]]
	lens = list(set(lens))
	lens.sort()

	for line in data[1:-1]:
		
		# Cabeçalhos = max(lens)
		# Plano
		if len(line) == max(lens):

			# Arquivo de entrada
			# line[0]	= No.				= numero
			# line[1] 	= %					= aproveitamento
			# line[2] 	= Desc. Material	= descricao_material
			# line[3] 	= Código			= codigo_material
			# line[4]	= Comp.				= comprimento_material
			# line[5]	= Larg.				= largura_material
			# line[6]	= Qtd.				= quantidade_material

			ordem = {
				'numero': int(line[0]),
				'aproveitamento': float(line[1]),
				'descricao_material': line[2],
				'codigo_material': int(line[3]),
				'comprimento_material': int(line[4]),
				'largura_material': int(line[5]),
				'quantidade_material': int(line[6])
			}

		else:
			# Plano = min(lens)

			# Arquivo de entrada
			# line[0]	= #				= numero
			# line[1] 	= Código		= codigo_peca
			# line[2] 	= Descrição		= descricao_peca
			# line[3]	= Comp.			= comprimento_peca
			# line[4]	= Larg.			= largura_peca
			# line[5] 	= Qtd.			= quantidade_peca
			# line[6]	= Ordem			= ordem
			# line[6]	= Data			= data_producao
			# line[7]	= Produzido		= produzido

			peca = {
				'numero': int(line[0]),
				'codigo_peca': line[1],
				'descricao_peca': line[2],
				'comprimento_peca': int(line[3]),
				'largura_peca': int(line[4]),
				'quantidade_peca': int(line[5]),
				'ordem': int(line[6]),
				'data_producao': datetime.strptime(line[7], '%d/%m/%y').strftime('%d/%m/%Y'),
				'produzido': float(line[8]) if line[8] != '' else line[8]
			}

			insert = {}
			insert.update(cabecalho)
			insert.update(ordem)
			insert.update(peca)

			ordens.append(insert)
			# print(insert)



filename = 'Fase 2/Modelo relatório.csv'
with open(filename, 'r') as file_csv:
	reader = csv.reader(file_csv)
	next(reader, None)	# ignora primeira linha
	
	# Arquivo de entrada
	# file[0] = id (Plano (ddmmaaaa.hh.mm.ss).plano)
	# file[1] = Tempo
	# file[2] = No.
	# file[3] = %
	# file[4] = Desc. Material
	# file[5] = Código Chapa
	# file[6] = Comp. Chapa
	# file[7] = Larg. Chapa
	# file[8] = Qtd. Chapa
	# file[9] = Código Material
	# file[10] = Descrição
	# file[11] = Comprimento
	# file[12] = Largura
	# file[13] = Quant
	# file[14] = Ordem
	# file[15] = Data ordem

	for linha in reader:
		continue
		ordens.append({
			'id': linha[0],
			'tempo': linha[1],
			'numero': int(linha[2]),
			'porcentagem': float(linha[3]),
			'descricao_material': linha[4],
			'codigo_chapa': int(linha[5]),
			'comprimento_chapa': linha[6],
			'largura_chapa': int(linha[7]),
			'quantidade_chapa': int(linha[8]),
			'codigo_peca': linha[9],
			'descricao_peca': linha[10],
			'comprimento_peca': int(linha[11]),
			'largura_peca': int(linha[12]),
			'quantidade_peca': int(linha[13]),
			'ordem': int(linha[14]),
			'data': linha[15]
		})



# Baixa na TOTVS
for ordem in ordens:
	quantidade = ordem['comprimento_peca'] * ordem['largura_peca'] * ordem['quantidade_peca']
	api_totvs = 'http://192.168.0.26:8888/scripts/cgiip.exe/WService=MD/rsapi/rsapi015web?codChave=128964ard&Item=' + str(ordem['codigo_material'])  + '&dep_orig=ALM&loc_orig=ALMB-A&dep_dest=FAB&loc_dest=&quantidade=' + str(quantidade) + '&codEmitente=138449'
	
	# response = requests.get(api)
	# response.content
	# print(api_totvs)


# Cadastrar no sistema de controle de chapas (php)
api_controle = 'http://'
api_controle = 'http://localhost/md-ardis/Fase%203/public/api/ordem/store/'
post = requests.post(api_controle, json = ordens)
# requests.put(api_controle, data=ordens)
# put = requests.patch(api_controle, data=ordens)
# print(post.status_code)
for ordem in ordens:
	print(ordem)
# print(ordens)