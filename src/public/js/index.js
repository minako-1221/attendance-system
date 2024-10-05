document.addEventListener('DOMContentLoaded', function() {
    // ボタンの状態を更新する関数
    function updateButtonState(buttonClass, state) {
        const button = document.querySelector(buttonClass);
        if (state) {
            button.style.color = 'gray';
            button.disabled = true;
        } else {
            button.style.color = 'black';
            button.disabled = false;
        }
    }

    // 初期状態のボタンの設定
    function initializeButtonStates() {
        // 勤務終了が押されている場合は全てのボタンを無効化
        if (window.buttonState.clock_out) {
            updateButtonState('.button__clock-in', true);
            updateButtonState('.button__clock-out', true);
            updateButtonState('.button__break-start', true);
            updateButtonState('.button__break-end', true);
        }
        // 勤務開始が押されている場合は勤務終了と休憩開始を有効にする
        else if (window.buttonState.clock_in) {
            updateButtonState('.button__clock-in', true);
            updateButtonState('.button__clock-out', false);
            updateButtonState('.button__break-start', false);
            updateButtonState('.button__break-end', true);  // 休憩終了は無効
        }
        // 休憩開始が押されている場合は休憩終了を有効にする
        else if (window.buttonState.break_start) {
            updateButtonState('.button__clock-in', true);
            updateButtonState('.button__clock-out', true);  // 勤務終了は無効
            updateButtonState('.button__break-start', true);  // 休憩開始は無効
            updateButtonState('.button__break-end', false);   // 休憩終了は有効
        }
        // 休憩終了が押されている場合は勤務終了と休憩開始を有効にする
        else if (window.buttonState.break_end) {
            updateButtonState('.button__clock-in', true);
            updateButtonState('.button__clock-out', false);  // 勤務終了は有効
            updateButtonState('.button__break-start', false);  // 休憩開始は有効
            updateButtonState('.button__break-end', true);  // 休憩終了は無効
        }
        // 全てのボタンがデフォルト状態 (出勤前)
        else {
            updateButtonState('.button__clock-in', false);  // 勤務開始のみ有効
            updateButtonState('.button__clock-out', true);
            updateButtonState('.button__break-start', true);
            updateButtonState('.button__break-end', true);
        }
    }

    // ボタン状態を初期化
    initializeButtonStates();
});
