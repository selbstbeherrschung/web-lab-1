var checkSetR = false;

function checkText(f){
    var str = text_input.value;
    if (isNaN(str)){
        alert(str + " is wrong. You should write int number!");
    }else {
        var i = parseFloat(str);
        if(i >= -5 && i <=3) {
            text_input.value = i;
            if(checkSetR){
                f.submit();
            }else {
                alert("Please, choose R by button");
            }

        }else {
            alert(str + " isn't in range(-5:3)!");
        }
    }
}

function setR(int) {
    document.getElementById("vR").setAttribute("value",int);
    alert("Done");
    checkSetR = true;
}