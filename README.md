# SEAI - Sistema de Gestão de Carregamentos de Veículos Elétricos

Este projeto foi realizado no âmbito da unidade curricular de Sistemas de Engenharia - Automação e Instrumentação, inserida no Mestrado Integrado de Engenharia Electrotécnica e de Computadores da Faculdade de Engenharia da Univerdidade do Porto. O projeto proposto foi o desenvolvimento de um sistema de gestão de carregamento de veículos elétricos, com vista a aplicá-lo num parque de carregamento público ou privado (por exemplo, parque da Faculdade de Engenharia ou de um supermercado). O projeto foi supervisionado pelo professor António Carrapatoso e o cliente foi o Engenheiro David Rua do INESCTEC. A autoria deste projeto pertence à Equipa G, constituída pelos elementos: André Martins, Daniel Luiz, David Viana, Francisco Pereira, Francisco Costa, Hugo Marques, Inês Soares, Marco Rocha e Simão Quintans.

![logo_seai](https://user-images.githubusercontent.com/47570179/105549365-c31c7900-5cf8-11eb-8e17-96c4c2617ad5.png)

O sistema desenvolvido tem como objetivo principal garantir uma boa gestão de um conjunto de carregadores de veículos elétricos existentes numa dada infraestrutura. Este sistema foi subdividido em Interface, Controlo e Gestão e Monitorização. O conjunto de módulos interage com agentes externos, mais concretamente: o utilizador, o operador, o carregador e a base de dados.

![ConceitoSistema](https://user-images.githubusercontent.com/47570179/105549197-89e40900-5cf8-11eb-95fb-c82cae237f7c.jpg)

O funcionamento do sistema inicia-se com a utilização da Interface pelo Utilizador. Nesta interface é apresentada a possibilidade ao utilizador de selecionar o modo de carregamento, consultar o custo associado instantaneamente e interromper a operação. Consequentemente, a Interface fornece a informação gerada pelo utilizador ao módulo de Controlo. O Controlo, com base na informação recebida pelas Interfaces e respetivos carregadores, gere individualmente a potência disponível segundo os critérios de controlo. Toda a informação gerada relativa ao consumo dos diferentes carregadores é armazenada diretamente na Base de Dados. O módulo de Controlo também transmite periodicamente para o módulo de Gestão e Monitorização o consumo instantâneo de cada carregador e o seu respetivo estado (ligado ou desligado a um veículo), de forma a que este possa apresentar corretamente o estado atual do sistema e permitir intervenções corretas da parte do Operador. Compete também ao módulo de Gestão e Monitorização fornecer ao Operador controlo sobre o conjunto de carregadores através da interrupção selectiva ou conjunta dos mesmos. A acção é transmitida para o módulo de Controlo que as transmite para os carregadores respetivamente.

![Design-SBS_vertical](https://user-images.githubusercontent.com/47570179/105550874-d8de6e00-5cf9-11eb-985a-cfb603f87058.png)

## Autores
* André Martins - up201605016@fe.up.pt
* Daniel Luiz - up201703713@fe.up.pt
* David Viana - up201606636@fe.up.pt
* Francisco Pereira - up201605306@fe.up.pt
* Francisco Costa - up201604136@fe.up.pt
* Hugo Marques - up201506023@fe.up.pt
* Inês Soares - up201606615@fe.up.pt
* Marco Rocha - up201604163@fe.up.pt
* Simão Quintans - up201504961@fe.up.pt
