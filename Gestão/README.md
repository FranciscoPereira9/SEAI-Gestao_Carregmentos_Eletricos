# Gestão e Monitorização

O sistema possui uma plataforma cuja função é permitir a gestão de grupos de carregadores por parte do gestor/administrador do grupo local. Esta plataforma consiste numa página web que dispõe de várias ferramentas que facilitam a tarefa do operador. Através da página web, o administrador pode:
* Consultar o estado atual de cada carregador, incluindo o seu estado de funcionamento (ligado ou desligado), consumo instantâneo e outras grandezas.
* Consultar estatísticas referentes ao grupo local de carregadores, como a potência média fornecida por cada carregador e o número de carregamentos de cada tipo efetuados no grupo local (normal, rápido ou verde).
* Consultar e silenciar vários alertas que indicam avarias ou mau funcionamento de várias partes do sistema.
* Consultar e editar os preços de carregamento estabelecidos para o grupo de carregadores.

## Visão geral da página de Gestão e Monitorização

<img width="760" alt="gestao1" src="https://user-images.githubusercontent.com/47570179/105554762-ec8cd300-5cff-11eb-9c9b-002cedc6de16.PNG">

Para o desenvolvimento desta plataforma foram utilizadas linguagens de programação web habituais (html, css, php e javascript). A sua implementação foi feita no gnomo.fe.up.pt, o servidor de desenvolvimento disponibilizado pela FEUP aos alunos.

Esta plataforma possui também acesso, não só á base de dados (PostGreSQL), mas também uma ligação ao sistema de controlo através do protocolo TCP-IP de forma a permitir a interrupção do normal funcionamento dos carregadores em caso de avaria ou necessidade.

## Estatísticas

<img width="778" alt="gestao2" src="https://user-images.githubusercontent.com/47570179/105554798-fc0c1c00-5cff-11eb-9151-60c9e2b992f1.PNG">


## Autores
* Francisco Costa - up201604136@fe.up.pt
