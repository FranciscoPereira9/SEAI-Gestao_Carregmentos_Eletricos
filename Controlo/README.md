# Controlo

A componente de Controlo do sistema está sub-decomposta em 3 partes principais: armazenamento, comunicação, algoritmo de controlo de potência e *stubs* de simulação.
Desta forma, relativamente ao armazenamento, este é responsável pela estruturação da base de dados e pela interacção com a mesma. A comunicação consiste no servidor de comunicação TCP que gere todas as comunicações vindas dos restantes componentes do sistema. O algoritmo de controlo trata do balanceamento de potência e de garantir que as condições necessárias ao funcionamento dos carregamentos se encontram reunidas. E por último, os *stubs* simulam o funcionamento do carregador, isto é, a ligação do veículo ao carregador e o processo de carregamento.

## Comunicação

Para a comunicação optou-se pelo protocolo TCP visto ser um protocolo orientado à conexão e que visa garantir que a entrega e receção de mensagens ocorre sem perda de informação. A alternativa seria usar o protocolo UDP que, embora tenha performance temporal superior, crê-se ser inferior ao protocolo TCP, no contexto da aplicação.
A comunicação ocorre entre os carregadores e o Subsistema de Controlo, e entre o Subsistema de Controlo e os restantes subsistemas.

## Algoritmo

O algoritmo é referente a todo o código planificado e implementado no que toca à automatização do controlo do carregamento de veículos elétricos. Este por si está subdividido em três componentes: balanceamento de potência, monitorização de consumos e atualização da base de dados.
* Balanceamento de Potência: é a parte do algoritmo que faz o cálculo da potência instantânea disponível para carregamentos, assim como a distribuição dessa mesma potência pelos diferentes carregadores, tendo em conta o tipo de carregamento desejado.
* Monitorização de consumos: é referente à monitorização da potência consumida, assim como da quantidade de carregadores a serem utilizados simultaneamente e outros dados que possam ter relevância para o subsistema de gestão e monitorização.
* Atualização da Base de Dados: é a parte do algoritmo responsável pelo armazenamento dos diferentes dados na base de dados, para que possam ser acedidos quer para fins estatísticos, quer para fins de monitorização.

## Armazenamento

Uma base de dados é um conjunto de informação organizada e tipicamente guardada eletronicamente num sistema computacional.  
O sistema, como apresentado no Conceito de Sistema, interage com uma Base de Dados externa. Esta permite organizar e relacionar os dados gerados pelo sistema, assim como disponibilizar, de forma simples e eficiente, informação às várias componentes do mesmo. 
O armazenamento desta informação na base de dados é executado no Algoritmo, na componente de Controlo. Os dados relevantes são colocados na base de dados quando existe uma alteração dos mesmos.  
Dados relevantes a serem guardados na base de dados são:
* Potência de Consumo;
* Tempo de Chegada;
* Tempo de Partida;
* Custo;
* ID utilizador;
* ID carregador.

O sistema de gestão de base de dados a utilizar é PostgreSQL, fornecido pela FEUP e de uso simples e prático. 

## Stubs

Para poder desenvolver e testar corretamente o resto da aplicação é necessário simular certos detalhes do carregamento em si. Em conformidade com o resto da aplicação, toda a comunicação foi feita usando como base o protocolo TCP. Para simular o ligar e o funcionamento interno de um dado carregador, foi desenvolvido um pequeno programa ao qual chamamos de "stub". Os stubs simulam as seguintes situações:
* Conectar/desconectar do carregador ao veículo;
* Bateria dentro do veículo;
* Dinâmica carregador-controlo, onde o controlo comanda o comportamento do carregador.

## Autores
* David Viana - up201606636@fe.up.pt
* Francisco Pereira - up201605306@fe.up.pt
* Marco Rocha - up201604163@fe.up.pt
* Simão Quintans - up201504961@fe.up.pt
