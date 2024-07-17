<script>
    let mealPriceId = $("#mealPriceId");
    mealPriceId.on('change', function (){
        let code = $("#mealPriceId :selected").attr('code')
        $('#mealPriceCode').val(code)
    })

    let mealPriceTimeout = null;
    $('#mealPriceCode').on('keyup', function (){
        clearTimeout(mealPriceTimeout)
        $("#mealPriceId option[value='']").prop('selected', true);
        let code = $(this).val();

        mealPriceId.val("")
        $("#mealPriceId option").each(function () {
            let selected = $(this).attr('code');
            let selected_val = $(this).val();
            if (selected == code) {
                mealPriceId.val(selected_val);
            }
        });

        mealPriceTimeout = setTimeout(function (){
            mealPriceId.change();
        }, 500)


    })
</script>
