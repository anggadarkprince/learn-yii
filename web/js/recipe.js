var app = app || {};
(function (app) {
    'use strict';

    var formRecipe = $('#recipe-form');
    var inputIngredient = $('#ingredient');
    var inputIngredientHidden = $('#ingredient-ingredient');
    var inputDirection = $('#direction');
    var inputDirectionHidden = $('#direction-direction');
    var buttonAddIngredient = $('#button-add-ingredient');
    var buttonAddDirection = $('#button-add-direction');
    var tableInputIngredient = $('#table-input-ingredient');
    var tableInputDirection = $('#table-input-direction');

    var ingredientData = [];
    var directionData = [];

    function uuidv4() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    var pushItem = function (params) {
        // populate push preferences
        var defaultOptions = {
            data: null,
            table: null,
            input: '',
            removeClass: 'button-remove',
            hiddenName: 'Recipe',
            hiddenClass: 'recipe-inputs',
            hiddenInput: 'recipe-hidden',
            maxItem: 20
        };
        var config = $.extend({}, defaultOptions, params);

        // determine if input is string value or input DOM object
        var value = '';
        if (typeof config.input === 'string') {
            value = config.input;
        } else {
            value = config.input.val().toString().trim();
        }

        // validate input data
        if (value === '' || value.length === 0) {
            alert('Please input an item');
            return false;
        } else if (config.data.length >= config.maxItem) {
            alert('Maximum ' + config.maxItem + ' item allow to listed');
            return false;
        } else {
            // push data into array container
            var uuidItem = uuidv4();
            config.data.push({
                uuid: uuidItem,
                value: value
            });

            // create list item in table
            addRow(uuidItem, value, config.data.length, config.removeClass, config.table.find('tbody'));

            // create array hidden inputs
            buildInputs(config.data, config.hiddenClass, config.hiddenName);

            // reorder table if needed
            reorderItem(config.data, config.table, config.hiddenInput);

            // reset input value
            if (typeof config.input !== 'string') {
                config.input.val('');
            }

            return true;
        }
    };

    var addRow = function (uuid, value, order, removeClass, container) {
        var row = $('<tr>', {'data-uuid': uuid})
            .append($('<td class="text-center">').text(order))
            .append($('<td>').append(value))
            .append($('<td class="text-center">').append(
                $('<button>', {
                    class: 'btn btn-danger btn-sm ' + removeClass,
                    type: 'button'
                }).html('<i class="fa fa-trash-o"></i>')
                )
            );
        container.append(row);
    };

    var buildInputs = function (data, className, inputName) {
        $('.' + className).remove();
        var inputTags = $();
        for (var i = 0; i < data.length; i++) {
            inputTags = inputTags.add(
                $('<input>', {
                    type: 'hidden',
                    name: inputName + '[' + i + ']' + '[' + inputName.toLowerCase() + ']',
                    class: className,
                    id: data[i].uuid,
                    value: data[i].value
                })
            );
        }
        formRecipe.prepend(inputTags);
    };

    var spliceItem = function (button, data) {
        var row = button.closest('tr');
        var uuid = row.data('uuid');
        var isFound = false;
        for (var i = 0; i < data.length; i++) {
            if (data[i].uuid === uuid) {
                data.splice(i, 1);
                isFound = true;
                break;
            }
        }
        if (isFound) {
            row.remove();
        }
    };

    var reorderItem = function (data, table, input) {
        table.find('tbody').find('tr').each(function (index) {
            $(this).children('td').first().html(index + 1);
        });
        input.val(data.length ? data.length : '');
    };

    var actionInit = function () {
        var ingredients = $('input.recipe-ingredients');
        ingredients.each(function (index, input) {
            if ($(input).val() !== '') {
                ingredientData.push({
                    uuid: $(input).attr('id'),
                    value: $(input).val()
                });
                addRow($(input).attr('id'), $(input).val(), index + 1, 'button-remove-ingredient',
                    tableInputIngredient.find('tbody'));
            }
        });
        inputIngredientHidden.val(ingredientData.length);

        var directions = $('input.recipe-directions');
        directions.each(function (index, input) {
            if ($(input).val() !== '') {
                directionData.push({
                    uuid: $(input).attr('id'),
                    value: $(input).val()
                });
                addRow($(input).attr('id'), $(input).val(), index + 1, 'button-remove-direction',
                    tableInputDirection.find('tbody'));
            }
        });
        inputDirectionHidden.val(directionData.length);
    };

    var actionForm = function () {
        buttonAddIngredient.on('click', function () {
            pushItem({
                data: ingredientData,
                table: tableInputIngredient,
                input: inputIngredient,
                removeClass: 'button-remove-ingredient',
                hiddenName: 'Ingredient',
                hiddenClass: 'recipe-ingredients',
                hiddenInput: inputIngredientHidden
            });
            $(this).blur();
        });

        formRecipe.on('click', '.button-remove-ingredient', function () {
            spliceItem($(this), ingredientData);
            buildInputs(ingredientData, 'recipe-ingredients', 'Ingredient');
            reorderItem(ingredientData, tableInputIngredient, inputIngredientHidden);
        });

        buttonAddDirection.on('click', function () {
            pushItem({
                data: directionData,
                table: tableInputDirection,
                input: inputDirection,
                removeClass: 'button-remove-direction',
                hiddenName: 'Direction',
                hiddenClass: 'recipe-directions',
                hiddenInput: inputDirectionHidden
            });
            $(this).blur();
        });

        formRecipe.on('click', '.button-remove-direction', function () {
            var row = $(this).closest('tr');
            var uuid = row.data('uuid');
            row.remove();
            spliceItem($(this), directionData);
            buildInputs(directionData, 'recipe-directions', 'Direction');
            reorderItem(directionData, tableInputDirection, inputDirectionHidden);
        });
    };

    app.recipe = {
        init: actionInit,
        form: actionForm
    }
}(app));