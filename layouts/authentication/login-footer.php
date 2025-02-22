<!-- BEGIN: Vendor JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN Sweetalert2 JS -->
<script src="app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
<script src="app-assets/vendors/js/extensions/polyfill.min.js"></script>
<!-- END Sweetalert2 JS -->

<!-- BEGIN: Theme JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="app-assets/js/scripts/extensions/ext-component-sweet-alerts.js"></script>
<!-- END: Page JS-->

<!-- BEGIN: Validate-->
<script type="text/javascript">
    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            return this.optional(element) || regexp.test(value);
        },
        "Please check your input."
    );

    $('#frmlogin').validate({
        rules: {
            'auth_username': {
                required: true,
                rangelength: [5, 20],
                regex: /^[a-zA-Z0-9]{5,20}$/
            },
            'auth_password': {
                required: true,
                rangelength: [6, 20]
            }
        }
    });
</script>
<!-- END: Validate-->