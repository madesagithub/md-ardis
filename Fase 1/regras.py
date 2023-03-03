import os
import pandas as pd
import sys
sys.path.append('')

# CONSTANTES
from functions import *
# from constantes import *
from constantes_dev import *

nomes = []
i = 0

# pasta = 'F:/Programacao/07  Ardis/FV/sub'
# pasta = PATH_1_FV_SUB
pasta = PATH_1_FV_POS_CONFERENCIA

# for diretorio, subpastas, arquivos in os.walk(pasta):
for diretorio, subpastas, arquivos in os.walk(pasta):
    for arquivo in arquivos:
        vol = (os.path.join(arquivo))
        nomes.append(vol)
		# Somente CSV

if len(nomes) != 0:
    # df = pd.read_csv(f'F:/Programacao/07  Ardis/FV/sub/{nomes[i]}', sep=';', encoding='latin-1', index_col=False)
    df = pd.read_csv(f'{pasta}/{nomes[i]}', sep=';', encoding='latin-1', index_col=False)

def med_elc():
    new = df["Med Bruta"].str.split("X", n = 2, expand = True)
    df["Espessura"] = new[0]
    df["Largura"] = new[1]
    df["Comprimento"] = new[2]
    df["Espessura"] = df["Espessura"].str.replace(",", ".")
    df["Largura"] = df["Largura"].apply(pd.to_numeric)
    df["Espessura"] = df["Espessura"].apply(pd.to_numeric)
    df["Comprimento"] = df["Comprimento"].apply(pd.to_numeric)  

def tratamento_de_lados():
    df.describe()
    df["Fita"] = df["Fita"].str.replace(" ", "0")
    df["Fita"] = df["Fita"].str.replace("SEMFITA", "0")
    new = df["Fita"].str.split("LADO", n = 1, expand = True)
    df["lado"] = new[0]
    df["lado"] = df["lado"].str.replace("BP","")
    new = df["Fita"].str.split("(", n = 2, expand = True)
    df["FitaQtd"] = new[0]
    df["FitaQtd"] = df["FitaQtd"].str[0:1]
    df["FitaQtd"] = df["FitaQtd"].str.replace("M", "")
    df["FitaQtd"] = df["FitaQtd"].str.replace("R", "")
    df["FitaQtd"] = df["FitaQtd"].str.replace("U", "")
    df["FitaQtd"] = df["FitaQtd"].str.replace("S", "")
    df["FitaQtd"] = df["FitaQtd"].str.replace("T", "")
    df["FitaQtd"] = df["FitaQtd"].str.replace("/", "")
    df["FitaQtd"] = df["FitaQtd"].str.replace("A", "")
    df["FitaQtd"] = df["FitaQtd"].fillna(0)
    new = df["Fita"].str.split("=", n = 2, expand = True)
    df["Medfita"] = new[0]
    df["Medfita"] = df["Medfita"].str[0:5]
    df["Medfita"] = df["Medfita"].str.replace("M", "")
    df["Medfita"] = df["Medfita"].str.replace("L", "")
    df["Medfita"] = df["Medfita"].str.replace("-", "")
    df["Medfita"] = df["Medfita"].str.replace("=", "")
    df["Medfita"] = df["Medfita"].str.replace("/", "")
    df["Medfita"] = df["Medfita"].str.replace("A", "")
    df["Medfita"] = df["Medfita"].str.replace("D", "")
    df["Medfita"] = df["Medfita"].str.replace("O", "")
    df["Medfita"] = df["Medfita"].fillna(0)
    df['FitaQtd2'] = '0' 
    df["Medfita2"] = '0'

