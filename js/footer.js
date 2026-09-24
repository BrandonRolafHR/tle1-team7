window.addEventListener('load', init);

let homeIcon;
let calendarIcon;
let addIcon;
let friendIcon;
let profileIcon;


function init() {
    homeIcon = document.querySelector('.home');
    calendarIcon = document.querySelector('.calender');
    addIcon = document.querySelector('.add');
    friendIcon = document.querySelector('.friends');
    profileIcon = document.querySelector('.profile');

    homeIcon.addEventListener('click', () => {
        window.location.href = '/home.php';
    });
    calendarIcon.addEventListener('click', () => {
        window.location.href = '/calendar.php';
    });
    addIcon.addEventListener('click', () => {
        window.location.href = '/create/create.php';
    });
    friendIcon.addEventListener('click', () => {
        window.location.href = '/friendslist.php';
    });
    profileIcon.addEventListener('click', () => {
        window.location.href = '/profile/profile.php';
    });
}
