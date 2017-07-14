var app = app || {};
(function (app) {
    'use strict';

    var sluggedText = '';
    var breakSync = false;

    var toSlug = function (text) {
        var titleLower = text.toLowerCase();
        var replaceVocal = titleLower.replace(/[\u00C0-\u00C5]/ig, 'a')
        replaceVocal = replaceVocal.replace(/[\u00C8-\u00CB]/ig, 'e')
        replaceVocal = replaceVocal.replace(/[\u00CC-\u00CF]/ig, 'i')
        replaceVocal = replaceVocal.replace(/[\u00D2-\u00D6]/ig, 'o')
        replaceVocal = replaceVocal.replace(/[\u00D9-\u00DC]/ig, 'u')
        var replaceBreak = replaceVocal.replace(/[\u00D1]/ig, 'n')
        var alphaNumeric = replaceBreak.replace(/[^a-z0-9 ]+/gi, '')
        var stripSlug = alphaNumeric.trim().replace(/ /g, '-');
        stripSlug = stripSlug.replace(/[\-]{2}/g, '');
        return (stripSlug.replace(/[^a-z0-9\- ]*/gi, ''));
    }

    app.slug = function (options) {
        sluggedText = toSlug(options.text);
        if (!breakSync || options.autoSync) {
            $(options.target).val(sluggedText);
        }

        $(options.target).keyup(function () {
            if ($(this).val() != sluggedText) {
                breakSync = true;
            } else {
                breakSync = false;
            }
        });
    }
}(app));