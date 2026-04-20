# Universidade Federal do Tocantins (UFT)

**👥 Equipe**
* **Anna Beatriz Moura de Oliveira**
* **Grazyelle Nayara Bento dos Santos**
* **Pedro Ryan Oliveira de Almeida**
* **Ricardo Lopes Tomaz**

**Professor:** Edeilson Milhomem da Silva  
**Disciplina:** Engenharia de Software  
**Semestre:** 2026.1

## 🚗 Drive Lux
O Drive Lux é um sistema de locação de veículos de alto padrão, focado em marcas de luxo como Porsche, Ferrari e Rolls-Royce.

A aplicação permite gerenciar o cadastro de clientes, veículos e locações, oferecendo controle completo sobre o processo de aluguel de carros de luxo.

Entre as principais funcionalidades do sistema estão:
- Cadastro e gerenciamento de clientes
- Cadastro de veículos de luxo
- Controle de disponibilidade dos carros
- Registro e gerenciamento de locações

---

## 📂 Estrutura do Projeto

A organização de pastas segue padrões de mercado para garantir escalabilidade e organização via **GitFlow**:

### 1. `/public`
Ponto de entrada da aplicação. É a pasta que deve ser servida pelo Apache.

### 2. `/includes`
Arquivos reutilizáveis, como:
- `Cabeçalhos`
- `Rodapés`
- `Conexões auxiliares`

### 3. `/modules`
Responsável pela separação das funcionalidades do sistema:
- `Clientes`
- `Veículos`
- `Locações`

### 4. `/config`
Configurações críticas e sensíveis do ambiente.
- `database.php`: Gerenciamento da conexão PDO/MySQL.

### 5. `/docs`
Documentação técnica do projeto.
- `schema.sql`: Script de criação das tabelas e relacionamentos.

---
## 🔀 Padrão de Versionamento
O projeto utiliza o GitFlow, com as seguintes branches principais:

- `main` → versão estável
- `develop` → desenvolvimento contínuo
- `feature/*` → novas funcionalidades
- `fix/*` → correções de erros 
- `refactor/*` → reorganização no código


## 🚀 Como rodar o projeto localmente

1. **Clone o repositório** dentro da pasta `htdocs` do seu servidor local (XAMPP/WAMP).
   >    ```bash
   >  git clone <url-do-repositorio>
3. **Configure o Banco de Dados**:
   - Ative o MySQL no seu painel de controle.
   - Importe o arquivo `/docs/schema.sql` via PHPMyAdmin.
4. **Ajuste a Conexão**: Verifique as credenciais no arquivo `/config/database.php`.
5. **Acesse no navegador**: `http://localhost/locadora_carros/public/`

---

## 🛠️ Tecnologias Utilizadas
- **Linguagem:** PHP 8.x
- **Banco de Dados:** MySQL
- **Interface:** HTML5 / CSS3 (Grid Layout & Flexbox)
- **Versionamento:** Git com fluxo GitFlow

## 📄 Licença
Este projeto está sob a licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.
