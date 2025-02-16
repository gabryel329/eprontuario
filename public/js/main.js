(function () {
    "use strict";

    var treeviewMenu = $('.app-menu');

    // Toggle Sidebar
    $('[data-toggle="sidebar"]').click(function(event) {
        event.preventDefault();
        $('.app').toggleClass('sidenav-toggled');
    });

    // Activate sidebar treeview toggle
    $("[data-toggle='treeview']").click(function(event) {
        event.preventDefault();
        if(!$(this).parent().hasClass('is-expanded')) {
            treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
        }
        $(this).parent().toggleClass('is-expanded');
    });

    // Sidebar hover functionality
    $('.app-sidebar').addClass('closed'); // Start with sidebar closed

    $('.app-sidebar').on('mouseenter', function() {
        $(this).removeClass('closed').addClass('open');
    });

    $('.app-sidebar').on('mouseleave', function() {
        $(this).removeClass('open').addClass('closed');
    });

})();
