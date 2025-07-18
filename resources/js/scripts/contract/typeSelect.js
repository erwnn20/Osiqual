const typeSelect = document.getElementById('type');
const startDateInput = document.getElementById('start');
const endDateInput = document.getElementById('end');
const endDatesRequired = document.getElementById('end-required');

function updateForType() {
    const selectedOption = typeSelect.options[typeSelect.selectedIndex];
    const monthly = selectedOption.dataset.monthly === undefined
        ? selectedOption.dataset.monthly : !!selectedOption.dataset.monthly;

    const start = new Date(startDateInput.value);
    const end = new Date(endDateInput.value);

    const type = monthly ? 'month' : 'date';
    const disabled = monthly !== undefined && !monthly;
    const required = monthly !== undefined && monthly;

    startDateInput.type = type;
    startDateInput.value = formatDate(start, type);

    endDateInput.type = type;
    endDateInput.value = formatDate(end, type);
    endDateInput.disabled = disabled;
    endDateInput.required = required;
    if (required)
        endDatesRequired.classList.remove('hidden');
    else
        endDatesRequired.classList.add('hidden');
}

function formatDate(date, type) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');

    if (type === 'month') return `${year}-${month}`; // YYYY-MM
    else if (type === 'date') return `${year}-${month}-${day}`; // YYYY-MM-DD

    return `${year}-${month}-${day}`; // YYYY-MM-DD
}

document.addEventListener('DOMContentLoaded', () => updateForType());
typeSelect.addEventListener('change', () => updateForType());
