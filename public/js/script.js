// Funkce pro potvrzení akce
function confirmAction(message) {
    return confirm(message);
}

// Po načtení dokumentu
document.addEventListener('DOMContentLoaded', function() {
    // Automatické odesílání formuláře při změně filtru
    const filterSelects = document.querySelectorAll('.filter-container select');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
    
    // Zvýraznění řádku při najetí myší
    const tableRows = document.querySelectorAll('.products-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f0f0f0';
        });
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
});
