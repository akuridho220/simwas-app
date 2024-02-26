// function when edit-button class clicked
$(document).on("click", ".edit-button", function () {
    var id = $(this).data("id");
    $("#edit-form").attr("action", "/admin/master-hasil-kerja/" + id);
    $.ajax({
        url: "/admin/master-hasil-kerja/detail/" + id,
        method: "GET",
        success: function (data) {
            $("#editId").val(data.id);
            $("#editMasterUnsurId").val(data.masterUnsurId);
            $("#editMasterSubUnsurId").val(data.master_subunsur_id);
            $("#editNamaHasilKerja").val(data.nama_hasil_kerja);
            $("#editHasilKerjaTim").val(data.hasil_kerja_tim);
            $("#editPengendaliTeknis").val(data.pengendali_teknis);
            $("#editKetuaTim").val(data.ketua_tim);
            $("#editPicKoordinator").val(data.pic);
            $("#editAnggotaTim").val(data.anggota_tim);

            console.log($("#editAnggotaTim").val());
            if (data.pic != null) {
                $("#editStatus1").prop("checked", true);
                $("#edit-picKoordinator").show();
                $("#edit-picKoordinator").attr("required", true);
                $("#edit-pengendali-teknis").hide();
                $("#edit-ketua-tim").hide();
                $("#edit-pengendaliTeknis").attr("required", false);
                $("#edit-ketuaTim").attr("required", false);
            } else {
                $("#editStatus2").prop("checked", true);
                $("#edit-picKoordinator").hide();
                $("#edit-picKoordinator").attr("required", false);
                $("#edit-pengendali-teknis").show();
                $("#edit-ketua-tim").show();
                $("#edit-pengendaliTeknis").attr("required", true);
                $("#edit-ketuaTim").attr("required", true);
            }
        },
    });
});

$(document).on("click", ".hapus-button", function () {
    var id = $(this).data("id");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Data tidak dapat dipulihkan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $("#form-" + id).trigger("submit");
        }
    });
});

$(document).on("change", "#masterUnsurId", function () {
    var id = $(this).val();
    console.log(id);
    $.ajax({
        url: "/admin/master-subunsur/unsur/" + id,
        method: "GET",
        success: function (data) {
            $("#masterSubUnsurId").attr("disabled", false);
            var html = "";
            data.forEach((item) => {
                html += `<option value="${item.id}">${item.nama_sub_unsur}</option>`;
            });
            $("#masterSubUnsurId").html(html);
        },
    });
});

// onchange radio button
$(document).on("change", "input[type=radio][name=status]", function () {
    var value = $(this).val();
    if (value == "1") {
        $("#picKoordinator").hide();
        $("#picKoordinator").attr("required", false);
        $("#pengendali-teknis").show();
        $("#ketua-tim").show();
        $("#pengendaliTeknis").attr("required", true);
        $("#ketuaTim").attr("required", true);
    } else {
        $("#picKoordinator").show();
        $("#picKoordinator").attr("required", true);
        $("#pengendali-teknis").hide();
        $("#ketua-tim").hide();
        $("#pengendaliTeknis").attr("required", false);
        $("#ketuaTim").attr("required", false);
    }
});
$(document).on("change", "input[type=radio][name=editStatus]", function () {
    var value = $(this).val();
    if (value == "1") {
        $("#edit-picKoordinator").hide();
        $("#edit-picKoordinator").attr("required", false);
        $("#edit-pengendali-teknis").show();
        $("#edit-ketua-tim").show();
        $("#edit-pengendaliTeknis").attr("required", true);
        $("#edit-ketuaTim").attr("required", true);
    } else {
        $("#edit-picKoordinator").show();
        $("#edit-picKoordinator").attr("required", true);
        $("#edit-pengendali-teknis").hide();
        $("#edit-ketua-tim").hide();
        $("#edit-pengendaliTeknis").attr("required", false);
        $("#edit-ketuaTim").attr("required", false);
    }
});