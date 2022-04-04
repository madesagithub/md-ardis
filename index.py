import math
from re import S
import re
import requests
from datetime import date
import xml.etree.ElementTree as ET


# ----------
# Variáveis para o arquivo

# URL para consulta de dados
api_url = 'http://192.168.0.26:8888/scripts/cgiip.exe/WService=MD/rsapi/rsapi014web?codChave=128964ard&Item='

valor_retalho = -1.25
empilhamento_hdf = 60

alteracao_veio = {
    'cedro': 1,
    'cumaru': 1,
    'rustic': 1,
}

default_values = {
    "MATERIAAL": '?',
    "DIKTE": '?',
    "RICHTING": 0,
    "LENGTE": '?',
    "BREEDTE": '?',
    "AANT": '?',    # QUANTIDADE
    "NOLIMIT": 0,
    "PRIJS": '?',   # PREÇO 
    "PRI": {        # PRIORIDADE
        'normal': 30,
        'prioridade': 70
    },
    "NORMREND": {
        'normal': 0,
        'prioridade': 92
    },
    "REFER": '?',
    "BEM": '?',
    "MINBRDBOVEN": {
        'normal': 10,
        'prioridade': 10
    },
    "NOMBRDBOVEN": {
        'normal': 50,
        'prioridade': 50
    },
    "MINBRDRECHTS": {
        'normal': 10,
        'prioridade': 10
    },
    "NOMBRDRECHTS": {
        'normal': 50,
        'prioridade': 50
    },
    "MINBRDONDER": {
        'normal': 10,
        'prioridade': 10
    },
    "NOMBRDONDER": {
        'normal': 50,
        'prioridade': 50
    },
    "MINBRDLINKS": {
        'normal': 10,
        'prioridade': 10
    },
    "NOMBRDLINKS": {
        'normal': 50,
        'prioridade': 50
    },
    "SCHROOTW": '?',
    "RESTW": {
        'normal': 2,
        'prioridade': 2
    },
    "MINRESTL": {   # Comprimento mínimo para o reaproveitamento de um retalho
        'normal': 500,
        'prioridade': 500
    },
    "MINRESTB": {   # Largura mínima para o reaproveitamento de um retalho
        'normal': 500,
        'prioridade': 500
    },
    "MINRESTO": {   # Área mínima para o reaproveitamento de um retalho
        'normal': 1.5,
        'prioridade': 1.5
    },
    "VLV": 0,
    "STPH": '?',
    "ID": ';CO',
}

today = date.today()

files = {
    'B': {
        'normal': open("./Fábrica Branca/MATERIAIS_FB_NORMAL_"+ str(today.strftime("%d%m%Y")) +".STD", "w"),
        'prioridade': open("./Fábrica Branca/MATERIAIS_FB_PRIORIDADE_"+ str(today.strftime("%d%m%Y")) +".STD", "w"),
    },
    'V': {
        'normal': open("./Fábrica Vermelha/MATERIAIS_FV_NORMAL_"+ str(today.strftime("%d%m%Y")) +".STD", "w"),
        'prioridade': open("./Fábrica Vermelha/MATERIAIS_FV_PRIORIDADE_"+ str(today.strftime("%d%m%Y")) +".STD", "w"),
    }
}
# ----------

# ----------
# Buscar dados da API
response_API = requests.get(api_url)
data = response_API.text
root = ET.fromstring(data)
# ----------

# ----------
# Preenchimento do cabecalho
cabecalho = "[ISTDALG]\n\
DATUM="+ today.strftime("%d%m%y") +"\n\
[ISTDALG]\n\
\n\
[ISTDALG$FORM]\n\
[ISTDALG$FORM]\n\n"

for local in files:
    for prioridade in files[local]:
        files[local][prioridade].write(cabecalho)

def round_up(value):
    if (value % 1) > 0.97:
        return round(value)
    else:
        return math.floor(value)
# ----------

array = []
count = {
    'B': 1,
    'V': 1
}

