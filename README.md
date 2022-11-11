# MD-Furação

## Fase 1
- [x] Gerar modelo de relatório de ordem de corte no Ardis.
- [x] Criar ferramenta para gerar arquivo atualizado do estoque de chapas com base nos dados do sistema TOTVS. [python]
- [ ] Integrar o Ardis com a ferramenta criada.

## Fase 2
- [ ] Após os planos de corte serem processados, movimentar chapas (depósito -> fabrica) [python]
- [x] Enviar dados para API de controle na web. [python]
- [ ] Salvar dados localmente para prevenir eventuais falhas na rede.

## Fase 3
- [x] API receber dados de projetos do Ardis. [php]
- [ ] Sistema para usuário registrar o corte de chapas. [php] 
- [ ] Após o usuário dar baixa para finalizar processo, movimentar chapas (ardis -> fábrica) (retorno de peças: fabrica -> deposito)

## Movimentações API
- Fase 2 [python]:
	- Branca
		- Deposito: ALM -> ALM
		- Local: ALMB-A -> ARDISB
	- Vermelha
		- Deposito: ALM -> ALM
		- Local: ALMV-A -> ARDISV
- Fase 3 [php]:
	- Confirmar:
		- Branca:
			- Deposito: ALM -> FAB
			- Local: ARDISB ->
		- Vermelha:
			- Deposito: ALM -> FAB
			- Local: ARDISV ->
	- Cancelar:
		- Branca:
			- Deposito: ALM -> ALM
			- Local: ARDISB -> ALMB-A
		- Vermelha:
			- Deposito: ALM -> ALM
			- Local: ARDISV -> ALMV-A

## Gerar .exe a partir do .py
'''python
pyinstaller --onefile --windowed --icon=icon.ico --name=nome_do_executavel arquivo.py

C:\Users\t.flach\AppData\Local\Packages\PythonSoftwareFoundation.Python.3.11_qbz5n2kfra8p0\LocalCache\local-packages\Python311\Scripts\pyinstaller.exe --onefile --icon=img/scissors-solid.ico Gerenciador_Corte.py
'''