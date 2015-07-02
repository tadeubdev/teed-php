<?php

	return [

		/////
		/// USADO EM SEUS PROJETOS EM PRODUÇÃO
		'production' => [

			/////
			/// ALTERAR COM O NOME DO HOST
			'match' => 'teedphp.com.br',

			/////
			/// ALTERAR COM OS DADOS DO BD
			'database' => [

				'name' => '123.45.67',

				'user' => 'TeedPhp',

				'pass' => '123456',

				'db' => 'teed_php'

			],

			///// COMPRESSAR O HTML
			'compress_output' => true,

		],

		/////
		/// USADO EM SEU PROJETO LOCAL
		'local' => [

			/////
			/// NÃO ALTERAR
			'match' => '*',

			/////
			/// PREENCHER COM OS DADOS DO BD
			'database' => [

				'name' => 'localhost',

				'user' => 'root',

				'pass' => '',

				'db' => 'teed_php'

			],

			///// COMPRESSAR O HTML
			'compress_output' => true,

		],

	];