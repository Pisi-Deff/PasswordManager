$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    if (document.referrer !== "") {
        $('.backBtn').addClass('show');
    }

    var $newPassField1 = $('input[name="newpass1"]'),
        $newPassField2 = $('input[name="newpass2"]');

    var $entropyBitsBrute = $('.pwStrengthBits'),
        $entropyBitsDictionaryBlock = $('.dictionaryEntropyBlock'),
        $entropyBitsDictionary = $entropyBitsDictionaryBlock.find('.pwStrengthBitsDictionary');

    $newPassField1.on('keyup change', function () {
        $entropyBitsDictionaryBlock.removeClass('shown');
        $entropyBitsBrute.text('0');

        $.post('?page=AJAX&action=checkpass', {'password' : $newPassField1.val()})
            .done(function (data) {
                $entropyBitsBrute.text(data.entropyBits);

                $('[data-strength]')
                    .removeClass('shown')
                    .filter('[data-strength="' + data.strength + '"]')
                    .addClass('shown');
                
                updatePasswordRules(data.matchErrors);
            })
            .fail(function () {
                // TODO: error
            });
    });
    if ($newPassField1.val().length) {
        $newPassField1.change();
    }

    $newPassField2.on('keyup change', function () {
        updateMatchRule();
    });

    $('.genPassBtn').click(function () {
        var $btn = $(this);
        $newPassField1.val('');
        $btn.button('loading');
        
        $.getJSON('?page=AJAX&action=genpass')
            .done(function (data) {
                $newPassField1.val(data.password);
                var $maskBtn = $newPassField1.siblings('.passwordMaskBtn');
                if ($maskBtn.hasClass('masked')) {
                    $maskBtn.click();
                }
                $newPassField2.val('');

                $entropyBitsDictionaryBlock.addClass('shown');
                $entropyBitsBrute.text(data.entropyBits);
                $entropyBitsDictionary.text(data.dictEntropyBits);

                $('[data-strength]')
                    .removeClass('shown')
                    .filter('[data-strength="' + data.strength + '"]')
                    .addClass('shown');

                updatePasswordRules(data.matchErrors);
            })
            .fail(function () {
                // TODO: error
            })
            .always(function () {
                $btn.button('reset');
            });
    });

    $('.passwordMaskBtn').click(function () {
        var $btn = $(this);
        var $field = $btn.siblings('input');

        if ($btn.hasClass('masked')) {
            $btn.addClass('unmasked').removeClass('masked');
            $field.attr('type', 'text');
        } else {
            $btn.addClass('masked').removeClass('unmasked');
            $field.attr('type', 'password');
        }
    });

    function updatePasswordRules($matchErrors) {
        var $items =  $('.pwStrengthItem');
        $items.each(function () {
            var $this = $(this),
                id = $this.data('id');

            if ($.inArray(id, $matchErrors) !== -1) {
                $this.removeClass('valid').addClass('invalid');
            } else {
                $this.removeClass('invalid').addClass('valid');
            }
        });

        updateMatchRule();
    }

    function updateMatchRule() {
        var $matchItem =  $('.pwStrengthItem[data-id="match"]');

        if ($newPassField1.val() === $newPassField2.val()) {
            $matchItem.removeClass('invalid').addClass('valid');
        } else {
            $matchItem.removeClass('valid').addClass('invalid');
        }
    }
});