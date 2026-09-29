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

                userElement.textContent = user.username;

                userElement.addEventListener("click", function () {
                    searchInput.value = user.username;

                    searchDropdown.innerHTML = "";
                    searchDropdown.style.display = "none";
                });

                searchDropdown.appendChild(userElement);
            });

            searchDropdown.style.display = "block";
        })
        .catch(error => {
            console.error("Search error:", error);
        });
});

searchButton.addEventListener("click", function () {

    const search = searchInput.value.trim();

    if (search === "") {
        return;
    }

    console.log("Searching for:", search);

});