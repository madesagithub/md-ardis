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
	- ALM -> ARDISB ou 
	- ALM -> ARDISV
- Fase 3 [php]:
	- Confirmar:
		- ARDISB -> FAB ou
		- ARDISV -> FAB
	- Cancelar:
		- ARDISB -> ALMB-A ou
		- ARDISV -> ALMV-A