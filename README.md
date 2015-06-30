<h1> TeedPHP Framework! </h1>

<h2> IMPORTANTE </h2>

O `TeedPHP` utiliza o gerenciador de pacotes [composer](https://getcomposer.org/) para facilitar a inclusão de bibliotecas de terceiros e até mesmo o [TeedPHP Framework](https://github.com/tadeubarbosa/teed-php-frame) (que é o responsável por fazer tudo isso funcionar), antes de qualquer coisa vá até o site e faça o download do composer.

Após instalar o `composer`, você estará pronto para instalar o TEEDPHP:

> $ git clone https://github.com/tadeubarbosa/teed-php

> $ composer install

<hr>

<p align="center">
  <img src="www/images/8234237489023844903.jpg?raw=true" />
</p>

<hr>

<h2> Framework </h2>

- Facilita a criação de arquivos PHP, HTML, SCSS, AngularJs.

- Criação de Template para o PHP, exemplo:

````php
// src/routes.php
Route::group('profile', 'Profile',
[

    ['/:user', 'getProfile', 'profile']

]);
````

````php
// src/controller/Profile.php

static function getProfile( $id )
{
    $profile = UserService::find($id);

    $profile = String::getData( $profile );

    if( !$profile ) return self::getProfileNotFound( $id );

    self::$data['title'] = "{$user->name}'s Profile";

    $user = String::getData( $user );

    self::$data['user'] = $user;

    self::getView();
}

static function getProfileNotFound( $id )
{
    self::$data['title'] = "Profile not found";

    self::$data['profile'] = $id;

    self::getView('not-found');
}
````

````html
// src/views/profile/index.php

<a href="@link("users/{$user->slug}/message")"> mensagens </a>

<a href="@link("users/{$user->slug}/friends")"> amigos </a>

<hr>

{{ Html::h1( "Olá {$user->name}!" ) }}
````

````html
// src/views/profile/not-found.php

<h1> OPS! </h1>

<h2> O perfil {{ Html::strong($profile) }} não foi encontrado </h2>

<a href="@base()"> ir para a home  </a>
````
