function addField(type) {
    let div = document.createElement("div");
    div.innerHTML = `<input type="text" name="${type}[]" required>`;
    document.getElementById(type).appendChild(div);
}