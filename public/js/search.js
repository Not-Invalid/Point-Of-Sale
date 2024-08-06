document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');

    const filterTable = (tableBodyId, columnIndices) => {
        const tableBody = document.getElementById(tableBodyId);

        searchInput.addEventListener('input', function() {
            const searchText = searchInput.value.toLowerCase();

            Array.from(tableBody.children).forEach(row => {
                const matches = columnIndices.some(index => 
                    row.children[index].textContent.toLowerCase().includes(searchText)
                );
                row.style.display = matches ? '' : 'none';
            });
        });
    };

    filterTable('user-table-body', 1);     
    filterTable('product-table-body', [1, 2]);  
    filterTable('brand-table-body', [1, 2]);  
    filterTable('category-table-body', [1, 2]); 
    filterTable('transactions-table-body', [1,2]); 
    filterTable('stok-management-table-body', [1]); 
});