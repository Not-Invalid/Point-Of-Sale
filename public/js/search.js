document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');

    const filterTable = (tableBodyId, columnIndex) => {
        const tableBody = document.getElementById(tableBodyId);

        searchInput.addEventListener('input', function() {
            const searchText = searchInput.value.toLowerCase();

            Array.from(tableBody.children).forEach(row => {
                const cellText = row.children[columnIndex].textContent.toLowerCase();
                row.style.display = cellText.includes(searchText) ? '' : 'none';
            });
        });
    };

    filterTable('user-table-body', 1);     
    filterTable('product-table-body', 1);  
    filterTable('brand-table-body', 1);    
    filterTable('category-table-body', 1); 
    filterTable('transactions-table-body', 0); 
});