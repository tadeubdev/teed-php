<?php

	namespace Controller;

	class Membros
	{

		use Base;

		public static $base = 'membros';

		//

		public static function getHome()
		{

			self::$data['title'] = 'Membros';

			self::$data['menu'] = ['Membros'];

			self::$data['css'] = 'membros';

			self::getView();

		}

		public static function postHome( $ids )
		{

			self::$data['dados'] = \MembrosServices::find('all',['limit'=>2]);

			return \Response::json( $membros );

		}

		public static function getPrint()
		{

			self::$data['title'] = 'Print';

			self::$data['css'] = 'membros';

			$valores = \MembrosServices::find('all',['limit'=>4]);

			$data = array_chunk( $valores, 5 );

			self::$data['data'] = $data;

			self::getView('print');

		}

		public static function getNovosDados()
		{

			self::$data['title'] = 'Novos Dados';

			self::$data['menu'] = [['membros','Membros'],'Novos Dados'];

			self::getView('novos');

		}

		public static function postNovosDados()
		{

			$file = $_FILES['file']['tmp_name'];

			$data = new \Spreadsheet_Excel_Reader($file,true,"UTF-16");

			$valores = [];

			$names = \Files::getData('colsname.php');

			for( $x=2; $x<=$data->rowcount(); $x++ ):

				if( !empty( $data->val( $x, 'A' ) ) ):

					for( $y=0; $y<$data->colcount(); $y++ ):

						$value = $data->val( $x, range('a','z')[$y] );

						$name = utf8_encode($data->val( 1, range('a','z')[$y] ));

						if( strlen($name) && isset($names[ $name ]) ):

							$name = $names[ $name ];

							$dados[ $name ] = $value;

						endif;

					endfor;

					$valores[] = $dados;

				endif;

			endfor;

			foreach( $valores as $data ):

				$verify = \MembrosServices::exists(array('numero' => $data['numero']));

				if( $verify ):

					$row = \MembrosServices::find_by_numero( $data['numero'] );

				else:

					$row = new \MembrosServices;

				endif;

				foreach( $data as $key => $value ):

					$row->$key = $value;

				endforeach;

				$row->save();

			endforeach;

			return \Url::route('membros-dados');

		}

	}