for item in root:

    attributes = {}
    for i in item:
        attributes[i.tag] = i.text

    # Elimina elementos sem classificacao
    if attributes['classificacao'] == None:
        continue

    # ----------
    # FÁBRICA
    fabrica = attributes['localizacao'][3]
    # ----------

    # ----------
    # DIKTE
    dikte = attributes['descricao'].split(' ')
    for element in dikte:
        if (element.find('mm') != -1 or element.find('MM') != -1):
            dikte = element.replace(',', '.')
            dikte = dikte.replace('mm', '').replace('MM', '')
            break
    # ----------

    # ----------
    # RICHTING
    for material in alteracao_veio:
        if isinstance(attributes['classificacao'], str) and re.search(material, attributes['classificacao'], re.IGNORECASE):
            richting = alteracao_veio[material]
            break
        else:
            richting = default_values['RICHTING']
    # ----------

    # ----------
    # LENGTE
    # BREEDTE
    medida = attributes['descricao'].split(' ')
    for element in medida:
        if (element.find('(') != -1 and element.find(')') != -1 and element.find('x') != -1):
            medida = element.strip()
            medida = medida.replace('(', '')
            medida = medida.replace(')', '')

            lengte = medida.split('x')[0]
            breedte = medida.split('x')[1]
    # ----------

    # ----------
    # AANT
    area = (int(lengte) / 1000) * (int(breedte) / 1000)
    nro_chapas = round_up(float(attributes['quantidade'].replace(',', '.')) / area)
    # ----------

    # ----------
    # PRIJS
    preco = float(attributes['custo'].replace(',', '.'))
    # ----------

    # ----------
    # SCHOROOTW
    schrootw = preco * valor_retalho
    # ----------

    # ----------
    # STPH
    stph = empilhamento_hdf if float(dikte) < 4.0 else False
    # ----------

    values = default_values.copy()
    values.update({
        "MATERIAAL": attributes['classificacao'],
        "DIKTE": dikte,
        "RICHTING": richting,
        "LENGTE": lengte,
        "BREEDTE": breedte,
        "AANT" : nro_chapas,
        "PRIJS": preco,
        "REFER": attributes['descricao'],
        "BEM": attributes['codigo'],
        "SCHROOTW": schrootw,
        "ID": str(count[fabrica]) + ";CO",
    })

    if stph:
        values.update({
            "STPH": stph,
        })
    else:
        values = { key: values[key] for key in values if values[key] != '?' }

    # ----------
    # Preencher arquivo
    istd = "[ISTD-"+ str(count[fabrica]) +"]\n"

    for prioridade in files[fabrica]:
        files[fabrica][prioridade].write(istd)
    
    for i in values:

        if isinstance(values[i], dict):
            prioridades = values[i]

        # Cria a string
        string = {}
        if 'prioridades' in locals():
            for prioridade in prioridades:
                string[prioridade] = str(i) + "=" + str(prioridades[prioridade]) + "\n"
            del prioridades
        else:
            string['normal'] = string['prioridade'] = str(i) + "=" + str(values[i]) + "\n"

        # Adiciona o atributo ao arquivo
        for prioridade in files[fabrica]:
            files[fabrica][prioridade].write(string[prioridade])

    for prioridade in files[fabrica]:
        files[fabrica][prioridade].write(istd + "\n")
    # ----------

    count[fabrica] += 1

# ----------
# Preenchimento do rodape
for indice in count:
    for i in range(1, count[indice]):
        rodape = "[ISTD$FORM-"+ str(i) +"]\n\
SCHROOTW==-SheetPrice*" + str(valor_retalho) +"\n\
VLV==FIELD(PATH(FIELD (\"SUBSTS\";\"SubMCH\");SheetMach;\"mch\");\"MACHTB\";\"MachBookH\")/SheetThick\n\
[ISTD$FORM-"+ str(i) +"]\n\n"
        for local in files:
            for prioridade in files[local]:
                files[local][prioridade].write(rodape)   
# ----------