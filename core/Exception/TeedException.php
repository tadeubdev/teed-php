<?php

	class TeedException extends Exception
	{

		public $messages = [];

		public function setMessages()
		{

			if(count($this->messages)) return;

			ob_start();

			$vars = include 'Messages.php';

			ob_get_clean();

			$this->messages = $vars;

		}

		public function errorMessage( $type )
		{

			$data = func_get_args();

			array_shift( $data );

			//

			$this->setMessages();

			$message = $this->messages[ $type ];

			$debug = debug_backtrace();

			include 'PrintMessage.php';

			exit;

		}

	}