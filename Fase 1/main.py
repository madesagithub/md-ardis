from colorama import Fore, Back, Style

import formatacao as formatacao
import regras as regras
# import consultar_retalhos as consultar_retalhos

class bcolors:
    HEADER = '\033[95m'
    OKBLUE = '\033[94m'
    OKCYAN = '\033[96m'
    OKGREEN = '\033[92m'
    WARNING = '\033[93m'
    FAIL = '\033[91m'
    ENDC = '\033[0m'
    BOLD = '\033[1m'
    UNDERLINE = '\033[4m'


print(bcolors.OKGREEN + '\n1 - Formatação' + bcolors.ENDC)
formatacao.main()

print(bcolors.OKGREEN + '\n2 - Regras' + bcolors.ENDC)
regras.main()

print(bcolors.OKGREEN + '\n3 - Consulta de retalhos' + bcolors.ENDC)
# consultar_retalhos.main()