def lados():
    df.loc[(df['Pintura'] == "HDF") , 'lado'] = 0
    df.loc[(df['lado'] == "2") & (df['FitaQtd'] == "1"), 'FitaQtd2'] = 1
    df.loc[(df['lado'] == "2") & (df['FitaQtd'] == "2"), 'FitaQtd2'] = 0
    df.loc[(df['lado'] == "3") & (df['FitaQtd'] == "2"), 'FitaQtd2'] = 1
    df.loc[(df['lado'] == "3") & (df['FitaQtd'] == "1"), 'FitaQtd2'] = 2
    df.loc[(df['lado'] == ""), 'lado'] = 0
    df.loc[(df['lado'] == "4"), 'FitaQtd2'] = 2
    df.loc[(df['lado'] == "4"), 'FitaQtd'] = 2
    df.loc[(df['lado'] == "0"), 'FitaQtd2'] = 0
    df.loc[(df['lado'] == "0"), 'FitaQtd'] = 0
    df.loc[(df['lado'] == 0), 'FitaQtd'] = 0
    df.loc[(df['lado'] == "1"), 'FitaQtd'] = 1
    df.loc[(df['lado'] == 1), 'FitaQtd'] = 1
    df.loc[(df['lado'] == "1") & (df['FitaQtd'] == "1"), 'FitaQtd2'] = 0
    df.loc[(df['lado'] == "1") & (df['FitaQtd'] == "0"), 'FitaQtd2'] = 1
    df.loc[(df['lado'] == "0"), 'Medfita'] = 0
    df.loc[(df['FitaQtd2'] == 0), 'Medfita2'] = 0
    df.loc[(df['FitaQtd2'] == "0"), 'Medfita2'] = 0
    df.loc[(df['Medfita']) == 0, 'Medfita'] = df['Comprimento']
    df.loc[(df['Medfita']) == (df['Comprimento']), 'Medfita2'] = df['Largura']
    df.loc[(df['Medfita']) != (df['Comprimento']), 'Medfita2'] = df['Comprimento']
    df['Medfita'] = df['Medfita'].apply(pd.to_numeric) 

def ardis4(): 
    df.loc[(df['Medfita']) == (df['Comprimento']), 'Medfita2'] = df['Largura']
    df.loc[(df['Medfita']) != (df['Comprimento']), 'Medfita2'] = df['Comprimento']
    df.loc[(df['lado'] == "4" ),'Ardis'] = "ESQUADRA"
    df.loc[(df['lado'] == "4") & (df["Medfita"] == df['Comprimento']) & (df["Medfita"]  <= 550), 'Ardis'] = "ESQUADRA 2X"
    df.loc[(df['lado'] == "4") & (df["Medfita2"] == df['Comprimento']) & (df["Medfita2"] <= 550), 'Ardis'] = "ESQUADRA 2X" 
    df.loc[(df['lado'] == "4") & (df["Medfita2"] == df['Largura']) & (df["Medfita2"] <= 550) & (df["Medfita2"] >= 240), 'Ardis'] = "ESQUADRA 2Y"
    df.loc[(df['lado'] == "4") & (df["Medfita"] == df['Largura']) & (df["Medfita"]  <= 550), 'Ardis'] = "ESQUADRA 2Y "
    df.loc[(df['lado'] == "4") & (df["Medfita2"] == df['Comprimento']) & (df["Medfita2"] > 1250), 'Ardis'] = ""
    df.loc[(df['lado'] == "4") & (df["Medfita"] == df['Comprimento']) & (df["Medfita"] > 1250), 'Ardis'] = ""

