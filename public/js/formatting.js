document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('maintenance_cost_total');
    if (!input) return;

    input.addEventListener('input', function(e) {
        let numericValue = e.target.value.replace(/\D/g,'');
        e.target.value = numericValue 
            ? new Intl.NumberFormat('id-ID', { style: 'decimal', minimumFractionDigits: 0 }).format(numericValue) 
            : '';
    });

    input.closest('form').addEventListener('submit', function() {
        input.value = input.value.replace(/\D/g,'');
    });
});
