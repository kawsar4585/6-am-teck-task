$(document).ready(function() {

	var $wrapper = $('.main-wrapper');

	setTimeout(function () {
		$('#loader-wrapper');
		setTimeout(function () {
			$("#loader-wrapper").hide();
		}, 100);
	}, 500);

	// Sidebar

	var Sidemenu = function() {
		this.$menuItem = $('#sidebar-menu a');
	};
	function init() {
		var $this = Sidemenu;
		$('#sidebar-menu a').on('click', function(e) {
			if($(this).parent().hasClass('submenu')) {
				e.preventDefault();
			}
			if(!$(this).hasClass('subdrop')) {
				$('ul', $(this).parents('ul:first')).hide(350);
				$('a', $(this).parents('ul:first')).removeClass('subdrop');
				$(this).next('ul').show(350);
				$(this).addClass('subdrop');
			} else if($(this).hasClass('subdrop')) {
				$(this).removeClass('subdrop');
				$(this).next('ul').hide(350);
			}
		});
		$('#sidebar-menu ul li.submenu a.active').parents('li:last').children('a:first').addClass('active').trigger('click');
        setTimeout(function () {
            $('#sidebar-menu>ul>li.submenu>ul>li.submenu a.active').trigger('click');
        },300);



	}
	init();

	// Password toggle



	$("#toggle-password").click(function () {
		$( this ).toggleClass("fa-eye fa-eye-slash");
        if ($("#password").attr("type") == "password")
        {
            $("#password").attr("type", "text");
        } else
        {
            $("#password").attr("type", "password");
        }
    });
    $("#toggle-cpassword").click(function () {
		$( this ).toggleClass("fa-eye fa-eye-slash");
        if ($("#password_confirmation").attr("type") == "password")
        {
            $("#password_confirmation").attr("type", "text");
        } else
        {
            $("#password_confirmation").attr("type", "password");
        }
    });

	// Mobile menu sidebar overlay

	$('body').append('<div class="sidebar-overlay"></div>');
	$(document).on('click', '#mobile_btn', function() {
		$wrapper.toggleClass('slide-nav');
		$('.sidebar-overlay').toggleClass('opened');
		$('html').addClass('menu-opened');
		$('#task_window').removeClass('opened');
		return false;
	});

	$(".sidebar-overlay").on("click", function () {
			$('html').removeClass('menu-opened');
			$(this).removeClass('opened');
			$wrapper.removeClass('slide-nav');
			$('.sidebar-overlay').removeClass('opened');
			$('#task_window').removeClass('opened');
	});

});


