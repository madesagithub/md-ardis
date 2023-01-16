# Verificar quantidade de retalhos no Banco de dados
# Autor: Tiago Lucas Flach
# Data: 12/01/2023

# [ ] Verificar a quantidade de cada item do plano no sistema PHP
# 	[ ] Se a houver peças:
# 		[ ] subtrair do sistema php
# 		[x] subtrair do plano de corte
# 		[x] atualizar a array de planos
# [ ] Gerar um arquivo novo e atualizado em uma pasta separada


# CONSTANTES
from constantes import *
from functions import *

# PATH =
# PATH_ARDIS = 
# PATH_BACKUP = 
# PATH_POS_PROCESSAMENTO = 


# Retorna os retalhos presentes no projeto
def get_retalhos(planos):
	retalhos = [plano for plano in planos if plano['codigo_peca'] == '']
	return retalhos


# Imprime os retalhos em formato json
def print_retalhos(retalhos):
	# Converter dicionario em json
	retalhos = json.dumps(retalhos, indent = 4)

	print(retalhos)


# Consulta o saldo de peças desejadas
def get_saldo(item):
	API_PHP = API_PHP + '?' \
			  + '&chapa=' + item['classificacao_chapa'] \
			  + '&comprimento=' + item['comprimento_peca'] \
			  + '&largura=' + item['largura_peca'] \
			  + '&espessura=' + item['espessura_peca'] \
			  + '&fabrica=' + item['fabrica']

	# Converter dicionario em json
	item = json.dumps(item, indent = 4)

	result = requests.get(url=API_PHP)
	# result = requests.post(url=API_PHP, headers=api_headers, json=item)
	# logging.info(result.text)
	# print(result.json())
	# print(result.text)
	print(result.content)
	print(result.status_code)

	return result


# Envia a ordem que será reaproveitado para o sistema
def send_reaproveitamento(ordem):

	# convert to camel case
	ordem = dict((to_camel_case(key), value) for (key, value) in ordem.items())
	print('')
	print(ordem)

	# Converter dicionario em json
	ordem = json.dumps(ordem, indent = 4)

	api_headers = {
		'Content-Type': 'application/json',
	}

	result = requests.post(url=API_PHP, headers=api_headers, json=ordem)
	# logging.info(result.text)
	# print(result.json())
	# print(result.text)
	print(result.content)
	print(result.status_code)


# --------------------------------------------------
# Main

latest_file = get_lasted_file(PATH_POS_PROCESSAMENTO, 'txt')
print(latest_file)

planos = get_planos(latest_file)
# print_planos(planos)
# print(planos[0])

# retalhos = get_retalhos(planos)
# print_retalhos(retalhos)

# for retalho in retalhos:
# 	API_PHP = API_PHP + '?' \
# 		+ '&chapa=' + retalho['classificacao_chapa'] \
# 		+ '&comprimento=' + retalho['comprimento_peca'] \
# 		+ '&largura=' + retalho['largura_peca'] \
# 		+ '&espessura=' + retalho['espessura_peca'] \
# 		+ '&fabrica=' + retalho['fabrica']

# 	saldo = get_saldo(retalho)


for ordem in planos:
	saldo = get_saldo(ordem)

	send_reaproveitamento(ordem)

	if saldo > 0:
		key = planos.index(ordem)
		# print(planos[key])

		new_saldo = max(saldo - ordem['quantidade_peca'], 0)
		new_quantidade = max(ordem['quantidade_peca'] - saldo, 0)

		ordem['quantidade_peca'] = new_quantidade

		# atualizar array de planos
		planos[key] = ordem
		# print(planos[key])

		# atualizar no sistema php
		send_reaproveitamento(ordem)
