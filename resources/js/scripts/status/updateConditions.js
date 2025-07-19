const radioNames = [
    ['duration', updateConditionDuration],
    ['start', updateConditionDefault],
    ['end', updateConditionDefault],
];

function updateConditionDefault(id) {
    const radioNoneCondition = document.querySelector(`input[name="${id}-condition"][value=""]`);
    const radioCondition = document.querySelector(`input[name="${id}-condition"]:checked`);
    const checkEqualCondition = document.querySelector(`input[name="${id}-condition-equal"]`);
    const conditionSelected = !!(radioCondition?.value || checkEqualCondition.checked);

    const inputValue = document.getElementById(`${id}-value`);
    const requiredIndicator = document.getElementById(`${inputValue.id}-required`);

    inputValue.disabled = !conditionSelected;

    if (requiredIndicator)
        requiredIndicator.classList.toggle('hidden', !conditionSelected);

    if (conditionSelected)
        radioCondition.checked = !!radioCondition.value;
    else
        radioNoneCondition.checked = true;

    return [inputValue, conditionSelected];
}

function updateConditionDuration(id) {
    const [inputValue, conditionSelected] = updateConditionDefault(id);

    const selectLogic = document.getElementById(`${id}-logic`);
    selectLogic.disabled = !conditionSelected;

    updateRange(inputValue)
}

document.addEventListener('DOMContentLoaded', () => {
    radioNames.forEach(([name, updateMethod]) => {
        updateMethod(name);

        const radios = document.querySelectorAll(`input[name="${name}-condition"]`);
        radios.forEach(radio => {
            radio.addEventListener('change', () => updateMethod(name));
        });
        const checkboxes = document.querySelectorAll(`input[name="${name}-condition-equal"]`);
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => updateMethod(name));
        });
    });
});
