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

    var pushItem = function (data, table, input, removeClass, inputHidden, maxItem) {
        var value = '';
        if (typeof input === 'string') {
            value = input;
        } else {
            value = input.val().toString().trim();
        }
        if (maxItem === null) {
            maxItem = 20;
        }

        if (value === '' || value.length === 0) {
            alert('Please input an item');
            return false;
        } else if (data.length >= maxItem) {
            alert('Maximum ' + maxItem + ' item allow to listed');
            return false;
        } else {
            if (typeof input !== 'string') {
                input.val('');
                input.focus();
            }
            data.push(value);
            table.find('tbody').append(
                $('<tr>')
                    .append($('<td class="text-center">').text(data.length))
                    .append($('<td>').append(value))
                    .append($('<td class="text-center">').append(
                        $('<button>', {
                            class: 'btn btn-danger btn-sm ' + removeClass,
                            type: 'button'
                        }).html('<i class="fa fa-trash-o"></i>')
                        )
                    )
            );
            reorderItem(table);
            if (inputHidden !== undefined) {
                inputHidden.val(data.toString());
            }
            return true;
        }
    };

    var spliceItem = function (table, button) {
        button.closest('tr').remove();
        reorderItem(table);
    };

    var reorderItem = function (table) {
        table.find('tbody').find('tr').each(function (index) {
            $(this).children('td').first().html(index + 1);
        });
    };

    var actionInit = function () {
        var valueIngredient = inputIngredientHidden.val().toString().trim();
        if (valueIngredient !== '') {
            var valueIngredientDefault = valueIngredient.split(',');
            $.each(valueIngredientDefault, function (index, value) {
                pushItem(ingredientData, tableInputIngredient, value, 'button-remove-ingredient');
            });
        }

        var valueDirection = inputDirectionHidden.val().toString().trim();
        if (valueDirection !== '') {
            var valueDirectionDefault = valueDirection.split(',');
            $.each(valueDirectionDefault, function (index, value) {
                pushItem(directionData, tableInputDirection, value, 'button-remove-direction');
            });
        }
    };

    var actionForm = function () {
        buttonAddIngredient.on('click', function () {
            pushItem(ingredientData, tableInputIngredient, inputIngredient,
                'button-remove-ingredient', inputIngredientHidden, 20);
            $(this).blur();
        });

        formRecipe.on('click', '.button-remove-ingredient', function () {
            spliceItem(tableInputIngredient, $(this));
        });

        buttonAddDirection.on('click', function () {
            pushItem(directionData, tableInputDirection, inputDirection,
                'button-remove-direction', inputDirectionHidden, 15);
            $(this).blur();
        });

        formRecipe.on('click', '.button-remove-direction', function () {
            spliceItem(tableInputDirection, $(this));
        });
    };

    app.recipe = {
        init: actionInit,
        form: actionForm
    }
}(app));