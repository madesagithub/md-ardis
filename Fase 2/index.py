import csv
import os
import requests

# varredura de diretório

# Lista arquivos do diretório atual
# cwd = os.getcwd()  # Get the current working directory (cwd)
# files = os.listdir(cwd)  # Get all the files in that directory
# print("Files in %r: %s" % (cwd, files))


ordens = []
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
		print(', '.join(linha))

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



# dar baixa na TOTVS
for ordem in ordens:
	api_totvs = 'http://192.168.0.26:8888/scripts/cgiip.exe/WService=MD/rsapi/rsapi015web?codChave=128964ard&Item=' + str(ordem['codigo_chapa'])  + '&dep_orig=ALM&loc_orig=ALMB-A&dep_dest=FAB&loc_dest=&quantidade=' + str(ordem['quantidade_chapa']) + '&codEmitente=138449'
	
	# response = requests.get(api)
	# response.content
	print(api_totvs)


# cadastrar no sistema de controle de produção
api_controle = 'http://'
# put = requests.put(api_controle, data=ordens)
# put = requests.patch(api_controle, data=ordens)
print(ordens)