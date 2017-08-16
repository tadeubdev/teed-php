<?php

# Configura as datas
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
Carbon\CarbonInterval::setLocale('pt_BR');

# Configura os dados do Input
Input::configureInputData();

# Inicia as variaveis da aplicação
App::startTheApplicationVariables();

# Adiciona as informações do arquivo a class `site`
Site::all( Files::getData('website.php') );

# Busca pelo enviromet e seta-o
foreach (Files::getData('enviroment.php') as $name => $value) {
    $match = str_replace('*', '(.*)', $value->match);

    # Busca pelo host atual
    if (preg_match("/{$match}/", $_SERVER['HTTP_HOST'])) {
        $value->name = $name;
        App::setEnv( $value );
        break;
    }
}

# Busca pelas configuraçoes das Rotas: id, name etc
require_once Dir::getCore('Routers/configurations.php');

# Busca pelas rotas setadas pelo programador
require_once Dir::getSrc('routes.php');

# Inicializa o TeedCss
TeedCss\Initialize::start();

App::confTemplateRoutes();
