var checkSetR = false;
var servDom = 'http://localhost';


function checkText() { //Проверка введённого в поле и реакция
    var str = text_input.value;
    if (isNaN(str)) {
        alert(str + " is wrong. You should write int number!");
    } else {
        var i = parseFloat(str);
        if (i >= -5 && i <= 3) {
            text_input.value = i;
            if (checkSetR) {
                return true;
            } else {
                alert("Please, choose R by button");
            }

        } else {
            alert(str + " isn't in range(-5:3)!");
        }
    }
    return false;
}

function setR(int) {    //Установка значения R получаемого от кнопок. Скрипт запускается при нажатии на кнопку
    document.getElementById("vR").setAttribute("value", int);
    var rNames = document.getElementsByName("rChoose");
    for (let i = 0; i < rNames.length; i++) {
        rNames[i].setAttribute("class", "inputNe");
    }
    rNames[(int*2)-2].setAttribute("class", "inputOk");
    checkSetR = true;
}

const submit = function (e) {
    //Валидация текста
    if (!checkText()) return e.preventDefault();

    //Валидация X и его получения если верен
    let xVal;
    let ansX = document.getElementsByName("answerX");
    for (let i = 0; i < ansX.length; i++) {
        if (ansX[i].checked) {
            xVal = ansX[i].value
            break;
        }
    }

    //Формирование AJUX запроса серверу
    var yVal = document.getElementById("text_input").value;
    var rVal = document.getElementById("vR").value;

    let xhr = new XMLHttpRequest();

    let url = new URL('/web-lab-1/serverScript/handlerS.php', servDom);

    url.searchParams.append('answerX', xVal);
    url.searchParams.append('answerY', yVal);
    url.searchParams.append('answerR', rVal);

    xhr.open('GET', url);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("result").innerHTML = xhr.responseText
        }
    }

    xhr.send()
}

//Добавление скрипта для валидации перед отправкой
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('submitButton').addEventListener('click', submit);
});