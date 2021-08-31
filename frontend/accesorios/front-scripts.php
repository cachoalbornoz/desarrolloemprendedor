<!-- jQuery 3 -->
<script src="/desarrolloemprendedor/public/js/jquery-3.4.1.min.js"></script>

<!-- Jquery Validate -->
<script src="/desarrolloemprendedor/public/js/validated.js"></script>
<script src="/desarrolloemprendedor/public/jquery-validation-1.19.0/dist/jquery.validate.min.js"></script>
<script src="/desarrolloemprendedor/public/jquery-validation-1.19.0/dist/additional-methods.min.js"></script>
<script src="/desarrolloemprendedor/public/js/validation-locate-es.js"></script>

<!-- Bootstrap 4.3.1 -->
<script src="/desarrolloemprendedor/public/bootstrap-4.3.1/js/dist/popper.min.js"></script>
<script src="/desarrolloemprendedor/public/bootstrap-4.3.1/js/dist/util.js"></script>
<script src="/desarrolloemprendedor/public/bootstrap-4.3.1/dist/js/bootstrap.min.js"></script>

<!--Plugin Adicional Ymz	-->
<script src="/desarrolloemprendedor/public/alert_js/ymz_box.min.js"> </script>
<!--Plugin Adicional Mask	-->
<script src="/desarrolloemprendedor/public/jquery-mask/dist/jquery.mask.min.js"> </script>
<!-- Plugin Adicional Select2 -->
<script type="text/javascript" src="/desarrolloemprendedor/public/js/select2/dist/js/select2.min.js"></script>

<!--Plugin Adicional Toast	-->
<script src="/desarrolloemprendedor/public/js/toastr.js"> </script>
<!-- Jovenes Scripts 1 -->
<script src="/desarrolloemprendedor/validaciones/ScriptsJovenes.js"></script>
<script src="/desarrolloemprendedor/validaciones/validaciones.js"></script>
<script src="/desarrolloemprendedor/validaciones/formularios.js"></script>

<script >
    $('.dropdown-submenu > a').on("click", function(e) {
        var submenu = $(this);
        $('.dropdown-submenu .dropdown-menu').removeClass('show');
        submenu.next('.dropdown-menu').addClass('show');
        e.stopPropagation();
    });

    $('.dropdown').on("hidden.bs.dropdown", function() {
        // hide any open menus when parent closes
        $('.dropdown-menu.show').removeClass('show');
    });
</script>
