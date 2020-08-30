$(document).ready(function () {

  function deleteAction(id) {
    Swal.fire({
      title: "Apakah anda yakin?",
      text: "Anda tidak akan dapat mengembalikan ini!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, hapus!",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "../controllers/pengguna.php",
          type: "post",
          data: {
            id,
            type: "delete",
          },
          success: function (data) {
            Swal.fire({
              icon: "success",
              title: "Data berhasil dihapus",
              showConfirmButton: false,
              timer: 1500,
            });
            setTimeout(function () {
              window.location.reload(1);
            }, 1600);
          },
          error: function (data) {
            Swal.fire({
              icon: "error",
              title: "Data gagal dihapus",
              text: "Data gagal dihapus!",
              showConfirmButton: false,
              timer: 1500,
            });
          },
        });
      }
    });
  }

  $("#hapusPengguna").on("click", function () {
    deleteAction(idPengguna);
  });

  $("#ubah-pengguna").on("click", function (e) {
    e.preventDefault();
    let data = {
      type: "update",
      id: idPengguna,
      nama: $("#ubah-nama").val(),
      oldPassword: $("#old-password").val(),
      newPassword: $("#new-password").val(),
    };
    if (!data.nama == "") {
      $.ajax({
        url: "../controllers/pengguna.php",
        type: "post",
        data,
        success: function (data) {
          console.log(data);

          if (data.status == "success") {
            Swal.fire({
              icon: "success",
              title: "Berhasil mengubah data!",
              showConfirmButton: false,
              timer: 1500,
            });
            setTimeout(function () {
              window.location.reload(1);
            }, 1600);
          } else if (data.status == "error") {
            Swal.fire({
              icon: "error",
              title: "Gagal mengubah data!",
              showConfirmButton: false,
              timer: 1500,
            });
          }
        },
        error: function (data) {
          Swal.fire({
            icon: "error",
            title: "Update Failed !",
            showConfirmButton: false,
            timer: 1500,
          });
        },
      });
    }else{
      Swal.fire("Peringatan!", "Pastikan Semua Data sudah terisi", "warning");
    }
  });
});
