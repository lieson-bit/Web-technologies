document.addEventListener("DOMContentLoaded", () => {
    console.log("Page loaded successfully!"); // Browser event: load

    // 1️⃣ Show Author Info Popup
    const showAuthorInfo = () => alert("Автор: Лисон Мвале\nГруппа: 4236");

    // 2️⃣ Clock Function: Shows HH:MM, shows seconds for 10 sec on dblclick
    let clockElement = document.getElementsByName("clock-display")[0];
    let clockInterval, showSecondsInterval;

    const updateClock = (showSeconds = false) => {
        let now = new Date();
        let time = now.toLocaleTimeString("ru-RU", { hour: "2-digit", minute: "2-digit", second: showSeconds ? "2-digit" : undefined });
        if (clockElement) clockElement.innerText = time;
    };

    const showSecondsForLimitedTime = () => {
        clearInterval(clockInterval);
        updateClock(true);
        showSecondsInterval = setInterval(() => updateClock(true), 1000);
        setTimeout(() => {
            clearInterval(showSecondsInterval);
            updateClock(false);
            clockInterval = setInterval(updateClock, 1000);
        }, 10000);
    };

    clockInterval = setInterval(updateClock, 1000);
    document.getElementsByName("clock-button")[0]?.addEventListener("dblclick", showSecondsForLimitedTime);

    // 3️⃣ Add a row to the table with user input
    function addRow() {
        const industryInput = document.getElementsByName("industry")[0];
        const robotTypeInput = document.getElementsByName("robot-type")[0];
        const applicationsInput = document.getElementsByName("applications")[0];

        const tbodyRef = document.getElementsByTagName("tbody")[0];
        const newRow = tbodyRef.insertRow();

        // Add the "Added" class to dynamically added rows
        newRow.classList.add("Added");

        // Check if inputs are empty, if so add empty cells
        const industryValue = industryInput.value || " ";
        const robotTypeValue = robotTypeInput.value || " ";
        const applicationsValue = applicationsInput.value || " ";

        // Add data to the row
        const industryCell = newRow.insertCell(0);
        industryCell.innerText = industryValue;

        const robotTypeCell = newRow.insertCell(1);
        robotTypeCell.innerText = robotTypeValue;

        const applicationsCell = newRow.insertCell(2);
        applicationsCell.innerText = applicationsValue;

        // Clear the input fields after adding the row
        industryInput.value = "";
        robotTypeInput.value = "";
        applicationsInput.value = "";
    }

    // Function to erase the last dynamically added row
    function eraseRow() {
        const rows = document.getElementsByClassName("Added");
        if (rows.length > 0) {
            // Remove the last row added
            rows[rows.length - 1].remove();
        } else {
            console.log("No rows to delete.");
        }
    }

    // 5️⃣ Change color of the 2nd paragraph in "history"
    const changeColor = () => {
        let p = document.getElementById("history")?.getElementsByTagName("p")[1];
        if (p) p.style.backgroundColor = "#ffcccb";
    };

    // 6️⃣ Change size of the 2nd paragraph in "history"
    const changeSize = () => {
        let p = document.getElementById("history")?.getElementsByTagName("p")[1];
        if (p) p.style.fontSize = "1.2em";
    };

    // 7️⃣ Function with multiple parameters
    const styleElement = (element, color, size, border) => {
        if (!element) return;
        element.style.color = color;
        element.style.fontSize = size;
        element.style.border = border;
    };

    // Apply the function
    let heading = document.querySelector("h2");
    styleElement(heading, "blue", "22px", "2px solid black");

    // 8️⃣ List: Add and Remove Items
    const addListItem = () => {
        let ul = document.getElementById("dynamic-list");
        let newItem = document.createElement("li");
        newItem.innerText = `Элемент ${ul.children.length + 1}`;
        newItem.onclick = () => newItem.remove();
        ul.appendChild(newItem);
    };

    document.getElementsByName("add-item")[0]?.addEventListener("click", addListItem);

    // 9️⃣ Browser Events
    window.addEventListener("scroll", () => console.log("Scrolling..."));
    window.addEventListener("mousemove", (e) => console.log(`Mouse moved: (${e.clientX}, ${e.clientY})`));

    // Assign events
    document.getElementsByName("author-info")[0]?.addEventListener("dblclick", showAuthorInfo);
    document.getElementsByName("add-row")[0]?.addEventListener("dblclick", addEmptyRow);
    document.getElementsByName("change-color-btn")[0]?.addEventListener("dblclick", changeColor);
    document.getElementsByName("change-size-btn")[0]?.addEventListener("dblclick", changeSize);

    // Assign double-click events to buttons using getElementsByName
    const addButton = document.getElementsByName("add-row-btn")[0];
    if (addButton) {
        addButton.addEventListener("dblclick", addRow);
    }

    const eraseButton = document.getElementsByName("erase-row-btn")[0];
    if (eraseButton) {
        eraseButton.addEventListener("dblclick", eraseRow);
    }
});
