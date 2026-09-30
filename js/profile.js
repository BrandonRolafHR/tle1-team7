window.addEventListener('load', init);

let milestoneItem;


function init() {
    milestoneItem = document.querySelectorAll('.milestone-item').forEach(item => {
        item.addEventListener('click', () => {
            const id = item.dataset.id;
            console.log("Geklikte milestone ID:", id);
            window.location.href = `/2026_2027/tle_t7/profile/milestone.php?post_id=${id}`;
        });
    });
}
