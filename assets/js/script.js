function addField(type) {
    let div = document.createElement("div");
    div.className = "item";
    div.innerHTML = `<input type="text" name="${type}[]" required><button type="button" class="remove-btn">Remove</button>`;
    const button = div.querySelector(".remove-btn");
    button.addEventListener("click", () => div.remove());
    document.getElementById(type).appendChild(div);
}