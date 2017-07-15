(function () {

    var app = {
        baseUrl: $('meta[name=url]').attr('content'),
        csrf: $('meta[name=csrf-token]').attr('content')
    };
    axios.defaults.baseURL = app.baseUrl;
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.headers.common['X-CSRF-TOKEN'] = app.csrf

}());

$(function () {
    var buttonSearch = $('.navbar-button-search');
    var inputSearch = $('.navbar-search');

    buttonSearch.on('click', function (e) {
        e.preventDefault();

        $(this).fadeOut(200, function () {
            inputSearch.animate({width: 'show'}, function () {
                inputSearch.find('input').focus();
            });
        });
    });

    inputSearch.on('focusout', function (e) {
        e.preventDefault();

        $(this).animate({width: 'hide'}, function () {
            buttonSearch.fadeIn(300);
        });
    });

    /* Follow Control */
    $('[data-toggle=follow]').click(function () {
        var buttonFollow = $(this);
        app.followControl({
            button: buttonFollow,
            state: buttonFollow.data('state'),
            id: buttonFollow.data('id'),
            followText: 'Follow Me',
            followClass: 'btn-default',
            followingText: 'Following',
            followingClass: 'btn-primary',
            onSuccess: function (response) {
                console.log(response);
            },
            onError: function (error) {
                console.log(error);
            }
        });
    });

    /* Slug Control */
    $('[data-toggle=slug]').keyup(function () {
        app.slug({
            text: $(this).val(),
            target: $(this).data('target'),
            autoSync: false
        });
    });

    /* Show More About */
    $('.account-show-more').click(function (e) {
        e.preventDefault();
        var about = $('.account-about').data('content');
        $('.account-about').html(about);
        $(this).remove();
    });

    $.fn.select2.defaults.set("theme", "bootstrap");
    $('select').select2();
    $("select").on("select2:open", function () {
        $(".select2-search__field").attr("placeholder", "Search...");
    });
    $("select").on("select2:close", function () {
        $(".select2-search__field").attr("placeholder", null);
    });

    $('[type=time]').datetimepicker({
        format: 'HH:mm',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        }
    });

    $('[type=date]').datetimepicker({
        format: 'd MMMM YYYY',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        }
    });

    /* Recipe form */
    app.recipe.init();
    app.recipe.form();
});