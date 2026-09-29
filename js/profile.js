window.addEventListener('load', init);

let milestoneItem;


function init() {
    milestoneItem = document.querySelectorAll('.milestone-item').forEach(item => {
        item.addEventListener('click', () => {
            const id = item.dataset.id;
            console.log("Geklikte milestone ID:", id);
            window.location.href = `/profile/milestone.php?id=${id}`;
        });
    });
}
