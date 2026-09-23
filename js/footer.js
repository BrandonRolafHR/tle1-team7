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
        window.location.href = '/tle1-team7/';
    });
    calendarIcon.addEventListener('click', () => {
        window.location.href = '/tle1-team7/';
    });
    addIcon.addEventListener('click', () => {
        window.location.href = '/tle1-team7/';
    });
    friendIcon.addEventListener('click', () => {
        window.location.href = '/tle1-team7/';
    });
    profileIcon.addEventListener('click', () => {
        window.location.href = '/tle1-team7/profile/profile.php';
    });
}
