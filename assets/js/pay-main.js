

$('body').on('keydown','#transaction-price',function () {
    var price=parseInt($('#transaction-price').val());
    console.log(price);
    console.log($('#cost').text());

    var cost=parseInt($('#cost').text());
    console.log(cost);
    var sum=$('#sum').text(accounting.formatMoney((price+cost), " IRR ", 0));
    $('#pay-price').text(accounting.formatMoney(price, " IRR ", 0));

});
$('body').on('keyup','#transaction-price',function () {
    var price=parseInt($('#transaction-price').val());
    console.log(price);
    var cost=parseInt($('#cost').text());
    console.log(cost);
    var sum=$('#sum').text(accounting.formatMoney((price+cost), " IRR ", 0));
    $('#pay-price').text(accounting.formatMoney(price, " IRR ", 0));

});
