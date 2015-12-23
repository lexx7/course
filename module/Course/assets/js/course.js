Course = {
    init: function () {
        this.buttonStart();
    },
    buttonStart: function () {
        var _self = this;

        $(document).on('click', 'button.start', function () {
            var data = {
                cost: $('input[name="cost"]').val(),
                currency: $('select[name="currency"] option:selected').text()
            };

            var countThread = $('select[name="countThread"] option:selected').text();

            $('div.result').html('Выполняется запрос...');

            for(var count = 1; count <= countThread; count++) {
                _self.ajaxRequest(data);
            }

            return false;
        });
    },
    ajaxRequest: function (data) {
        $.post('/course/get-course', data, function (response) {
            var text = '{cost: ' + response.cost + ',currency: ' + response.currency + '}';
            if(typeof response.cost == 'undefined') text = 'Нет данных';
            var result = $('div.result');
            if(result.html() === 'Выполняется запрос...') {
                result.html(text);
            } else {
                result.html(result.html() + '<br>' + text);
            }
        });
    }
};

$(function () {
    Course.init();
});