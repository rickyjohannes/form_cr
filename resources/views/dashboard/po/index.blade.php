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
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data_po as $itOutput)
                    <tr>
                      <td class="text-center">{{ $loop->iteration }}</td>
                      <td>{{ $itOutput->banfn }}</td>
                      <td>{{ $itOutput->badat }}</td>
                      <td>{{ $itOutput->pr_already }}</td>
                      <td>{{ $itOutput->pr_next }}</td>
                      <td>{{ $itOutput->ernam }}</td>
                      <td>{{ $itOutput->erdat }}</td>
                      <td>{{ $itOutput->bnfpo }}</td>
                      <td>{{ $itOutput->matnr1 }}</td>
                      <td>{{ $itOutput->txz011 }}</td>
                      <td>{{ $itOutput->txz02 }}</td>
                      <td>{{ $itOutput->menge1 }}</td>
                      <td>{{ $itOutput->meins1 }}</td>
                      <td>{{ number_format($itOutput->preis, 2) }}</td>
                      <td>{{ number_format($itOutput->total, 2) }}</td>
                      <td>{{ $itOutput->afnam }}</td>
                      <td>{{ $itOutput->lifnr }}</td>
                      <td>{{ $itOutput->mcod1 }}</td>
                      <td>{{ $itOutput->ebeln }}</td>
                      <td>{{ $itOutput->aedat }}</td>
                      <td>{{ $itOutput->ebelp }}</td>
                      <td>{{ $itOutput->po_already }}</td>
                      <td>{{ $itOutput->po_next }}</td>
                      <td>{{ $itOutput->matnr2 }}</td>
                      <td>{{ $itOutput->txz012 }}</td>
                      <td>{{ $itOutput->loekz == '' ? 'Active' : 'Closed' }}</td>
                      <td>{{ $itOutput->menge2 }}</td>
                      <td>{{ $itOutput->meins2 }}</td>
                      <td>{{ number_format($itOutput->netwr, 2) }}</td>
                      <td>{{ $itOutput->waers }}</td>
                      <td>{{ $itOutput->mblnr }}</td>
                      <td>{{ number_format($itOutput->grjum, 2) }}</td>
                      <td>{{ number_format($itOutput->grval, 2) }}</td>
                      <td>{{ $itOutput->belnr }}</td>
                      <td>{{ $itOutput->budat }}</td>
                      <td>{{ number_format($itOutput->irjum, 2) }}</td>
                      <td>{{ number_format($itOutput->irval, 2) }}</td>
                      <td>{{ $itOutput->ficlear }}</td>
                      <td>{{ number_format($itOutput->wrbtr, 2) }}</td>
                      <td>{{ $itOutput->shkzg }}</td>
                      <td>{{ $itOutput->xblnr }}</td>
                      <td>{{ $itOutput->bktxt }}</td>
                      <td>{{ number_format($itOutput->begrjum, 2) }}</td>
                      <td>{{ number_format($itOutput->begrval, 2) }}</td>
                      <td>{{ number_format($itOutput->beirjum, 2) }}</td>
                      <td>{{ number_format($itOutput->beirval, 2) }}</td>
                      <td>{{ \Carbon\Carbon::parse($itOutput->created_at)->format('d-m-Y H:i:s') }}</td>
                      <td>{{ \Carbon\Carbon::parse($itOutput->updated_at)->format('d-m-Y H:i:s') }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('script')
  <script>
    // Delete Button with SweetAlert2
    $('form[id^="delete-form-"]').submit(function(e) {
      e.preventDefault();

      Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure you want to delete this item?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if(result.isConfirmed) {
          this.submit();
        }
      })
    })
    
    // DataTables
    $('#datatable').DataTable({
        responsive: true,
        autoWidth: false,
        layout: {
            top2Start: {
                buttons: [
                    {
                        extend: 'copy',
                        titleAttr: 'Copy to Clipboard',
                        text: '<i class="fas fa-copy"></i>',
                        className: 'btn btn-secondary'
                    },
                    {
                        extend: 'excel',
                        titleAttr: 'Export to Excel',
                        text: '<i class="fas fa-file-excel"></i>',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'csv',
                        titleAttr: 'Export to CSV',
                        text: '<i class="fas fa-file-csv"></i>',
                        className: 'btn btn-warning'
                    },
                    {
                        extend: 'pdf',
                        titleAttr: 'Export to PDF',
                        text: '<i class="fas fa-file-pdf"></i>',
                        className: 'btn btn-danger'
                    },
                    {
                        extend: 'print',
                        titleAttr: 'Print',
                        text: '<i class="fas fa-print"></i>',
                        className: 'btn btn-info'
                    },
                    {
                        extend: 'colvis',
                        titleAttr: 'Column Visibility',
                        text: '<i class="fas fa-eye"></i>',
                        className: 'btn btn-dark'
                    }
                ]
            },
            topStart: {
                pageLength: {
                    menu: ['5', '10', '25', '50', '100']
                }
            },
            topEnd: {
                search: {
                    placeholder: 'Search here ...'
                }
            }
        }
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
