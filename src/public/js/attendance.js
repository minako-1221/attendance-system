document.addEventListener('DOMContentLoaded', function () {
    const dateElement = document.getElementById('current-date');
    let currentDate = new Date(dateElement.dataset.date);

    // 現在のページ番号を取得する関数
    function getCurrentPage() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('page') || 1;  // デフォルトは1ページ目
    }

    // 現在の日付を取得する関数
    function getCurrentDate() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('date') || formatDate(currentDate); // デフォルトは今日の日付
    }

    // 日付をフォーマットする関数
    function formatDate(date) {
        const year = date.getFullYear();
        const month = ('0' + (date.getMonth() + 1)).slice(-2);
        const day = ('0' + date.getDate()).slice(-2);
        return `${year}-${month}-${day}`;
    }

    // 前日ボタン
    document.getElementById('prev-date').addEventListener('click', function () {
        currentDate.setDate(currentDate.getDate() - 1);
        updateDate();
    });

    // 翌日ボタン
    document.getElementById('next-date').addEventListener('click', function () {
        currentDate.setDate(currentDate.getDate() + 1);
        updateDate();
    });

    // 日付を更新する関数
    function updateDate(pushState = true) {  // pushStateがtrueならURLを更新
        const formattedDate = formatDate(currentDate);

        // 日付をHTMLに反映
        dateElement.textContent = formattedDate;

        // ページ番号をクエリパラメータに含める
        const currentPage = getCurrentPage();  // 現在のページ番号
        const newUrl = `/attendance?date=${formattedDate}&page=${currentPage}`;  // 日付とページをURLに含める

        if (pushState) {
            window.history.pushState({ path: newUrl }, '', newUrl);
        }

        // Ajaxでデータを取得して更新
        fetch(newUrl, {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            document.querySelector('.attendance-table').innerHTML = html;
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
    }

    // 初回読み込み時にURLから日付を取得し、反映
    const initialDate = getCurrentDate();
    const [year, month, day] = initialDate.split('-');  // 日付文字列を分割
    currentDate = new Date(year, month - 1, day);  // 月は0始まり
    updateDate(false);  // ページ読み込み時にpushStateは不要
});
