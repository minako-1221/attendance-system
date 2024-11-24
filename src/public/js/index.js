window.buttonState = JSON.parse(document.getElementById('button-states').textContent);

document.addEventListener('DOMContentLoaded', function () {
    function updateButtonState(buttonClass, state) {
        const button = document.querySelector(buttonClass);
        if (button) {
            button.style.color = state ? 'gray' : 'black';
            button.disabled = state;
        }
    }

    function renderButtonStates() {
        updateButtonState('.button__clock-in', true);
        updateButtonState('.button__clock-out', true);
        updateButtonState('.button__break-start', true);
        updateButtonState('.button__break-end', true);

        if (window.buttonState.clock_out) {
            updateButtonState('.button__clock-in', true);
            updateButtonState('.button__clock-out', true);
            updateButtonState('.button__break-start', true);
            updateButtonState('.button__break-end', true);
        } else if (window.buttonState.break_end) {
            updateButtonState('.button__clock-out', false);
            updateButtonState('.button__break-start', false);
        } else if (window.buttonState.break_start) {
            updateButtonState('.button__break-end', false);
        } else if (window.buttonState.clock_in) {
            updateButtonState('.button__clock-out', false);
            updateButtonState('.button__break-start', false);
        } else {
            updateButtonState('.button__clock-in', false);
        }
    }

    function preventDoubleClick(button) {
        button.disabled = true;
        setTimeout(() => {
            button.disabled = false;
        }, 1000);
    }

    renderButtonStates();
});
