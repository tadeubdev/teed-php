# teed-php
TeedPHP Framework!

----

#### IMPORTANTE

O `TeedPHP` utiliza o gerenciador de pacotes [composer](https://getcomposer.org/) para facilitar a inclusão de bibliotecas de terceiros e até mesmo o [TeedPHP Framework](https://github.com/tadeubarbosa/teed-php-frame) (que é o responsável por fazer tudo isso funcionar), então antes de qualquer coisa vá até o site e instale o composer. Depois rode no `cmd`: composer install e o composer instalará as dependências.

----

#### Framework

- Facilita a criação de arquivos PHP, HTML, SCSS, AngularJs.

- Criação de Template para o PHP, exemplo:

    ````php
    static function getProfile( $id )
    {
        $profile = UserService::find($id);

        if( !count( $profile ) ):

            self::$data['title'] = "Profile not found";

            self::getView('profile-not-found');

        else:

            self::$data['title'] = "{$user->name}'s Profile";

            $user = String::getData( $user );

            self::$data['user'] = $user;

            self::getView('profile');

        endif;
    }
    ````

    ````html
    {{ Html::h1( "Olá {$user->name}!" ) }}

    <button ng-click="ConfigThisProfile()">

        <i class="fa fa-cog"></i> &nbsp;

        Configurar perfil

    </button>
    ````