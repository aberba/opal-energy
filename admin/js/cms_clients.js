$(function() {

    $(".clients-section .client-upload-form .save-btn").on("click", function(e) {
        e.preventDefault();

        var form = $(".clients-section .client-upload-form");
        var name = form.children("input[name=name]").val();
        var logo = form.children("input[name=logo]")[0].files[0];
        var link = form.children("input[name=link]").val();

        //Error checking
        if ( !name ) {
            Notification.show("Please enter client name");
            return false;
        }

        if ( !link ) {
            Notification.show("Please enter client link");
            return false;
        }

        if ( !logo ) {
            Notification.show("Please select client logo image to upload");
            return false;
        }

        Clients.add(
                {
                    name: name,
                    logo: logo,
                    link: link
                });
    });

    $(".clients-section .add-btn").on("click", function(e) {
    	e.preventDefault();

        $(".clients-section .cancel-btn").show();
        $(".clients-section .add-btn").hide();

        var form = $(".clients-section .client-upload-form");
        form.slideToggle();
    });

    $(".clients-section .cancel-btn").on("click", function(e) {
        e.preventDefault();
        var $this = $(this);

        //toggle UI elements
        $(".clients-section .client-upload-form").slideToggle();
        $(".clients-section .add-btn").show();
        $(".clients-section .cancel-btn").hide();

        //reset form
        Clients.resetForm();
    });
});

var Clients = {

	add: function(data) {
        var formData = false;
        formData     = new FormData();

        if ( !formData ) {
            Notification.show("Your browser does not support FormData");
            return false;
        }

        formData.append("upload_client", "yes");
        formData.append("name", data.name);
        //formData.append("description", data.description);
        formData.append("link", data.link);
        formData.append("logo", data.logo);

        $.ajax({
            type: "POST",
            url: "ajax/upload.php",
            data: formData,
            contentType: false,
            processData: false,
            success: function(e) {
                Clients.resetForm();
                $(".clients-section .cancel-btn").click(); // hide form
                Notification.show(e);
            }
        });
	},

    resetForm: function() {
        var form = $(".clients-section .client-upload-form");
        form.children("input[name=name]").val(null);
        form.children("input[name=logo]").val(null);
        form.children("input[name=link]").val(null);
    },

    remove: function(id) {

    },

    changePublishingStatus: function(id) {

    }
};