def ardis3():
    df.loc[(df['Medfita']) == (df['Comprimento']), 'Medfita2'] = df['Largura']
    df.loc[(df['Medfita']) != (df['Comprimento']), 'Medfita2'] = df['Comprimento']
    df.loc[(df['lado'] == "3") & (df['Comprimento'] >= 125) & (df['Largura'] >= 125) ,'Ardis'] = "ESQUADRA"
    df.loc[(df['lado'] == "3") & (df["Medfita"] == df['Largura']) & (df["Medfita2"] <= 1200) & (df["Medfita"] <= 500) & (df["Medfita"] >= 125) , 'Ardis'] = "ESQUADRA 2Y"
    df.loc[(df['lado'] == "3") & (df["Medfita"] == df['Comprimento']) & (df["Medfita2"] >= 125) & (df["Medfita2"] <= 500), 'Ardis'] = "ESQUADRA 2Y"
    df.loc[(df['lado'] == "3") & (df["Medfita2"] == df['Largura']) & (df["Medfita"] <= 500) & (df["Medfita2"] >= 125), 'Ardis'] = "ESQUADRA 2X"
    df.loc[(df['lado'] == "3") & (df["Medfita"] == df['Largura']) & (df["Medfita2"] <= 500) & (df["Medfita"] >= 125), 'Ardis'] = "ESQUADRA 2X"
    df.loc[(df['lado'] == "3") & (df["Medfita"] == df['Largura']) & (df["Medfita"] > 500) , 'Ardis'] = "ESQUADRA"
    df.loc[(df['lado'] == "3") & (df["Medfita2"] == df['Largura']) & (df["Medfita2"] > 500) , 'Ardis'] = "ESQUADRA"
    df.loc[(df['lado'] == "3") & (df["Medfita2"] == df['Comprimento']) & (df["Medfita"] >= 125) & (df["Medfita"] <= 500), 'Ardis'] = "ESQUADRA 2Y"
    df.loc[(df['lado'] == "3") & (df['Comprimento'] < 125) & (df['Largura'] < 125) ,'Ardis'] = ""
    df.loc[(df['lado'] == "3") & (df["Medfita"] == df['Comprimento']) & (df["Medfita"] > 1200), 'Ardis'] = "ESQUADRA"
    df.loc[(df['lado'] == "3") & (df["Medfita2"] == df['Comprimento']) & (df["Medfita2"] > 1200), 'Ardis'] = "ESQUADRA"  

def ardis2():
    df.loc[(df['Medfita']) == (df['Comprimento']), 'Medfita2'] = df['Largura']
    df.loc[(df['Medfita']) != (df['Comprimento']), 'Medfita2'] = df['Comprimento']
    df.loc[(df['lado'] == "2") & (df["Medfita2"] == df['Largura']) & (df["Medfita2"] <= 500) & (df["Medfita2"] >= 240 ) , 'Ardis'] = "DUPLA 1Y"
    df.loc[(df['lado'] == "2") & (df["Medfita"] == df['Largura']) & (df["Medfita"] <= 500) & (df["Medfita"]>= 240), 'Ardis'] = "DUPLA 1Y"
    df.loc[(df['lado'] == "2") & (df["Medfita"] == df['Comprimento']) & (df["Medfita"] <= 500) , 'Ardis'] = "ESQUADRA 2X"
    df.loc[(df['lado'] == "2") & (df["Medfita2"] == df['Comprimento']) & (df["Medfita2"] <= 500) , 'Ardis'] = "ESQUADRA 2X"
    df.loc[(df['lado'] == "2") & (df["Medfita2"] == df['Largura']) & (df["Medfita2"] <= 500) & (df["Medfita2"] <= 550) & (df["Medfita2"]>= 240), 'Ardis'] = "ESQUADRA 2Y"
    df.loc[(df['lado'] == "2") & (df["Medfita"] == df['Comprimento']) & (df["Medfita2"] <= 500) & (df["Medfita2"] <= 550) & (df["Medfita2"]>= 240), 'Ardis'] = "ESQUADRA 2Y"
    df.loc[(df['lado'] == "2") & (df["Medfita"] == df['Comprimento'])  & (df["Medfita"] >= 240) & (df['FitaQtd'] == 2) , 'Ardis'] = "DUPLA 1X"
    df.loc[(df['lado'] == "2") & (df["Medfita2"] == df['Comprimento'])  & (df["Medfita2"] >= 240) & (df['FitaQtd2'] == 2) , 'Ardis'] = "DUPLA 1X"
    df.loc[(df['lado'] == "2") & (df["Medfita"] == df['Largura']) & (df["Medfita"] >= 240) & (df['FitaQtd'] == "2") , 'Ardis'] = "DUPLA 1Y"
    df.loc[(df['lado'] == "2") & (df["Medfita2"] == df['Largura']) & (df["Medfita2"] >= 240) & (df['FitaQtd2'] == "2") , 'Ardis'] = "DUPLA 1Y"
    df.loc[(df['lado'] == "2") & (df["Medfita"] == df['Largura']) & (df["Medfita"] > 1250) , 'Ardis'] = ""
    df.loc[(df['lado'] == "2") & (df["Medfita2"] == df['Largura']) & (df["Medfita2"] > 1250) , 'Ardis'] = ""    

