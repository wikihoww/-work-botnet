<?php
function sqlPrep($Str)
{
if (is_array($Str))
{
debug_print_backtrace();
echo "<P>Array encountered!</P>";
print_br($Str);
DIE;
}

return addslashes(chop(stripslashes($Str)));
}

?>