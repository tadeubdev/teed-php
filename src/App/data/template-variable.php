<?php

	if( !function_exists('php') ):

		function php($str) { return "<?php $str ?>"; }

	endif;

	return [

		['@setContent(\'*\')',  php('Engine::setContent(\'$2\', function(){') ],

		['@endcontent',  php('} );') ],

		['@getContent(\'*\')',  php('Engine::getContent(\'$2\')') ],

		//

		['@template(*)', php('Engine::setTemplate($2)') ],

		//

		['@utf8( *, * )', php('if(is_string($3)){return utf8_encode($3);}elseif(is_object($3)){foreach($3 as $aKey => $aValue){$3->$aKey=utf8_encode($aValue);}}elseif(is_array($3)){foreach($3 as $aKey => $aValue){$3[\'$aKey\']=utf8_encode($aValue);}} $2=$3;') ],

		['@utf8(*)', php('if(is_string($2)){return utf8_encode($2);}elseif(is_object($2)){foreach($2 as $aKey => $aValue){$2->$aKey=utf8_encode($aValue);}}elseif(is_array($2)){foreach($2 as $aKey => $aValue){$2[\'$aKey\']=utf8_encode($aValue);}}') ],

		//

		['@objectUtf8( *, * )', php('$2=(object)$3;foreach($2 as $aKey=>$aValue){$2->$aKey=utf8_encode($aValue);}') ],

		['@objectUtf8(*)', php('$2=(object)$2') ],

		//

		['@arrayUtf8( *, * )', php('foreach($2 as $aKey=>$aValue){$2[\'$aKey\']=utf8_encode($aValue);}') ],

		//

		['@object( *, * )', php('$2 = (object) $3') ],

		['@object(*)', php('$2 = (object) $2') ],

		//

		['@array(*)', php('$2 = (array) $2') ],

		//

		['@base(*)', php('echo App::getBase($2)') ],

		['@image(*)', php('echo App::getImageDir($2)') ],

		['@script(*)', php('echo App::getScriptDir($2)') ],

		['@link(*)', php('echo App::getBase($2)') ],

		//

		['@include(*)', php('Engine::includeFile( App::getViewsDir() . $2 )') ],

		['@includePartial(*)', php('Engine::includePartial($2)') ],

		//

		['@if(*) * )', php('if($2) $3 ):') ],

		['@if(*) )', php('if($2) ):') ],

		['@if(*)', php('if($2):') ],

		['@elseif(*) )', php('elseif($2) ):') ],

		['@elseif(*)', php('elseif($2):') ],

		['@else', php('else:') ],

		['@endif', php('endif;') ],

		//

		['@foreach(*) as * )', php('foreach($2) as $3 ):') ],

		['@foreach(*) )', php('foreach($2) ):') ],

		['@foreach(*)', php('foreach($2):') ],

		['@endforeach', php('endforeach;') ],

		//

		['@for(*) )', php('for($2) ):') ],

		['@for(*)', php('for($2):') ],

		['@endfor', php('endfor;') ],

		//

		['@while(*) )', php('while($2) ):') ],

		['@while(*)', php('while($2):') ],

		['@endwhile', php('endwhile;') ],

		//

		['{{{ * }}}', php('$2;') ],

		['{{ * }}', php('echo $2;') ],

	];