def ardis1(): 
    df.loc[(df['Medfita']) == (df['Comprimento']), 'Medfita2'] = df['Largura']
    df.loc[(df['Medfita']) != (df['Comprimento']), 'Medfita2'] = df['Comprimento']
    df.loc[(df['lado'] == "1") & (df["Medfita"] == df['Largura']) & (df["Medfita"] <= 500) , 'Ardis'] = "DUPLA 2Y"
    df.loc[(df['lado'] == "1") & (df["Medfita2"] == df['Largura']) & (df["Medfita2"] <= 500) , 'Ardis'] = "DUPLA 2Y"
    df.loc[(df['lado'] == "1") & (df["Medfita2"] == df['Comprimento']) & (df["Medfita2"] > 1250) , 'Ardis'] = ""
    df.loc[(df['lado'] == "1") & (df["Medfita"] == df['Comprimento']) & (df["Medfita"] > 1250) , 'Ardis'] = ""
    df.loc[(df['lado'] == "1") & (df["Medfita2"] == df['Largura']) & (df["Medfita2"] <= 140) , 'Ardis'] = ""
    df.loc[(df['lado'] == "1") & (df["Medfita"] == df['Largura']) & (df["Medfita"] <= 140) , 'Ardis'] = ""  

def converte():        
    df['FitaQtd'] = df['FitaQtd'].apply(pd.to_numeric) 
    df['FitaQtd2'] = df['FitaQtd2'].apply(pd.to_numeric) 
    df['Medfita'] = df['Medfita'].apply(pd.to_numeric) 
    df['Medfita2'] = df['Medfita2'].apply(pd.to_numeric) 
    # if os.path.exists(f'F:/Programacao/07  Ardis/FV/FV_ARDIS/{nomes[i]}'):
    if os.path.exists(f'{PATH_1_FV_ARDIS}/{nomes[i]}'):
        # os.remove(f'F:/Programacao/07  Ardis/FV/FV_ARDIS/{nomes[i]}')
        os.remove(f'{PATH_1_FV_ARDIS}/{nomes[i]}')
    # df.to_csv(f'F:/Programacao/07  Ardis/FV/FV_ARDIS/{nomes[i]}', sep=';', encoding='latin-1', index=False)
    df.to_csv(f'{PATH_1_FV_ARDIS}/{nomes[i]}', sep=';', encoding='latin-1', index=False)
    print(df)
    df.describe()
    print(df.dtypes)  

def delete():
    df.drop('Medfita2', inplace=True, axis=1)
    df.drop('lado', inplace=True, axis=1) 
    df.drop('Largura', inplace=True, axis=1)
    df.drop('FitaQtd2', inplace=True, axis=1) 
    df.drop('Medfita', inplace=True, axis=1) 
    df.drop('FitaQtd', inplace=True, axis=1) 
    df.drop('Comprimento', inplace=True, axis=1)
    df.drop('Espessura', inplace=True, axis=1)    
    print(df)
    # df.to_csv(f'F:/Programacao/07  Ardis/FV/sub/{nomes[i]}', sep=';', encoding='latin-1', index=False)  
    # df.to_csv(f'{PATH_1_FV_SUB}/{nomes[i]}', sep=';', encoding='latin-1', index=False)  
    df.to_csv(f'{PATH_1_FV_POS_CONFERENCIA}/{nomes[i]}', sep=';', encoding='latin-1', index=False)  

def deleta():
    # os.remove(f'F:/Programacao/07  Ardis/FV/sub/{nomes[i]}')
    # os.remove(f'{PATH_1_FV_SUB}/{nomes[i]}')
    os.remove(f'{PATH_1_FV_POS_CONFERENCIA}/{nomes[i]}')
    
def main():
    print('Iniciando a atualização da base de dados')

    if len(nomes) != 0:
        med_elc() 
        tratamento_de_lados()
        lados()
        ardis4()
        ardis3()
        ardis2()
        ardis1()
        converte()
        delete()
        deleta()
        nomes.clear()
        return main()
    else:
        print('Lista de arquivos vazia')
        return


# main()
