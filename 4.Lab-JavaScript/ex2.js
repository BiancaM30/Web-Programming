function validateName() {
    var name = document.getElementById('name');
    var letters = /^[A-Za-z]+$/;
    if (name.value === '' || !name.value.match(letters)) {
        name.style = "border: 1px solid red";
        return 'Numele nu este completat corect!\n';
    } else {
        name.style.border = "1px solid black";
        return '';
    }
}

function validateBirthday() {
    var birthday = document.getElementById('birthday');
    var bdayConverted = new Date(birthday.value);
    var todaysDate = new Date();
    if (birthday.value === '' || bdayConverted > todaysDate) {
        birthday.style.border = "1px solid red";
        return 'Data de nastere nu este completata corect!\n';
    } else {
        birthday.style.border = "1px solid black";
        return '';
    }
}

function validateAge(age) {
    var age = document.getElementById('age');
    var birthday = new Date(document.getElementById('birthday').value)
    function getAge(birthYear){
        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
        calculatedAge = currentYear - birthYear;
        return calculatedAge;
    }
    calculatedAge = getAge(birthday.getFullYear());
    if (age.value === '' || age.value < 1 || age.value > 150 || age.value != calculatedAge) {
        age.style.border = "1px solid red";
        return 'Varsta nu este completata corect!\n';
    } else {
        age.style.border = "1px solid black";
        return '';
    }
}

function validateEmail(email) {
    var letters = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
    if (email.value === '' || !email.value.match(letters)) {
        email.style.border = "1px solid red";
        return 'Emailul nu este completat corect!\n';
    } else {
        email.style.border = "1px solid black";
        return '';
    }
}



function validateForm() {
    var result =
        validateName() +
        validateBirthday() +
        validateAge() +
        validateEmail(email);

    if (result === '') {
        alert('Datele sunt completate corect.')
    } else {
        alert(result);
    }
}