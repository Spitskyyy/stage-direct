    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('table-search');
        const tableRows = document.querySelectorAll('#data-table tbody tr');

        searchInput.addEventListener('input', () => {
            const query = searchInput.value.toLowerCase();
            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(query) ? '' : 'none';
            });
        });
    });
