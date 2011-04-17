<?php
return "calc = function(number) {
    if (parseInt(number / 1000) > 0) {
        var r = number % 1000;
        if (r == 0) {
            r = '000';
        } else if (r < 10) {
            r = '00' + r;
        } else if (r < 100) {
            r = '0' + r;
        }
        return calc(parseInt(number / 1000)) + \"".$this->separator."\" + r;
    } else {
        return number % 1000;
    }
}
$('".$this->selector."').live('keyup', function() {
    if ($(this).val().length > 0) {
        var vl = $(this).val().replace(/\./g, \"\");
        var num = parseInt(vl);
        $(this).val(calc(num));
    }
});";

?>
