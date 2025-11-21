# Stremiohub
Descrição do Sistema

O StreamHub é um sistema web de streaming que permite gerenciar usuários, planos de assinatura, filmes, séries e seus episódios.
O sistema também controla o histórico de visualizações, garantindo que usuários só possam assistir conteúdos liberados pelo seu plano.

Ele será desenvolvido com HTML, CSS e PHP, usando CRUD completo para todas as entidades principais.

✅ Entidades e Atributos

1. Usuário
id_usuario (PK)
nome
email
senha
data_nascimento
id_plano (FK)
data_assinatura
ativo (1 = ativo, 0 = cancelado)

2. Plano
id_plano (PK)
nome_plano
preco
limite_telas
qualidade_video (SD / HD / FullHD / 4K)

3. Conteúdo (pai para filmes e séries)
id_conteudo (PK)
titulo
descricao
categoria (Ação, Drama, Infantil etc.)
tipo (filme / serie)
classificacao_indicativa
duracao (para filmes) → opcional
ano_lancamento
capa_url

4. Episodio (somente se for série)
id_episodio (PK)
id_conteudo (FK — série)
titulo
numero_temporada
numero_episodio
duracao
video_url

5. Historico
id_historico (PK)
id_usuario (FK)
id_conteudo (FK)
id_episodio (FK) — opcional (NULL se for filme)
data_visualizacao
progresso (0–100%)

✅ Regras de Negócio (mínimo 5 — aqui estão 8)
Usuários só podem assistir conteúdos compatíveis com a classificação indicativa (idade mínima).
O número de telas simultâneas não pode ultrapassar o limite do plano.
Um usuário só pode acessar conteúdos se sua assinatura estiver ativa.
Episódios só podem ser cadastrados se o conteúdo for do tipo “serie”.
Filmes não podem ter episódios vinculados.
Um plano só pode ser excluído se não houver usuários associados.
Históricos não podem ser excluídos — apenas marcados como 100% concluídos.
Apenas usuários com mais de 18 anos podem acessar conteúdos +18.
