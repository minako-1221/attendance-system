document.addEventListener('DOMContentLoaded', function () {
    const dateElement = document.getElementById('current-date');
    let currentDate = new Date(dateElement.dataset.date);

    const cache = {};

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
    function updateDate() {

        const year = currentDate.getFullYear();
        const month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
        const day = ('0' + currentDate.getDate()).slice(-2);
        const formattedDate = `${year}-${month}-${day}`;

        dateElement.textContent = formattedDate;

        const newUrl = `/attendance?date=${formattedDate}`;
        window.history.pushState({ path: newUrl }, '', newUrl);

        // キャッシュに存在するか確認
        if (cache[formattedDate]) {
            document.querySelector('.attendance-table').innerHTML = cache[formattedDate];
        } else {
            document.querySelector('.attendance-table').innerHTML = '<p>Loading...</p>';

            // fetchリクエストに日付を追加
            fetch(newUrl, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                cache[formattedDate] = html;
                document.querySelector('.attendance-table').innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                document.querySelector('.attendance-table').innerHTML = '<p>Error loading data.</p>';
            });
        }
    };
});
