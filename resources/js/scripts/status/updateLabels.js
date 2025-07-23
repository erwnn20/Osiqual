const nameInput = document.getElementById('name');
const colorInput = document.getElementById('color');

function updateLabels() {
    document.querySelectorAll('.label').forEach(label => {
        label.innerText = nameInput.value.trim() || 'label'
        label.style.background = `${colorInput.value}26`;
        label.style.color = `${colorInput.value}`;
    })
}

document.addEventListener('DOMContentLoaded', updateLabels);
nameInput.addEventListener('input', updateLabels);
colorInput.addEventListener('input', updateLabels);
