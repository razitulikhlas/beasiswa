</div>
<script src="{{ asset('mazer/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('mazer/dist/assets/js/bootstrap.bundle.min.js') }}"></script>

{{-- <script src="{{ asset('mazer/dist/assets/vendors/apexcharts/apexcharts.js') }}"></script> --}}
{{-- <script src="{{ asset('mazer/dist/assets/js/pages/dashboard.js') }}"></script> --}}

<script src="{{ asset('mazer/dist/assets/js/mazer.js') }}"></script>
</body>

</html>
<script>
    // $(document).ready(function() {
    //     $('#example1').DataTable({
    //         dom: 'Bfrtip',
    //         buttons: [
    //             'copy', 'csv', 'excel', 'pdf', 'print'
    //         ]
    //     });
    // });
 $(function() {
        $("#example1").DataTable();
    });
</script>
