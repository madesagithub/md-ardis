ordem
peca
quantidade
chapa(cadastro)
chapa(utilizada)
data


SELECT projetos.nome as "Projeto", pecas.codigo as "Codigo chapa", chapas.codigo, planos.quantidade_chapa, chapa_cadastro, chapa_utilizada, projetos.data_processamento


SELECT projetos.nome as "Projeto", chapas.codigo as "Codigo chapa", planos.quantidade_chapa as "Quantidade de chapas", projetos.data_processamento as "Data de processamento"
FROM projetos
JOIN planos ON planos.projeto_id = projetos.id
JOIN chapas ON planos.chapa_id = chapas.id
-- GROUP BY chapas.codigo
-- JOIN ordens 