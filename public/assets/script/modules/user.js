export async function showUsers() {

    let table = document.querySelector("table");
    let tableBody = document.querySelector("tbody");
    let alert = document.querySelector(".alert");
    let response = await fetch("../handlers/fetch-users.php");
    let result = await response.json();
    console.log(result);
    console.log(result.length);

    if (result.length > 0) {
        console.log("we got some records !")
        result.forEach(user => {
            
            console.log(user)
            let tr = document.createElement("tr");
            tr.innerHTML = `
            
            <td>${user.id}</td>
            <td>${user.username}</td>
            <td>${user.email}</td>
            <td><a href="../router/router.php?page=profile-preview&id=${user.id}" class="view-profile-btn" ><span>View Profile</span></a></td>

            `;

            tableBody.appendChild(tr);

        });
    }
    else {
        table.style.display = 'none';
        alert.classList.add("active")
    }

}