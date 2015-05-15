# teed-php
TeedPHP Framework!

----

#### IMPORTANTE

O `TeedPHP` utiliza o gerenciador de pacotes [composer](https://getcomposer.org/) para facilitar a inclusão de bibliotecas de terceiros e até mesmo o [TeedPHP Framework](https://github.com/tadeubarbosa/teed-php-frame) (que é o responsável por fazer tudo isso funcionar), então antes de qualquer coisa vá até o site e instale o composer. Depois rode no `cmd`: composer install e o composer instalará as dependências.

----

#### Framework

- Facilita a criação de arquivos PHP, HTML, SCSS, AngularJs.

- Criação de Template para o PHP, exemplo:

    ````html

    @if( $user->logado() )

        {{ Html::h1("Olá $user->username") }}!

    @else

        <button class="btn-warning" ng-click="OpenBoxLogin()">

            <i class="fa fa-user"></i> &nbsp;

            Efetue login

        </button>

    @endif
    ````