/**
 * Governs the login screen.
 *
 * @author Neo Ighodaro <neo@hng.tech>
 */
(function() {
    'use strict';

    /**
     * Just check if the user can now login.
     *
     * @return {boolean}
     */
    function canNowLogIn(username, password) {
        return (username.length >= 3 && username.indexOf('@') >= 0 && password.length >= 6);
    }


    // While typing the username or password check if the button
    // should be enabled or disabled.

    $('.login-form input').on('keyup', function (evt) {
        var btn        = $('.submit-btn');
        var username   = $('.login-input.username').val();
        var password   = $('.login-input.password').val();
        var canLogin   = canNowLogIn(username, password);
        var isDisabled = btn[0].hasAttribute('disabled');

        if (canLogin && isDisabled) {
            btn.removeAttr('disabled');
        }

        if ( ! canLogin && ! isDisabled) {
            btn.attr('disabled', true);
        }
    });

}());