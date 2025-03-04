@extends('template.dashboard')

@section('breadcrumbs')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Monitoring PO</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Data Monitoring PO</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
          {{-- Form untuk memasukkan parameter --}}
          <form id="fetchForm" class="mb-4">
              <div class="row">
                  <div class="col-md-3">
                      <label for="DOC_DATE_FROM">DOC DATE FROM:</label>
                      <input type="date" id="DOC_DATE_FROM" name="DOC_DATE_FROM" class="form-control" value="2024-01-01">
                  </div>
                  <div class="col-md-3">
                      <label for="DOC_DATE_TO">DOC DATE TO:</label>
                      <input type="date" id="DOC_DATE_TO" name="DOC_DATE_TO" class="form-control" value="2024-01-31">
                  </div>
                  <div class="col-md-3">
                      <label for="COMP_CODE">COMP CODE:</label>
                      <input type="text" id="COMP_CODE" name="COMP_CODE" class="form-control" value="1100">
                  </div>
                  <div class="col-md-3 d-flex align-items-end">
                      <button type="button" id="fetchDataBtn" class="btn btn-primary w-100">Get Data SAP</button>
                  </div>
              </div>
          </form>
          <div id="loading" class="text-center my-4" style="display: none;">
              <div class="spinner-border text-primary" role="status">
                  <span class="sr-only">Loading...</span>
              </div>
              <p>Fetching data, please wait...</p>
          </div>

            <div class="card-body">
              <table id="datatable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>PR Number</th>
                    <th>PR Date</th>
                    <th>PR Already</th>
                    <th>PR Next</th>
                    <th>Requester</th>
                    <th>Request Date</th>
                    <th>Item Number</th>
                    <th>Material</th>
                    <th>Description 1</th>
                    <th>Description 2</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Applicant</th>
                    <th>Vendor Code</th>
                    <th>Vendor Name</th>
                    <th>PO Number</th>
                    <th>PO Date</th>
                    <th>PO Item</th>
                    <th>PO Already</th>
                    <th>PO Next</th>
                    <th>Material 2</th>
                    <th>Description 2</th>
                    <th>PO Status</th>
                    <th>Ordered Quantity</th>
                    <th>Ordered Unit</th>
                    <th>Net Price</th>
                    <th>Currency</th>
                    <th>GR Document</th>
                    <th>GR Quantity</th>
                    <th>GR Value</th>
                    <th>Invoice Document</th>
                    <th>Posting Date</th>
                    <th>Invoice Quantity</th>
                    <th>Invoice Value</th>
                    <th>Clearing Status</th>
                    <th>Amount in Local Currency</th>
                    <th>Debit/Credit Indicator</th>
                    <th>Reference Document</th>
                    <th>Text</th>
                    <th>GR Cumulative Quantity</th>
                    <th>GR Cumulative Value</th>
                    <th>IR Cumulative Quantity</th>
                    <th>IR Cumulative Value</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('style')
