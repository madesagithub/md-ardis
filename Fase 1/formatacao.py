import os
import shutil as st
import sys
sys.path.append('')

# CONSTANTES
from functions import *
# from constantes import *
from constantes_dev import *

linha = []
nomes = []

def cria_csv(path, file):




	
    # verificar se é um diretorio
    if not os.path.isdir(path):
        print('Diretório não existe')

    print (os.getcwd())

    exit()
	# REVISAR
    arquivo = open(f'{path}/{file}.csv', 'a')
    arquivo.close()

def inicial():
    # with open (f'F:/Programacao/07  Ardis/data/{nomes[i]}.csv', 'a') as arquivo:
    # with open (f'{PATH_1_DATA}/{nomes[i]}.csv', 'a') as arquivo:
    with open (f'{PATH_1_FV_POS_CONFERENCIA}/{nomes[i]}.csv', 'a') as arquivo:
        arquivo.write('Dt Termino;Qt Ordem;Item;Ordem Prod;Peca;Desc Peca;Med Esquadra;Med Bruta;Ardis;Quantidade;Lote Multiplo;Pilha;Codigo da chapa;Classificacao;Desc. da chapa;Fita;Pintura' + "\n")
        arquivo.close()

def principal():
    # with open (f'F:/Programacao/07  Ardis/Pós conferência/{nomes[i]}') as f:
    # with open(f'{PATH_1_POS_CONFERENCIA}/{nomes[i]}', 'r', encoding='latin-1') as f:
    
    file = f'{PATH_1_FV_POS_CONFERENCIA}/{nomes[i]}'
    file_csv = file+'.csv'

    with open(file, 'r', encoding='latin-1') as f:
        # print(f'{PATH_1_POS_CONFERENCIA}/{nomes[i]}')
        # print(f'{PATH_1_POS_CONFERENCIA}/{nomes[i]}')
        for line in f:
            if line[0:2] != 'Dt':
                if line[0:2] != "\n":
                    # with open (f'F:/Programacao/07  Ardis/data/{nomes[i]}.csv', 'a') as arquivo:
                    # with open (f'{PATH_1_DATA}/{nomes[i]}.csv', 'a') as arquivo:
                    # with open (f'{PATH_1_FV_POS_CONFERENCIA}/{nomes[i]}.csv', 'a') as arquivo:
                    with open (file_csv, 'a') as arquivo:
                        arquivo.write(line)
                        arquivo.close()
                if line == '\n':
                    # pass
                    # with open (f'F:/Programacao/07  Ardis/data/{nomes[i]}.csv', 'a') as arquivo:
                    # with open (f'{PATH_1_DATA}/{nomes[i]}.csv', 'a') as arquivo:
                    # with open (f'{PATH_1_FV_POS_CONFERENCIA}/{nomes[i]}.csv', 'a') as arquivo:
                    with open (file_csv, 'a') as arquivo:
                        arquivo.close()		# ??????????????????????????????????
            else:
                continue
        f.close()

def deleta():
    # os.remove(f'F:/Programacao/07  Ardis/Pós conferência/{nomes[i]}')
    os.remove(f'{PATH_1_FV_POS_CONFERENCIA}/{nomes[i]}')

def backup():
    # fonte = (f'F:/Programacao/07  Ardis/Pós conferência/{nomes[i]}')
    # fonte = (f'{PATH_1_POS_CONFERENCIA}/{nomes[i]}')
    fonte = (f'{PATH_1_FV_POS_CONFERENCIA}/{nomes[i]}')

    # destino = ('F:/Programacao/07  Ardis/Backup/FV')
    # destino = (f'{PATH_1_BACKUP}/FV/')
    destino = (f'{PATH_1_FV_BACKUP}')

	# copiar arquivo para pasta de backup
    st.copy(fonte, destino)
    print('Movido para Backup: ', nomes[i])

def main():
    global nomes
    nomes = get_files(PATH_1_FV_POS_CONFERENCIA, 'txt')
    
    for i in range(len(nomes)):
        cria_csv(PATH_1_FV_POS_CONFERENCIA, nomes[i])

    if len(nomes) != 0:
        backup()
        inicial()
        principal()
        deleta()
        nomes.clear()
        # print(nomes)
        # return main() # Recursividade
    else:
        print('Não há arquivos para processar')

# main()