function validateName() {
    var letters = /^[A-Za-z]+$/;
    if ($("#name").val() === '' || !$("#name").val().match(letters)) {
        $("#name").css("border", "1px solid red");
        return 'Numele nu este completat corect!\n';
    } else {
        $("#name").css("border", "1px solid black");
        return '';
    }
}

function validateBirthday() {
    var bdayConverted = new Date($("#birthday").val());
    var todaysDate = new Date();
    if ($("#birthday").val() === '' || bdayConverted > todaysDate) {
        $("#birthday").css("border", "1px solid red");
        return 'Data de nastere nu este completata corect!\n';
    } else {
        $("#birthday").css("border", "1px solid black");
        return '';
    }
}

function validateAge(age) {
    var birthday = new Date($("#birthday").val())
    function getAge(birthYear) {
        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
        calculatedAge = currentYear - birthYear;
        return calculatedAge;
    }
    calculatedAge = getAge(birthday.getFullYear());
    if ($("#age").val() === '' || $("#age").val() < 1 || $("#age").val() > 150 || $("#age").val() != calculatedAge) {
        $("#age").css("border", "1px solid red");
        return 'Varsta nu este completata corect!\n';
    } else {
        $("#age").css("border", "1px solid black");
        return '';
    }
}

function validateEmail() {
    var letters = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
    if ($("#email").val() === '' || !$("#email").val().match(letters)) {
        $("#email").css("border", "1px solid red");
        return 'Emailul nu este completat corect!\n';
    } else {
        $("#email").css("border", "1px solid black");
        return '';
    }
}

$(document).ready(function () {
    $("#mySubmit").click(function () {
        var result = validateName() + validateBirthday() + validateAge() + validateEmail();
        if (result === '') {
            alert('Datele sunt completate corect.')
        } else {
            alert(result);
        }
    });
});
