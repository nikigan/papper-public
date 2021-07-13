document.addEventListener('DOMContentLoaded', function () {
    const tableButtons = document.querySelectorAll('.table-sort-btn');

    tableButtons.forEach(button => {
        const url = new URL(window.location);
        const params = url.searchParams;
        const table = button.closest("table");
        const tableName = table.dataset['table'] ? table.dataset['table'] + "_" : "";
        const querySortProp = params.get(`${tableName}sort_prop`);
        const querySortOrder = params.get(`${tableName}sort_order`);
        const prop = button.dataset['sortProp'];
        if (prop) {
            params.set(`${tableName}sort_prop`, prop);
            params.set(`${tableName}sort_order`, 'desc');

            if (prop === querySortProp) {
                const span = document.createElement('span');
                if (querySortOrder === 'asc') {
                    span.innerHTML = `<i class="fas fa-sort-up"></i>`;
                    params.set(`${tableName}sort_order`, 'desc')
                }
                else if (querySortOrder === 'desc') {
                    span.innerHTML = `<i class="fas fa-sort-down"></i>`;
                    params.set(`${tableName}sort_order`, 'asc')
                }

                button.parentNode.insertBefore(span, button);
            }
            url.search = params.toString();
            button.href = url.toString();
        }
    });
});
