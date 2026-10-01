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

                event.target.textContent = "Added";
                event.target.disabled = true;
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


// Friend options menu (dots) + delete friend
document.addEventListener("click", function (event) {
    const moreOptions = event.target.closest(".more-options");
    const deleteButton = event.target.closest(".delete-friend-button");

    // Open/close menu when clicking the dots
    if (moreOptions) {
        const actions = moreOptions.closest(".friend-actions");
        let menu = actions.querySelector(".friend-options-menu");

        // create the menu the first time it's needed
        if (!menu) {
            menu = document.createElement("div");
            menu.classList.add("friend-options-menu");
            menu.innerHTML = `
                <button class="delete-friend-button">Delete friend</button>
            `;
            actions.appendChild(menu);
        }

        document.querySelectorAll(".friend-options-menu.open").forEach(m => {
            if (m !== menu) m.classList.remove("open");
        });

        menu.classList.toggle("open");
        return;
    }

    // Delete friend
    if (deleteButton) {
        const actions = deleteButton.closest(".friend-actions");
        const friendId = actions.querySelector(".more-options").dataset.userId;

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
                    deleteButton.closest(".friend").remove();
                } else {
                    console.error("Could not delete friend");
                }
            })
            .catch(error => {
                console.error("Delete friend error:", error);
            });

        return;
    }

    // Click anywhere else: close all menus
    document.querySelectorAll(".friend-options-menu.open").forEach(m => {
        m.classList.remove("open");
    });
});