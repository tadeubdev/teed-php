<?php

	return [

		['@setContent(*)',  '{-- setcontent($2) --}' ],

		['@endcontent',  '{-- endcontent --}' ],

		['@getContent(*)',  '{-- getContent($2) --}' ],

		['@template(*)', '{-- setTemplate($2) --}' ],

		['@include(*)', '{-- includeFile($2) --}' ],

		['@includePartial(*)', '{-- includePartial($2) --}' ],

		//

		['@base(*)', String::php('echo App::getBase($2)') ],

		['@image(*)', String::php('echo App::getImageDir($2)') ],

		['@script(*)', String::php('echo App::getScriptDir($2)') ],

		['@link(*)', String::php('echo App::getBase($2)') ],

		['@if*', String::php('if$2:'), true ],

		['@elseif*', String::php('elseif$2:'), true ],

		['@if(*) * )', String::php('if($2) $3 ):') ],

		['@if(*) )', String::php('if($2) ):') ],

		['@if(*)', String::php('if($2):') ],

		['@elseif(*) )', String::php('elseif($2) ):') ],

		['@elseif(*)', String::php('elseif($2):') ],

		['@else', String::php('else:') ],

		['@endif', String::php('endif;') ],

		['@foreach*', String::php('foreach$2:'), true ],

		['@endforeach', String::php('endforeach;') ],

		['@for*', String::php('for$2:'), true ],

		['@endfor', String::php('endfor;') ],

		['@switch*', String::php('switch$2:'), true ],

		['@endswitch', String::php('endswitch;') ],

		['@while*', String::php('while$2:'), true ],

		['@endwhile', String::php('endwhile;') ],

		['{{{ * }}}', '<?php $2; ?>' ],

		['{{- * -}}', ''],

		['{{ * }}', String::php('echo $2;') ],

	];