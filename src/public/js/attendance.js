document.addEventListener('DOMContentLoaded', function () {
    const dateElement = document.getElementById('current-date');
    let currentDate = new Date(dateElement.dataset.date);

    function highlightCurrentPage(page) {
        document.querySelectorAll('.pagination a').forEach(link => {
            const url = new URL(link.href);
            const linkPage = url.searchParams.get('page');
            link.classList.toggle('active', linkPage == page);
            link.classList.toggle('page', linkPage != page);
        });
    }

    function getCurrentPage() {
        return new URLSearchParams(window.location.search).get('page') || 1;
    }

    function formatDate(date) {
        const year = date.getFullYear();
        const month = ('0' + (date.getMonth() + 1)).slice(-2);
        const day = ('0' + date.getDate()).slice(-2);
        return `${year}-${month}-${day}`;
    }

    function updateDate(pushState = true) {
        const formattedDate = formatDate(currentDate);
        dateElement.textContent = formattedDate;
        const currentPage = getCurrentPage();
        const newUrl = `/attendance?date=${formattedDate}&page=${currentPage}`;

        if (pushState) {
            window.history.pushState({ path: newUrl }, '', newUrl);
        }

        fetch(newUrl, { method: 'GET', headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const attendanceTable = doc.querySelector('.attendance-table');
                const pagination = doc.querySelector('.pagination');

                if (attendanceTable) {
                    document.querySelector('.attendance-table').innerHTML = attendanceTable.innerHTML;
                } else {
                    console.warn('Attendance table not found in response.');
                }
                if (pagination) {
                    document.querySelector('.pagination').innerHTML = pagination.innerHTML;
                } else {
                    console.warn('Pagination not found in response.');
                }

                setupPaginationLinks();
                highlightCurrentPage(currentPage);
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    function setupPaginationLinks() {
        document.querySelectorAll('.pagination a').forEach(link => {
            link.addEventListener('click', event => {
                event.preventDefault();
                const page = new URL(link.href).searchParams.get('page');
                if (page) updatePage(page);
            });
        });
    }

    function updatePage(page) {
        const formattedDate = formatDate(currentDate);
        const newUrl = `/attendance?date=${formattedDate}&page=${page}`;
        window.history.pushState({ path: newUrl }, '', newUrl);

        fetch(newUrl, { method: 'GET', headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.text())
            .then(html => {
                console.log('Response HTML:', html);
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const attendanceTable = doc.querySelector('.attendance-table');
                const pagination = doc.querySelector('.pagination');

                if (attendanceTable) {
                    document.querySelector('.attendance-table').innerHTML = attendanceTable.innerHTML;
                } else {
                    console.warn('Attendance table not found in response.');
                }
                if (pagination) {
                    document.querySelector('.pagination').innerHTML = pagination.innerHTML;
                } else {
                    console.warn('Pagination not found in response.');
                }

                setupPaginationLinks();
                highlightCurrentPage(page);
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    document.getElementById('prev-date').addEventListener('click', () => {
        currentDate.setDate(currentDate.getDate() - 1);
        updateDate();
    });

    document.getElementById('next-date').addEventListener('click', () => {
        currentDate.setDate(currentDate.getDate() + 1);
        updateDate();
    });

    setupPaginationLinks();
    highlightCurrentPage(getCurrentPage());
    updateDate(false);
});
