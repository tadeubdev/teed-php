<?php

    return [

        ## USADO EM SEUS PROJETOS EM PRODUÇÃO
        'production' => [

            ## ALTERAR COM O NOME DO HOST
            'match' => '##',

            ## ALTERAR COM OS DADOS DO BD
            'database' => [

                'name' => '##',

                'user' => '#',

                'pass' => '#',

                'db' => '#'

            ],

            'compress_output' => true,

        ],

        ## USADO EM SEU PROJETO LOCAL
        'local' => [

            ## NÃO ALTERAR
            'match' => '*',

            ## PREENCHER COM OS DADOS DO BD
            'database' => [

                'name' => 'localhost',

                'user' => 'root',

                'pass' => '',

                'db' => 'tadeubarbosa'

            ],

            'compress_output' => false,

        ],

    ];