<style>
  #datatable_wrapper {
    overflow-x: auto;
}
</style>
@endsection
@section('script')
  <script>
    $(document).ready(function() {
        let table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('data.po') }}",
            scrollX: true,
            scrollY: "500px",
            scrollCollapse: true,
            autoWidth: false,
            responsive: false,
            dom: 'lBfrtip',
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            buttons: [
                { extend: 'copy', className: 'btn btn-secondary' },
                { extend: 'excel', className: 'btn btn-success' },
                { extend: 'csv', className: 'btn btn-warning' },
                { extend: 'pdf', className: 'btn btn-danger' },
                { extend: 'print', className: 'btn btn-info' },
                { extend: 'colvis', className: 'btn btn-dark' }
            ],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'banfn', name: 'banfn' },
                { data: 'badat', name: 'badat' },
                { data: 'pr_already', name: 'pr_already' },
                { data: 'pr_next', name: 'pr_next' },
                { data: 'ernam', name: 'ernam' },
                { data: 'erdat', name: 'erdat' },
                { data: 'bnfpo', name: 'bnfpo' },
                { data: 'matnr1', name: 'matnr1' },
                { data: 'txz011', name: 'txz011' },
                { data: 'txz02', name: 'txz02' },
                { data: 'menge1', name: 'menge1' },
                { data: 'meins1', name: 'meins1' },
                { data: 'preis', name: 'preis' },
                { data: 'total', name: 'total' },
                { data: 'afnam', name: 'afnam' },
                { data: 'lifnr', name: 'lifnr' },
                { data: 'mcod1', name: 'mcod1' },
                { data: 'ebeln', name: 'ebeln' },
                { data: 'aedat', name: 'aedat' },
                { data: 'ebelp', name: 'ebelp' },
                { data: 'po_already', name: 'po_already' },
                { data: 'po_next', name: 'po_next' },
                { data: 'matnr2', name: 'matnr2' },
                { data: 'txz012', name: 'txz012' },
                { data: 'loekz', name: 'loekz' }, // Sudah dihandle di backend
                { data: 'menge2', name: 'menge2' },
                { data: 'meins2', name: 'meins2' },
                { data: 'netwr', name: 'netwr' },
                { data: 'waers', name: 'waers' },
                { data: 'mblnr', name: 'mblnr' },
                { data: 'grjum', name: 'grjum' },
                { data: 'grval', name: 'grval' },
                { data: 'belnr', name: 'belnr' },
                { data: 'budat', name: 'budat' },
                { data: 'irjum', name: 'irjum' },
                { data: 'irval', name: 'irval' },
                { data: 'ficlear', name: 'ficlear' },
                { data: 'wrbtr', name: 'wrbtr' },
                { data: 'shkzg', name: 'shkzg' },
                { data: 'xblnr', name: 'xblnr' },
                { data: 'bktxt', name: 'bktxt' },
                { data: 'begrjum', name: 'begrjum' },
                { data: 'begrval', name: 'begrval' },
                { data: 'beirjum', name: 'beirjum' },
                { data: 'beirval', name: 'beirval' },
                { 
                    data: 'created_at', 
                    name: 'created_at',
                    render: function(data) {
                        return data ? new Date(data).toLocaleString() : '-';
                    }
                },
                { 
                    data: 'updated_at', 
                    name: 'updated_at',
                    render: function(data) {
                        return data ? new Date(data).toLocaleString() : '-';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Event Listener untuk tombol Delete dengan SweetAlert2
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/delete/' + id, // Sesuaikan URL
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            Swal.fire('Deleted!', response.message, 'success');
                            table.ajax.reload();
                        },
                        error: function(response) {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });

    });
  </script>
  <script>
      document.getElementById("fetchDataBtn").addEventListener("click", function() {
      let docDateFrom = document.getElementById("DOC_DATE_FROM").value;
      let docDateTo = document.getElementById("DOC_DATE_TO").value;
      let compCode = document.getElementById("COMP_CODE").value;
      
      let apiUrl = `/fetch-data?DOC_DATE_FROM=${docDateFrom}&DOC_DATE_TO=${docDateTo}&COMP_CODE=${compCode}`;

      // Menampilkan loading
      document.getElementById("loading").style.display = "block";

      fetch(apiUrl)
      .then(response => response.json())
      .then(data => {
          // Menyembunyikan loading
          document.getElementById("loading").style.display = "none";

          console.log("Response JSON:", data); // Debugging

          // Jika ada error dari backend
          if (data.error) {
              alert(data.error);
              return;
          }

          // Menampilkan pesan sukses jika ada
          if (data.message) {
              console.log("Success Message:", data.message);
              alert("✅ " + data.message);
          }

          // Reload halaman setelah data berhasil disimpan
          setTimeout(() => {
              location.reload();
          }, 1); //

          let tableBody = document.getElementById("tableBody");
          tableBody.innerHTML = ""; // Bersihkan tabel sebelum memasukkan data baru
          
          data.data.forEach((item, index) => {
              let row = `
                  <tr>
                      <td class="text-center">${index + 1}</td>
                      <td>${item.banfn}</td>
                      <td>${item.badat}</td>
                      <td>${item.pr_already}</td>
                      <td>${item.pr_next}</td>
                      <td>${item.ernam}</td>
                      <td>${item.erdat}</td>
                      <td>${item.bnfpo}</td>
                      <td>${item.matnr1}</td>
                      <td>${item.txz011}</td>
                      <td>${item.txz02}</td>
                      <td>${item.menge1}</td>
                      <td>${item.meins1}</td>
                      <td>${Number(item.preis).toFixed(2)}</td>
                      <td>${Number(item.total).toFixed(2)}</td>
                      <td>${item.afnam}</td>
                      <td>${item.lifnr}</td>
                      <td>${item.mcod1}</td>
                      <td>${item.ebeln}</td>
                      <td>${item.aedat}</td>
                      <td>${item.ebelp}</td>
                      <td>${item.po_already}</td>
                      <td>${item.po_next}</td>
                      <td>${item.matnr2}</td>
                      <td>${item.txz012}</td>
                      <td>${item.loekz === '' ? 'Active' : 'Closed'}</td>
                      <td>${item.menge2}</td>
                      <td>${item.meins2}</td>
                      <td>${Number(item.netwr).toFixed(2)}</td>
                      <td>${item.waers}</td>
                      <td>${item.mblnr}</td>
                      <td>${Number(item.grjum).toFixed(2)}</td>
                      <td>${Number(item.grval).toFixed(2)}</td>
                      <td>${item.belnr}</td>
                      <td>${item.budat}</td>
                      <td>${Number(item.irjum).toFixed(2)}</td>
                      <td>${Number(item.irval).toFixed(2)}</td>
                      <td>${item.ficlear}</td>
                      <td>${Number(item.wrbtr).toFixed(2)}</td>
                      <td>${item.shkzg}</td>
                      <td>${item.xblnr}</td>
                      <td>${item.bktxt}</td>
                      <td>${Number(item.begrjum).toFixed(2)}</td>
                      <td>${Number(item.begrval).toFixed(2)}</td>
                      <td>${Number(item.beirjum).toFixed(2)}</td>
                      <td>${Number(item.beirval).toFixed(2)}</td>
                      <td>${new Date(item.created_at).toLocaleString()}</td>
                      <td>${new Date(item.updated_at).toLocaleString()}</td>
                  </tr>
              `;
              tableBody.innerHTML += row;
          });
      })
  });
  </script>
@endsection
