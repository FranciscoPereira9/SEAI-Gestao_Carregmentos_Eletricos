# Interface com o Utilizador

Como requisito mínimo foi definido que a interface do sistema com o utilizador seria realizada através da interface local, isto é, pelo ecrã do próprio carregador disponível no local. Desta forma, começou-se por desenvolver tal interface e, após esta se encontrar funcional, a equipa de desenvolvimento focou-se nos requisitos adicionais definidos na fase inicial do projeto. Sendo a base desses requisitos adicionais o desenvolvimento de uma aplicação para dispositivos móveis. O principal objetivo desta era que tivesse por base as mesmas funcionalidades que a interface local e, após estar funcional, ir adicionando funcionalidades para melhorar a experiência do utilizador com a aplicação.

Para a comunicação com o subsistema do controlo e com a base de dados, desenvolveu-se uma API que se encarrega de tais funções. Deste modo, tanto a interface local como a aplicação móvel, apenas necessitam de enviar pedidos à API de acordo com a informação que necessitam, em vez de estabelecerem os seus próprios protocolos TCP.

## Aplicação para dispositivos móveis (Android)

### Overview da App
![Estrutura](https://user-images.githubusercontent.com/47570179/105553859-24931680-5cfe-11eb-92d2-ac456e6e4e08.jpg)

### Sequência de carregamento
![SequenciaCarregamento](https://user-images.githubusercontent.com/47570179/105553458-52c42680-5cfd-11eb-9218-d124b9fc3a19.jpg)


## Interface Local
### Sequência de carregamento
![mockup](https://user-images.githubusercontent.com/47570179/105553817-09c0a200-5cfe-11eb-8317-9f6511755217.jpg)

## Autores
* André Martins - up201605016@fe.up.pt
* Inês Soares - up201606615@fe.up.pt
