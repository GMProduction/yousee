document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".sidebar .nav-link").forEach(function (element) {
    element.addEventListener("click", function (e) {
      let nextEl = element.nextElementSibling;
      let parentEl = element.parentElement;

      if (nextEl) {
        e.preventDefault();
        let mycollapse = new bootstrap.Collapse(nextEl);

        if (nextEl.classList.contains("show")) {
          mycollapse.hide();
        } else {
          mycollapse.show();
          // find other submenus with class=show
          var opened_submenu = parentEl.parentElement.querySelector(
            ".submenu.show"
          );
          // if it exists, then close all of them
          if (opened_submenu) {
            new bootstrap.Collapse(opened_submenu);
          }
        }
      }
    }); // addEventListener
  }); // forEach
});

var side = 1;

function openNav() {
  if (side == 1) {
    document.getElementById("sidebar").classList.add("ciut");
    side = 0;
  } else {
    document.getElementById("sidebar").classList.remove("ciut");
    side = 1;
  }
}

function statusToString(stat) {
  var status = "";

  if (stat == 0) {
    status = "<div class='pill blue'> Pencarian Titik </div>";
  } else if (stat == 1) {
    status = "<div class='pill orange'> Pengajuan Penawaran </div>";
  } else if (stat == 2) {
    status = "<div class='pill green'> Sedang Tayang </div>";
  } else if (stat == 3) {
    status = "<div class='pill grey'> Selesai </div>";
  } else {
    status = "<div class='pill red'> Batal </div>";
  }

  return status;
}

// var header = document.getElementById("sidebar");
// var btns = header.getElementsByClassName("menu");
// for (var i = 0; i < btns.length; i++) {
//     btns[i].addEventListener("click", function() {
//         var current = document.getElementsByClassName("active");
//         current[0].className = current[0].className.replace(" active", "");
//         this.className += " active";
//     });
// }
