$(document).ready(function () {
  $(".gantiPassword").hide();

  $("#togglePass").click(function () {
    if ($(this).prop("checked") == true) {
      $(".gantiPassword").show();
    } else if ($(this).prop("checked") == false) {
      $(".gantiPassword").hide();
      $("#old-password").val("");
      $("#new-password").val("");
    }
  });

  function deleteAction(id) {
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger",
      },
      buttonsStyling: false,
    });
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
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
            swalWithBootstrapButtons.fire(
              "Deleted!",
              "Your data has been deleted.",
              "success"
            );
            setTimeout(function () {
              window.location.reload(1);
            }, 1600);
          },
          error: function (data) {
            swalWithBootstrapButtons.fire(
              "Gagal!",
              "Failed to delete your data.",
              "error"
            );
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
    $.ajax({
      url: "../controllers/pengguna.php",
      type: "post",
      data,
      success: function (data) {
        if (data.status == "success") {
          Swal.fire({
            icon: "success",
            title: "Update Success !",
            showConfirmButton: false,
            timer: 1500,
          });
          setTimeout(function () {
            window.location.reload(1);
          }, 1600);
        } else if (data.status == "error") {
          Swal.fire({
            icon: "error",
            title: "Update Failed!",
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
  });
});
