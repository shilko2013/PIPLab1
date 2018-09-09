function checkX() {
    let number = parseFloat($("input[name='param-x']").val().replace(",","."));
    return number >= -5 && number <= 5;
}

function outputError() {
    $(".error-y").each((i,e) => {
        if (i == 0) {
            e.innerHTML = '<div style="color:red">Неверная координата <span class="param">X</span></div>';
        }
        else
            e.innerHTML = '<div style="color:red">Пожалуйста, повторите ввод</div>';
    });
    $('[name="param-x"]').val('');
}

function clickTable(event) {
    if (event.target.classList[0] == "param-button") {
        $(event.currentTarget).find(".param-button").each(function(){
            if (this.disabled)
                this.disabled = false;
        });
        event.target.setAttribute("disabled","true");
        $("[name='param-y']").val(event.target.innerText);
    }
}

$(() => {
    $("#form").submit(function submit(event) {
       if (!checkX()) {
           outputError();
           event.preventDefault();
       }
   });
});

function check(input) {
    input.value = input.value.replace(/[^-0-9\,\.]/g,'');
}

/*$(document).on('submit','#form', function submit(event) {
    let y = checkY(), x = checkX(), r = checkR();
    if (!x || !y || !r) {
        outputError(x,y,r);
        event.preventDefault();
    }
});*/