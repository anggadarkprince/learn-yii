var app = app || {};
(function (app) {
    'use strict';

    var following = function (options, isFollow) {
        var action = isFollow ? 'follow' : 'unfollow';

        var params = new URLSearchParams();
        params.append('following_id', options.id);

        axios.post('/follower/' + action, params)
            .then(function (response) {
                options.onSuccess(response);
            })
            .catch(function (error) {
                options.onError(error);
            });
    }

    app.unfollow = function (options) {
        following(options, false);
    }

    app.follow = function (options) {
        following(options, true);
    }

    app.followControl = function (options) {
        if (options.state == 1) {
            options.button
                .data('state', 0)
                .text(options.followText)
                .addClass(options.followClass)
                .removeClass(options.followingClass);
            app.unfollow(options);
        } else {
            options.button
                .data('state', 1)
                .text(options.followingText)
                .addClass(options.followingClass)
                .removeClass(options.followClass);
            app.follow(options)
        }
        options.button.blur();
    }
}(app));