<?php

return array(

    array('@setContent(*)',  '{-- setcontent($2) --}' ),

    array('@endcontent',  '{-- endcontent --}' ),

    array('@getContent(*)',  '{-- getContent($2) --}' ),

    array('@template(*)', '{-- setTemplate($2) --}' ),

    array('@include(*)', '{-- includeFile($2) --}' ),

    array('@includePartial(*)', '{-- includePartial($2) --}' ),

    #

    array('@base(*)', String::php('echo App::getBase($2)') ),

    array('@image(*)', String::php('echo Dir::getImage($2)') ),

    array('@script(*)', String::php('echo Dir::getScript($2)') ),

    array('@link(*)', String::php('echo App::getBase($2)') ),

    array('@if*', String::php('if$2:'), true ),

    array('@elseif*', String::php('elseif$2:'), true ),

    array('@if(*) * )', String::php('if($2) $3 ):') ),

    array('@if(*) )', String::php('if($2) ):') ),

    array('@if(*)', String::php('if($2):') ),

    array('@elseif(*) )', String::php('elseif($2) ):') ),

    array('@elseif(*)', String::php('elseif($2):') ),

    array('@else', String::php('else:') ),

    array('@endif', String::php('endif;') ),

    array('@foreach*', String::php('foreach$2:'), true ),

    array('@endforeach', String::php('endforeach;') ),

    array('@for*', String::php('for$2:'), true ),

    array('@endfor', String::php('endfor;') ),

    array('@switch*', String::php('switch$2:'), true ),

    array('@endswitch', String::php('endswitch;') ),

    array('@while*', String::php('while$2:'), true ),

    array('@endwhile', String::php('endwhile;') ),

    array('{{{ * }}}', '<?php $2; ?>' ),

    array('{{- * -}}', ''),

    array('{{ * }}', String::php('echo $2;') ),

);
