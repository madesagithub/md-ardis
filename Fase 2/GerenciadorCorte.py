from os import walk
import csv
import json
import logging
import os
import socket
import sys
import time
import traceback
import requests

# CONSTANTES
from constantes import *
from functions import *

# API PHP
API_PHP = 'http://10.1.1.86:8080/md-ardis/Fase%203/public/api'

# API TOTVS
# --------------------------------------------------
DEP_ORIGEM = 'ALM'
LOC_ORIGEM = ''
DEP_DESTINO = 'FAB'
LOC_DESTINO = ''

# Como compilar para .exe
# --------------------------------------------------
# No terminal
# cd '.\Fase 2\'
# C:\Users\t.flach\AppData\Local\Packages\PythonSoftwareFoundation.Python.3.10_qbz5n2kfra8p0\LocalCache\local-packages\Python310\Scripts\pyinstaller.exe --onefile Gerenciador_Corte.py


# Configuração de Logs
# --------------------------------------------------
logging.basicConfig(
	level=logging.INFO,
	format='%(asctime)s :: %(levelname)s :: %(message)s',
	filename=f'{PATH_LOGS}\erros_python.log')

# log uncaught exceptions
def log_exceptions(type, value, tb):
	logging.exception(''.join((traceback.format_exception(type, value, tb))))
	sys.__excepthook__(type, value, tb) # calls default excepthook

sys.excepthook = log_exceptions


# --------------------------------------------------
# Baixa na TOTVS
# Movimentação (deposito -> fabrica)
def send_totvs(planos):
	for plano in planos:
		# MD-PROT - Sinaliza que a operação será feita na base de PROTÓTIPO
		# base = BASE

		# Chave da operação, necessária para o servidor aceitar a conexão
		# cod_chave = CHAVE

		# Item a ser movimentado estoque
		chapa = str(plano['codigo_chapa_usado'])

		# Depósito de origem
		dep_origem = DEP_ORIGEM

		# Local de origem
		fabrica = str(plano['fabrica']).upper().split()
		fabrica = ''.join(fabrica)

		if LOC_ORIGEM == '':
			if fabrica == 'FB':
				loc_origem = 'ALMB-A'
			elif fabrica == 'FV':
				loc_origem = 'ALMV-A'
		else:
			loc_origem = LOC_ORIGEM

		# dep_dest à deposito destino
		dep_destino = DEP_DESTINO

		# Local destino
		loc_destino = LOC_DESTINO

		# Quantidade deve ser na unidade de medida cadastrada no sistema
		quantidade = str(plano['metro_quadrado_bruto_peca']).replace('.', ',')

		# ----------

		# Api para comunicação com o TOTVS
		api_totvs = API_TOTVS \
					+ '&codChave=' + cod_chave \
					+ '&Item=' + chapa \
					+ '&dep_orig=' + dep_origem \
					+ '&loc_orig=' + loc_origem \
					+ '&dep_dest=' + dep_destino \
					+ '&loc_dest=' + loc_destino \
					+ '&quantidade=' + quantidade 

		# response = requests.get(api)
		# response.content
		# logging.info(response.content)
		print(api_totvs)


# --------------------------------------------------
# Cadastrar no sistema de controle de chapas (php)
# Enviar para API
def send_php(planos):
	# Converter dicionario em json
	planos = json.dumps(planos, indent = 4)

	api_headers = {
		'Content-Type': 'application/json',
	}

	post = requests.post(url=API_PHP, headers=api_headers, json=planos)
	logging.info(post.text)
	# print(post.json())
	# print(post.text)
	print(post.content)
	print(post.status_code)


# --------------------------------------------------
# Retorna a fábrica do projeto
def get_fabrica(file):

	with open(file, 'r', encoding='latin-1') as file_csv:

		csv_reader = csv.DictReader(file_csv, delimiter=';')

		# Remove espaços e torna minusculo
		headers = [head.strip().lower() for head in csv_reader.fieldnames]
		csv_reader.fieldnames = headers

		file_csv.readline()
		for row in csv_reader:

			# Remove espaços, % e asteriscos
			row = dict((k, v.strip()) for k, v in row.items())
			row = dict((k, v.replace('%', '')) for k, v in row.items())
			row = dict((k, v.replace('*****', '100')) for k, v in row.items())

			if row['tipo dado'] == 'DATA_PECA':
				fabrica = row['unidade'].upper()
				fabrica = str(fabrica).split()
				fabrica = ''.join(fabrica)
				break

	return fabrica


# --------------------------------------------------
# Mover arquivo
def move_file(file):
	fabrica = get_fabrica(file)

	new_file = f"{PATH_PRODUZIDOS}\{fabrica}\{file}"
	try:
		os.replace(file, new_file)
		logging.info(f"{file} -> {new_file}")
	except:
		logging.info(f"Sem permissão para mover arquivo: {file} -> {new_file}")

# Só que quando eu tento executar o código, ele não faz nada, não dá erro, não dá nada, só fica parado. Alguém sabe o que pode ser?
# --------------------------------------------------
# Main

# Get the last file
latest_file = get_lasted_file(PATH_NOVOS)
logging.info(f"START: {latest_file}")
print(latest_file)

# ----------
planos = get_planos(latest_file)
# print_planos(planos)

# send_totvs(planos)
send_php(planos)
move_file(latest_file)
time.sleep(5)
# ----------