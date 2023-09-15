
 <!-- Required vendors -->
 <script src="{{ asset('admin/vendor/global/global.min.js') }}"></script>
 <script src="{{ asset('admin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
 <script src="{{ asset('admin/vendor/chart.js/Chart.bundle.min.js') }}"></script>
 <script src="{{ asset('admin/vendor/select2/js/select2.full.min.js') }}"></script>
 <script src="{{ asset('admin/js/plugins-init/select2-init.js') }}"></script>


 <!-- Chart piety plugin files -->
 <script src="{{ asset('admin/vendor/peity/jquery.peity.min.js') }}"></script>

 <!-- Apex Chart -->
 <script src="{{ asset('admin/vendor/apexchart/apexchart.js') }}"></script>

 <!-- Dashboard 1 -->
 <script src="{{ asset('admin/js/dashboard/dashboard-1.js') }}"></script>

 <script src="{{ asset('admin/vendor/owl-carousel/owl.carousel.js') }}"></script>
 <script src="{{ asset('admin/js/custom.js') }}"></script>
 <script src="{{ asset('admin/js/deznav-init.js') }}"></script>

  <!-- Datatable -->
  <script src="{{ asset('admin/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('admin/js/plugins-init/datatables.init.js') }}"></script>


  <!-- Toastr -->
  <script src="{{ asset('admin/vendor/toastr/js/toastr.min.js') }}"></script>

  <script src="{{ asset('admin/js/sweetalert2@11.js') }}"></script>

  <!-- All init script -->
  <script src="{{ asset('admin/js/plugins-init/toastr-init.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">


     @if(Session::has('message'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.success("{{ session('message') }}");
    @endif

    @if(Session::has('error'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.error("{{ session('error') }}");
    @endif



</script>
@stack('js')
