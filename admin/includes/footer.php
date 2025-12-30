        </div>
    </div>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }
        
        // Initialize DataTables
        $(document).ready(function() {
            if ($.fn.DataTable) {
                $('.datatable').each(function() {
                    if (!$(this).hasClass('dataTable')) {
                        $(this).DataTable({
                            language: {
                                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/bn.json'
                            },
                            pageLength: 10,
                            ordering: true,
                            searching: true,
                            info: true,
                            autoWidth: false,
                            responsive: true
                        });
                    }
                });
            }
        });
        
        // Auto-dismiss alerts
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
</body>
</html>
