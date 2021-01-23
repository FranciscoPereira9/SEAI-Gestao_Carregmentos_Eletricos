# Controlo

A componente de Controlo do sistema está sub-decomposta em 3 partes principais: armazenamento, comunicação, algoritmo de controlo de potência e *stubs* de simulação.
Desta forma, relativamente ao armazenamento, este é responsável pela estruturação da base de dados e pela interacção com a mesma. A comunicação consiste no servidor de comunicação TCP que gere todas as comunicações vindas dos restantes componentes do sistema. O algoritmo de controlo trata do balanceamento de potência e de garantir que as condições necessárias ao funcionamento dos carregamentos se encontram reunidas. E por último, os *stubs* simulam o funcionamento do carregador, isto é, a ligação do veículo ao carregador e o processo de carregamento.

## Autores
* David Viana - up201606636@fe.up.pt
* Francisco Pereira - up201605306@fe.up.pt
* Marco Rocha - up201604163@fe.up.pt
* Simão Quintans - up201504961@fe.up.pt
