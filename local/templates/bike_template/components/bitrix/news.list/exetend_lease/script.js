$(document).ready(function (){
    if($('*').is('.parametrs-item__select')) {
        var hours = parseInt($('#hours_select').val());
        var date_end = $('[name="DATE_END"]').val();
        var time = moment(date_end.split(" ")[1],'HH:mm');
        if (hours != NaN) {
            var returnIn = time.add((hours+1),'hours').format('HH:mm');
            $('#returnIn').val(returnIn);
            var total = 0;
            $('#price_list').find('div').each(function (){
                var price = parseInt($(this).html());
                total += price * (hours / 2);
            })
            $('#price_exetend').html(total + ' AED');
            $('#button_exetend').prop('disabled', false);
            $('#button_exetend').removeClass('button_gray');
        } else {
            $('#button_exetend').prop('disabled', true);
            $('#button_exetend').addClass('button_gray');
        }

        $('#hours_select').on('change',function (){
            var hours = parseInt($(this).val());
            var date_end = $('[name="DATE_END"]').val();
            var time = moment(date_end.split(" ")[1],'HH:mm');
            var returnIn = time.add((hours+1),'hours').format('HH:mm');
            $('#returnIn').val(returnIn);
            var total = 0;
            $('#price_list').find('div').each(function (){
                var price = parseInt($(this).html());
                total += price * (hours / 2);
            })
            $('#price_exetend').html(total + ' AED');
        })
    }


    // кнопка продлить
    $('#button_exetend').on('click',function (){
        var parent = $(this).closest('.filter_prodlen');
        var type_rent = parent.find('[data-type-rent]').data('type-rent');
        var type_payment = parent.find('[name="PAYMENT_SYSTEM"]:checked').val();
        var new_price = parent.find('#price_exetend').html();
        var orderId = parent.find('[name="ORDER_ID"]').val();
        if(type_rent == "days"){
            var date1 = moment(parent.find('#date-range200').val(), 'DD.MM.YYYY HH:mm');
            var date2 = moment(parent.find('#inputssingle').val(), 'DD.MM.YYYY HH:mm');
            var diffTime = date2.diff(date1,'days');
            var new_date = parent.find('#inputssingle').val();
        }else{
            var diffTime = $('#hours_select').val();
            var new_date = moment(parent.find('[name="DATE_END"]').val(), 'DD.MM.YYYY HH:mm');
            new_date = new_date.add(diffTime,'hours').format('DD.MM.YYYY HH:mm');
        }
        console.log(new_date);
        $.ajax({
            type: "POST",
            url: "/ajax/exteneded_leases.php",
            data: {"ORDER_ID":orderId,"TYPE_AREND":type_rent,"PAYMENT_SYSTEM":type_payment,"NEW_PRICE":new_price,"NUM_DAYS_HOURS":diffTime,"NEW_DATE_END":new_date},
            dataType: 'json',
            success: function(json){
                if (json.STATUS == "success") {
                    $('#popup-success').click();
                }
                if (json.STATUS == "error") {
                    alert(json.ERRORS);
                }
            }
        });
    })
})
