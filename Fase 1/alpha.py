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
i = 0

def inicial():
    # with open (f'F:/Programacao/07  Ardis/data/{nomes[i]}.csv', 'a') as arquivo:
    with open (f'{PATH_1_DATA}/{nomes[i]}.csv', 'a') as arquivo:
        arquivo.write('Dt Termino;Qt Ordem;Item;Ordem Prod;Peca;Desc Peca;Med Esquadra;Med Bruta;Ardis;Quantidade;Lote Multiplo;Pilha;Codigo da chapa;Classificacao;Desc. da chapa;Fita;Pintura')
        arquivo.close()

def principal():
    # with open (f'F:/Programacao/07  Ardis/Pós conferência/{nomes[i]}') as f:
    with open(f'{PATH_1_POS_CONFERENCIA}/{nomes[i]}', 'r', encoding='latin-1') as f:
        # print(f'{PATH_1_POS_CONFERENCIA}/{nomes[i]}')
        for line in f:
            if line[0:2] != 'Dt':
                if line[0:2] != "\n":
                    # with open (f'F:/Programacao/07  Ardis/data/{nomes[i]}.csv', 'a') as arquivo:
                    with open (f'{PATH_1_DATA}/{nomes[i]}.csv', 'a') as arquivo:
                        arquivo.write(line)
                        arquivo.close()
                if line == '\n':
                    # with open (f'F:/Programacao/07  Ardis/data/{nomes[i]}.csv', 'a') as arquivo:
                    with open (f'{PATH_1_DATA}/{nomes[i]}.csv', 'a') as arquivo:
                        arquivo.close()		# ??????????????????????????????????
            else:
                continue
        f.close()

def atualiza():
    # pasta = 'F:/Programacao/07  Ardis/Pós conferência'
    pasta = PATH_1_POS_CONFERENCIA

    for diretorio, subpastas, arquivos in os.walk(pasta):
        for arquivo in arquivos:
            vol = (os.path.join(arquivo))
            nomes.append(vol)
    # arquivo = open(f'F:/Programacao/07  Ardis/data/{nomes[i]}.csv', 'w')

    if len(nomes) != 0:
        arquivo = open(f'{PATH_1_DATA}/{nomes[i]}.csv', 'w')
        arquivo.close()

        print(nomes)

def deleta():
    # os.remove(f'F:/Programacao/07  Ardis/Pós conferência/{nomes[i]}')
    os.remove(f'{PATH_1_POS_CONFERENCIA}/{nomes[i]}')


def copia():
    # fonte = (f'F:/Programacao/07  Ardis/Pós conferência/{nomes[i]}')
    fonte = (f'{PATH_1_POS_CONFERENCIA}/{nomes[i]}')
    # destino = ('F:/Programacao/07  Ardis/Backup/FV')
    destino = (f'{PATH_1_BACKUP}/FV/')
    print('Movido para Backup: ', nomes[i])
    st.copy(fonte,destino)

def execute1():
    atualiza()

    if len(nomes) != 0:
        inicial()
        principal()
        copia()
        deleta()
        nomes.clear()
        # print(nomes)
        return execute1()
    else:
        print('Não há arquivos para processar')

execute1()