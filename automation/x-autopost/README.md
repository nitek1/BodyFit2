# X autopost gratis

Esse fluxo foi pensado para rodar de graca no `GitHub Actions`.

Ele funciona assim:
- busca manchetes quentes de tecnologia no Hacker News
- prioriza assuntos de IA, chips, open models, agentes e infraestrutura
- monta um post curto em portugues
- publica no X pela API oficial

## O que voce precisa

Crie um repositorio no GitHub com estes arquivos e adicione estes `Secrets and variables > Actions > New repository secret`:

- `X_API_KEY`
- `X_API_SECRET`
- `X_ACCESS_TOKEN`
- `X_ACCESS_TOKEN_SECRET`

## Como testar

1. Envie os arquivos para um repositorio seu no GitHub.
2. Abra a aba `Actions`.
3. Rode o workflow `X Autopost`.
4. No primeiro teste, deixe `dry_run=true`.
5. Veja o texto gerado no log.
6. Depois rode de novo com `dry_run=false`.

## Horario automatico

O workflow esta programado para rodar todo dia as `09:17` no horario de Brasilia.

O cron no GitHub Actions usa `UTC`, por isso o arquivo esta com:

```yaml
- cron: "17 12 * * *"
```

## Limites importantes

- Workflows agendados rodam so na `default branch`.
- Em repositorio publico, o GitHub pode desativar workflows agendados apos `60 dias` sem atividade.
- Isso usa a `API do X`, entao voce precisa ter as credenciais de desenvolvedor do X configuradas.

Fonte GitHub Actions:
- https://docs.github.com/en/actions/reference/events-that-trigger-workflows

Fonte X API:
- https://developer.x.com/en/docs/x-api/tweets/manage-tweets/migrate/manage-tweets-standard-to-twitter-api-v2
