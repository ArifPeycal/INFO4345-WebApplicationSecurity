const form = document.getElementById('reservationForm');
const nameInput = document.getElementById('name');
const matricInput = document.getElementById('matric');
const phoneInput = document.getElementById('phone');
const emailInput = document.getElementById('email');
const addressInput = document.getElementById('address');

const phoneRegex = /^\d{3}-\d{3}-\d{4}$/; // Updated regex to match XXX-XXXX format
const nameRegex = /^[a-zA-Z\s]+$/;
const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}\.com$/;
const addressRegex = /^[a-zA-Z0-9\s]+$/;
const matricRegex = /^\d{7}$/;

form.addEventListener('submit', function(event) {
    if (!nameRegex.test(nameInput.value)) {
        event.preventDefault();
        alert('Name can only contain alphabets and spaces.');
    }
    if (!phoneRegex.test(phoneInput.value)) {
        event.preventDefault();
        alert('Phone number must be in the format XXX-XXXX.');
    }
    if (!emailRegex.test(emailInput.value)) {
        event.preventDefault();
        alert('Email must be in the format');
    }
    if (!addressRegex.test(addressInput.value)) {
        event.preventDefault();
        alert('Address can only contain alphabets, numbers and spaces.');
    }
    if (!matricRegex.test(matricInput.value)) {
        event.preventDefault();
        alert('Matric number must be 7 digits long.');
    }
});