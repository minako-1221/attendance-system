window.buttonState = JSON.parse(document.getElementById('button-states').textContent);

document.addEventListener('DOMContentLoaded', function () {
    /**
     * ボタンの状態を更新する関数
     * @param {string} buttonClass - ボタンのクラス名
     * @param {boolean} disabled - ボタンを無効化するかどうか
     */
    function updateButtonState(buttonClass, state) {
        const button = document.querySelector(buttonClass);
        if (button) {
            button.style.color = state ? 'gray' : 'black';
            button.disabled = state;
        }
    }

    /**
     * ボタンの状態をビューに反映する関数
     */
    function renderButtonStates() {
        // ボタンの初期化（すべて無効化）
        updateButtonState('.button__clock-in', true);
        updateButtonState('.button__clock-out', true);
        updateButtonState('.button__break-start', true);
        updateButtonState('.button__break-end', true);

        // サーバーから渡された状態に基づいてボタンを有効化
        if (window.buttonState.clock_out) {
            // すべて無効化（勤務終了後）
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

    /**
     * ダブルクリック防止用の関数
     * @param {HTMLElement} button - クリックされたボタン
     */
    function preventDoubleClick(button) {
        button.disabled = true;
        setTimeout(() => {
            button.disabled = false;
        }, 1000);
    }

    // ボタンの状態をビューに反映
    renderButtonStates();
});
