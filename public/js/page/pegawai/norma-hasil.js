let table;

if ($("#table-norma-hasil").length) {
    table = $("#table-norma-hasil")
        .dataTable({
            dom: "Bfrtip",
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: [
                {
                    extend: "excel",
                    className: "btn-success",
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4],
                    },
                },
                {
                    extend: "pdf",
                    className: "btn-danger",
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4],
                    },
                },
            ],
            oLanguage: {
                sSearch: "Cari:",
                sZeroRecords: "Data tidak ditemukan",
                sEmptyTable: "Data tidak ditemukan",
                sInfo: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                sInfoEmpty: "Menampilkan 0 - 0 dari 0 data",
                sInfoFiltered: "(disaring dari _MAX_ data)",
                sLengthMenu: "Tampilkan _MENU_ data",
                oPaginate: {
                    sPrevious: "Sebelumnya",
                    sNext: "Selanjutnya",
                },
            },
        })
        .api();

    // move datatable button to inside download button
    $(".dt-buttons").appendTo("#download-button");
    $(".dt-buttons").appendTo("#download-button");
    $(".dataTables_filter").appendTo("#filter-search-wrapper");
    $(".dataTables_filter").find("input").addClass("form-control");
    // .dataTables_filter width 100%
    $(".dataTables_filter").css("width", "100%");
    // .dataTables_filter label width 100%
    $(".dataTables_filter label").css("width", "100%");
    // input height 35px
    $(".dataTables_filter input").css("height", "35px");
    // make label text bold and black
    $(".dataTables_filter label").css("font-weight", "bold");
    // remove bottom margin from .dataTables_filter
    $(".dataTables_filter label").css("margin-bottom", "0");

    $(".dataTables_filter input").attr(
        "placeholder",
        "Cari berdasarkan nomor surat"
    );
    // add padding x 10px to .dataTables_filter input
    $(".dataTables_filter input").css("padding", "0 10px");
    $(".dt-buttons").appendTo("#download-button");
}
// restart numbering if data table is filter input is changed
$("#table-norma-hasil").on("search.dt", function () {
    table
        .column(0, { search: "applied", order: "applied" })
        .nodes()
        .each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
});

$("#rencana_id").on("change", function () {
    console.log("change");
    let rencana_id = $(this).val();
    $.ajax({
        url: "/objek-pengawasan-search/",
        type: "GET",
        data: {
            rencana_id: rencana_id,
        },
        success: function (data) {
            // if data not 0
            if (data.data.length > 0) {
                $("#objek_kegiatan").prop("disabled", false);
                // fill option with data.data
                $("#objek_kegiatan").empty();
                $("#objek_kegiatan").append(
                    '<option value="">Pilih Objek Pengawasan</option>'
                );
                $.each(data.data, function (key, value) {
                    $("#objek_kegiatan").append(
                        '<option value="' +
                            value.id_objek +
                            '">' +
                            value.nama +
                            "</option>"
                    );
                });
            } else {
                $("#objek_kegiatan").prop("disabled", true);
            }
        },
        error: function (data) {
            console.log(data);
        },
    });
});

$("#objek_kegiatan").select2({
    placeholder: "Pilih Objek Pengawasan",
    allowClear: true,
});

function filterTable() {
    let filterYear = $("#filter-year").val();
    let filterSurat = $("#filter-surat").val();
    let filterStatus = $("#filter-status").val();
    console.log(filterYear, filterSurat, filterStatus);

    if (filterYear == "Semua") {
        filterYear = "";
    }
    if (filterSurat == "Semua") {
        filterSurat = "";
    }
    if (filterStatus == "Semua") {
        filterStatus = "";
    }

    table
        .column(1)
        .search(filterSurat, true, false)
        .column(3)
        .search(filterYear, true, false)
        .column(4)
        .search(filterStatus, true, false)
        .draw();

    // reset numbering in table first column
    table
        .column(0, { search: "applied", order: "applied" })
        .nodes()
        .each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
}
$("#filter-year, #filter-surat, #filter-status").on("change", function () {
    filterTable();
});
