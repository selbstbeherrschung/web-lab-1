function checkText(f){
    var str = text_input.value;
    if (isNaN(str)){
        alert(str + " is wrong. You should write int number!");
    }else {
        var i = parseFloat(str);
        alert(i);
        if(i >= -5 && i <=3) {
            text_input.value = i;
            f.submit();
        }else {
            alert(str + " isn't in range(-5:3)!")
        }
    }
}
