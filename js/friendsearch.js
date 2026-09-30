const searchInput = document.getElementById("friend-search");
const searchDropdown = document.getElementById("search-dropdown");
const searchButton = document.getElementById("search-button");

searchInput.addEventListener("input", function () {

    const search = searchInput.value.trim();

    if (search === "") {
        searchDropdown.innerHTML = "";
        searchDropdown.style.display = "none";
        return;
    }

    fetch("search_users.php?q=" + encodeURIComponent(search))
        .then(response => response.json())
        .then(users => {

            searchDropdown.innerHTML = "";

            if (users.length === 0) {
                searchDropdown.style.display = "none";
                return;
            }

            users.forEach(user => {

                const userElement = document.createElement("div");

                userElement.classList.add("search-result");

                userElement.innerHTML = `
                    <span>${user.username}</span>

                    <button 
                        class="add-friend-button"
                        data-user-id="${user.id}">
                        Add
                    </button>
                `;

                searchDropdown.appendChild(userElement);
            });

            searchDropdown.style.display = "block";
        })
        .catch(error => {
            console.error("Search error:", error);
        });
});


// Add friend
searchDropdown.addEventListener("click", function (event) {

    if (!event.target.classList.contains("add-friend-button")) {
        return;
    }

    const friendId = event.target.dataset.userId;

    fetch("friendslist.php", {
        method: "POST",

        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },

        body: "action=add&friend_id=" + encodeURIComponent(friendId)
    })
        .then(response => response.json())
        .then(data => {

            if (data.success) {

                location.reload();

            }

        })
        .catch(error => {
            console.error("Add friend error:", error);
        });

});


searchButton.addEventListener("click", function () {

    const search = searchInput.value.trim();

    if (search === "") {
        return;
    }

    console.log("Searching for:", search);

});

document.addEventListener("click", function (event) {

    const moreOptions = event.target.closest(".more-options");

    if (!moreOptions) {
        return;
    }

    const friendId = moreOptions.dataset.userId;

    // Verwijder eventueel een bestaand menu
    const existingMenu = document.querySelector(".friend-options-menu");

    if (existingMenu) {
        existingMenu.remove();
    }

    // Maak menu
    const menu = document.createElement("div");

    menu.classList.add("friend-options-menu");

    menu.innerHTML = `
        <button class="delete-friend-button">
            Delete friend
        </button>
    `;

    // Plaats menu naast de 3 puntjes
    moreOptions.parentElement.appendChild(menu);

    // Delete knop
    menu.querySelector(".delete-friend-button").addEventListener("click", function () {

        fetch("friendslist.php", {
            method: "POST",

            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },

            body: "action=delete&friend_id=" + encodeURIComponent(friendId)
        })

            .then(response => response.json())

            .then(data => {

                if (data.success) {
                    const friendElement = moreOptions.closest(".friend");

                    friendElement.remove();

                } else {

                    console.error("Could not delete friend");

                }

            })

            .catch(error => {
                console.error("Delete friend error:", error);
            });

    });

});