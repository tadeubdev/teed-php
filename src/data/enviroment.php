<?php

	return [

		## USADO EM SEUS PROJETOS EM PRODUÇÃO
		'production' => [

			## ALTERAR COM O NOME DO HOST
			'match' => 'tadeubarbosa.com.br',

			## ALTERAR COM OS DADOS DO BD
			'database' => [

				'name' => 'tadeubarbosa.com.br',

				'user' => 'tadeu826',

				'pass' => '7vw7CD10ke',

				'db' => 'tadeu826_site'

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