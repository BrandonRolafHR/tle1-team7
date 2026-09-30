window.addEventListener('load', init);

let homeIcon;
let calendarIcon;
let addIcon;
let friendIcon;
let profileIcon;


function init() {
    homeIcon = document.querySelector('.home');
    calendarIcon = document.querySelector('.calendar');
    addIcon = document.querySelector('.add');
    friendIcon = document.querySelector('.friends');
    profileIcon = document.querySelector('.profile');

    homeIcon.addEventListener('click', () => {
        window.location.href = '/2026_2027/tle_t7/home.php/';
    });
    calendarIcon.addEventListener('click', () => {
        window.location.href = '/2026_2027/tle_t7/calendar.php/';
    });
    addIcon.addEventListener('click', () => {
        window.location.href = '/2026_2027/tle_t7/create/create.php';
    });
    friendIcon.addEventListener('click', () => {
        window.location.href = '/2026_2027/tle_t7/friendslist.php/';
    });
    profileIcon.addEventListener('click', () => {
        window.location.href = '/2026_2027/tle_t7/profile/profile.php';
    });
}
