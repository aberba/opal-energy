$(function() {

    $(".table .edit").on("click", function() {
        Settings.activateOrDeactivateEdit();
    });

    $("table tr td.value").on("blur", function() {
        $id    = $(this).attr("id");
        $value = $(this).text().trim();
        Settings.save($id, $value);
    });

    $(".advanced-settings-section .show-form").on("click", function(e) {
    	e.preventDefault();
    	var $this = $(this);
    	Settings.authenticate(function(e) {
    		if(e.indexOf("granted") == -1) {
    			Notification.show(e);
    			return false;
    		}
    		$this.hide();
    		Settings.showAdvancedSettingsForm();
    	});
    });
});

var Settings = {
	activateOrDeactivateEdit: function() {
		$td      = $("table tr td.value");
		$td_attr = $("table tr td.value").attr("contenteditable");
		if($td_attr == "false") {
			$td.attr("contenteditable", "true");
		}else {
			$td.attr("contenteditable", "false");
		}
	},
	save: function(id, value) {
        var data   = "save_settings=yes&id="+id+"&value=" + encodeURI(value);

        $.ajax({
            type: "POST",
            url: "ajax/save.php",
            data: data,
            processData: false,
            success: function(e) {
                Notification.show(e);
            }
        });
	},
	authenticate: function(callback) {
		var $pass = window.prompt("Please authenticate with your password ...");
		if($pass) {
			$var = $url = "authenticate=yes&pass="+$pass;
			$.post("ajax/session.php", $url, function(e) {
                 callback(e);
			});
		}
	},
	showAdvancedSettingsForm: function() {
		var $url = "query_settings=yes";
		$.get("ajax/query.php", $url, function(e) {

			if(e == 0) return false;
			var $data = JSON.parse(e);

            var $form = $("<form />", {"class":"advanced-setings-form form"});
            var $name, $label, $input;

			for(var i in $data) {
				$name  = $data[i].setting_name.replace(/(_)/, " ");
				$label = $("<label />", {"text":$name});
                $input = $("<input />", {"type":"text", "id": $data[i].setting_id, "value":$data[i].setting_value});
                $form.append($label).append($input);
			}

			var $ok_btn   = $("<button />", {"class":"save-settings button", "text":" OK "}).on("click", function(e) {
                e.preventDefault();
	        	Settings.hideAdvancedSettingsForm();

                $("html, body").animate({
                    scrollTop: $(document).height() +"px"
                });
            });

			$form.append($ok_btn)
	        $(".advanced-settings-section").append($form);
	        $form.hide().fadeIn(2000);

	        $(".advanced-settings-section .form input[type=text]").on("blur", function() {
	             var $id    = $(this).attr("id");
	             var $value = $(this).val();

	             Settings.save($id, $value);
			});

		});
	},
	hideAdvancedSettingsForm: function() {
        $(".advanced-settings-section .form").fadeOut("slow").replaceWith(" ");
        $(".advanced-settings-section .show-form").fadeIn("slow");
	}
}
