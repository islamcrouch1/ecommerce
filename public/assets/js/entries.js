$(document).ready(function(){



    $('.acc-type').on('change', function() {
        var type = $(this).find(":selected").val();
        if(type == "receipt_notes" || type == "payment_notes") {
            $('.due-date').show();
            $('.duedate-field').attr('required' , true);

        }else{
            $('.due-date').hide();
            $('.duedate-field').attr('required' , false);
        }
        var url = $('.acc-model-search').data('url');
        var locale = $('.acc-model-search').data('locale');
        getOperationsAccounts(type , url , locale);
    });

    var type = $('.acc-type').find(":selected").val();
    if(type == "receipt_notes" || type == "payment_notes") {
        $('.due-date').show();
        $('.duedate-field').attr('required' , true);

    }else{
        $('.due-date').hide();
        $('.duedate-field').attr('required' , false);
    }
    var url = $('.acc-model-search').data('url');
    var locale = $('.acc-model-search').data('locale');
    getOperationsAccounts(type , url , locale);

    function getOperationsAccounts(type , url , locale){
        var formData = new FormData();
        formData.append('account_type' , type );
        $.ajax({
            url: url,
            data: formData,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {



                if(data.status == 1){

                    $('.acc-model-search').children().remove().end()

                    var array = data.elements;
                    array.forEach(element => {
                        $('.acc-model-search').append(
                            `<option value="`+ element.id +`">`+ (locale == 'ar' ? element.name_ar : element.name_en) +`</option>`
                        )
                    });

                }else{
                    $('.acc-model-search').children().remove().end()
                }

            }
        });
    }



    $('.operation').on('change', function() {
        showFields();
    });

    showFields();






    $('.suppliers-field').on('change', function() {

        var supplier_id = $('.suppliers-field').find(":selected").val();
        var type = $('.suppliers-field').data('user_type');
        var url = $('.purchasesorders-field').data('url');
        var locale = $('.purchasesorders-field').data('locale');


        getInvoices(supplier_id , type , url , locale);
    });


    $('.employees-field').on('change', function() {

        var users = [];
        $('.employees-field :selected').each(function(i, sel){
            users.push($(sel).val());
        });
        var type = $('.employees-field').data('user_type');
        var url = $('.employees-field').data('salary_card_url');
        var salary_url = $('.employees-field').data('salary_url');
        var locale = $('.employees-field').data('locale');



        getSalaryCards(users , type , url , locale);
        getSalary(users , type , salary_url , locale);
    });




    $('.customers-field').on('change', function() {



        var supplier_id = $('.customers-field').find(":selected").val();
        var type = $('.customers-field').data('user_type');
        var url = $('.purchasesorders-field').data('url');
        var locale = $('.purchasesorders-field').data('locale');


        getInvoices(supplier_id , type, url , locale);
    });


    $('.employee-field').on('change', function() {

        var user_id = $('.employee-field').find(":selected").val();
        var url = $('.petty_cash-field').data('url');
        var locale = $('.petty_cash-field').data('locale');

        getPettyCash(user_id , url , locale);
    });


    function getPettyCash(user_id ,  url , locale){







        var formData = new FormData();
        formData.append('user_id' , user_id );


        $.ajax({
            url: url,
            data: formData,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {



                if(data.status == 1){

                    $('.petty_cash-field').val('');
                    var text = (locale == 'ar' ? ' اجمالي العهدة : ' + ' ' + data.total_petty_amount + ' - ' + 'اجمالي كشوفات التسوية' + ' : ' + (parseFloat(data.total_sheets_amount)).toFixed(2)  + ' - ' + 'اجمالي المتبقي من العهده' + ' : ' + (parseFloat(data.total_remaining_amount)).toFixed(2)  : 'total petty cash : ' + ' ' + data.total_petty_amount + ' - ' + 'Total settlement sheets' + ' : ' + (parseFloat(data.total_sheets_amount)).toFixed(2)  + ' - ' + 'remaining petty cash' + ' : ' + (parseFloat(data.total_remaining_amount)).toFixed(2))
                    $('.petty_cash-field').val(text);

                }else{
                    $('.petty_cash-field').val('');
                }

            }
        });
    }


    function getInvoices(supplier_id  , type, url , locale){
        var formData = new FormData();
        formData.append('supplier_id' , supplier_id );
        formData.append('type' , type );
        $.ajax({
            url: url,
            data: formData,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {

                if(data.status == 1){

                   if(type == 'purchases'){
                    $('.purchasesorders-field').children().remove().end()
                    $('.salesorders-field').children().remove().end();
                    $('.withdrawals-field').children().remove().end();

                    var array = data.elements;
                    array.forEach(element => {

                        var text = getInvoiceText(element , locale);

                        $('.purchasesorders-field').append(
                            `<option value="`+ element.id +`">`+ text +`</option>`
                        )
                    });


                    var array = data.withdrawals;
                    array.forEach(element => {

                        var text = (locale == 'ar' ? 'طلب سحب رقم : ' + ' ' + element.id + ' - ' + 'اجمالي قيمة طلب السحب' + ' : ' + element.amount : 'Withdrawal request No : ' + ' ' .  element.id  + ' - ' + 'total withdrawal amount' + ' : ' + element.amount )

                        $('.withdrawals-field').append(
                            `<option value="`+ element.id +`">`+ text +`</option>`
                        )
                    });

                   }else{
                    $('.purchasesorders-field').children().remove().end()
                    $('.salesorders-field').children().remove().end();
                    $('.withdrawals-field').children().remove().end();

                    var array = data.elements;
                    array.forEach(element => {

                        var text = getInvoiceText(element , locale);


                        $('.salesorders-field').append(
                            `<option value="`+ element.id +`">`+ text +`</option>`
                        )
                    });
                   }

                }else{
                    $('.purchasesorders-field').children().remove().end();
                    $('.salesorders-field').children().remove().end();
                    $('.withdrawals-field').children().remove().end();

                }

            }
        });
    }

    function getInvoiceText(element , locale){

        var text = '';
        var invoice_serial = element.type + ': ' + element.serial + ' ';
        var order_serial = element.order_serial != null ? ( (locale == 'ar' ? 'رقم الطلب: ' : 'order no: ' ) + element.order_serial + ' ' ) : '';
        var total_amount = (locale == 'ar' ? 'المبلغ الاجمالي: ' : 'total amount: ') + element.total_amount + element.symbol + ' ';
        var due_amount = (locale == 'ar' ? 'المبلغ المستحق: ' : 'due amount: ') + element.due_amount + element.symbol + ' ';
        text = invoice_serial + order_serial + total_amount + due_amount;

        return text;
    }


    function getSalaryCards(users , type , url , locale){
        var formData = new FormData();

        for (var i = 0; i < users.length; i++) {
            formData.append('users[]', users[i]);
          }

        formData.append('type' , type );
        $.ajax({
            url: url,
            data: formData,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {



                if(data.status == 1){

                    $('.salary_cards-field').children().remove().end()

                    var array = data.elements;
                    array.forEach(element => {

                        var text = (locale == 'ar' ? 'راتب شهر : ' + ' ' + element.date + ' - ' + 'اجمالي الراتب' + ' : ' + (parseFloat(element.basic_salary) + parseFloat(element.variable_salary)).toFixed(2)  + ' - ' + 'اجمالي المستقطع' + ' : ' + (parseFloat(element.total_deduction)).toFixed(2) + ' - ' + 'اجمالي الاضافي' + ' : ' + (parseFloat(element.rewards)).toFixed(2) + ' - ' + 'صافي الراتب' + ' : ' + (parseFloat(element.net_salary)).toFixed(2) : 'Month\'s salary: ' + ' ' + element.date + ' - ' + 'Total salary' + ' : ' + (parseFloat(element.basic_salary) + parseFloat(element.variable_salary)).toFixed(2)  + ' - ' + 'Total deduction' + ' : ' + (parseFloat(element.total_deduction)).toFixed(2) + ' - ' + 'Total rewards' + ' : ' + (parseFloat(element.rewards)).toFixed(2) + ' - ' + 'Net salary' + ' : ' + (parseFloat(element.net_salary)).toFixed(2))

                        $('.salary_cards-field').append(
                            `<option value="`+ element.date +`">`+ text +`</option>`
                        )
                    });
                   }

                else{
                    $('.salary_cards-field').children().remove().end();
                }

            }
        });
    }


    function getSalary(users , type , url , locale){
        var formData = new FormData();

        for (var i = 0; i < users.length; i++) {
            formData.append('users[]', users[i]);
          }

        formData.append('type' , type );
        $.ajax({
            url: url,
            data: formData,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {



                if(data.status == 1){

                    $('.salary-field').children().remove().end()

                    var array = data.elements;
                    array.forEach(element => {

                        var text = (locale == 'ar' ? 'راتب شهر : ' + ' ' + element.date + ' - ' + 'صافي الراتب' + ' : ' + (parseFloat(element.net_salary)).toFixed(2) : 'Month\'s salary: ' + ' ' + element.date + ' - ' + 'Net salary' + ' : ' + (parseFloat(element.net_salary)).toFixed(2))

                        $('.salary-field').append(
                            `<option value="`+ element.date +`">`+ text +`</option>`
                        )
                    });
                   }

                else{
                    $('.salary-field').children().remove().end();
                }

            }
        });
    }


    function showFields(){

        var type = $('.operation').find(":selected").val();

        if(type == "sell_fixed_assets" || type == "purchase_fixed_assets") {
            $('.fixedassets').show();
            $('.fixedassets-field').attr('required' , true);

        }else{
            $('.fixedassets').hide();
            $('.fixedassets-field').attr('required' , false);
        }





        if(type == "payment_receipts_purchases") {
            $('.purchasesorders').show();
            $('.purchasesorders-field').attr('required' , true);

        }else{
            $('.purchasesorders').hide();
            $('.purchasesorders-field').attr('required' , false);
        }


        if(type == "payment_receipts_purchases" || type == "pay_withdrawal_request") {
            $('.suppliers').show();
            $('.suppliers-field').attr('required' , true);
        }else{
            $('.suppliers').hide();
            $('.suppliers-field').attr('required' , false);
        }



        if(type == "receipts_sales") {
            $('.customers').show();
            $('.customers-field').attr('required' , true);
            $('.salesorders').show();
            $('.salesorders-field').attr('required' , true);

        }else{
            $('.customers').hide();
            $('.customers-field').attr('required' , false);
            $('.salesorders').hide();
            $('.salesorders-field').attr('required' , false);
        }


        if(type == "pay_withdrawal_request") {
            $('.operation_type').hide();
            $('.operation_type-field').attr('required' , false);
            $('.amount').hide();
            $('.amount-field').attr('required' , false);
            $('.withdrawals').show();
            $('.withdrawals-field').attr('required' , true);

        }else{
            $('.operation_type').show();
            $('.operation_type-field').attr('required' , true);
            $('.amount').show();
            $('.amount-field').attr('required' , true);
            $('.withdrawals').hide();
            $('.withdrawals-field').attr('required' , false);
        }




        if(type == "salary_card_proof") {
            $('.employees').show();
            $('.employees-field').attr('required' , true);
            $('.salary_cards').show();
            $('.salary_cards-field').attr('required' , true);
            $('.amount').hide();
            $('.amount-field').attr('required' , false);
            $('.acc').hide();
            $('.acc-type').attr('required' , false);
            $('.account').hide();
            $('.account-field').attr('required' , false);
            $('.salary').hide();
            $('.salary-field').attr('required' , false);

        }else if(type == "salary_payment"){

            $('.employees').show();
            $('.employees-field').attr('required' , true);
            $('.salary').show();
            $('.salary-field').attr('required' , true);
            $('.amount').hide();
            $('.amount-field').attr('required' , false);
            $('.salary_cards').hide();
            $('.salary_cards-field').attr('required' , false);
            $('.acc').show();
            $('.acc-type').attr('required' , true);
            $('.account').show();
            $('.account-field').attr('required' , true);

        }else if(type == "petty_cash_settlement"){

            $('.amount').hide();
            $('.amount-field').attr('required' , false);
            $('.operation_type').hide();
            $('.operation_type-field').attr('required' , false);
            $('.petty_cash').show();
            $('.petty_cash-field').attr('required' , true);

            $('.petty_cash_title').show();

            $('.expenses_account').show();
            $('.expenses_account-field').attr('required' , true);

        }else{
            $('.employees').hide();
            $('.employees-field').attr('required' , false);
            $('.salary_cards').hide();
            $('.salary_cards-field').attr('required' , false);
            $('.amount').show();
            $('.amount-field').attr('required' , true);
            $('.acc').show();
            $('.acc-type').attr('required' , true);
            $('.account').show();
            $('.account-field').attr('required' , true);
            $('.salary').hide();
            $('.salary-field').attr('required' , false);
            $('.operation_type').show();
            $('.operation_type-field').attr('required' , true);
            $('.petty_cash').hide();
            $('.petty_cash-field').attr('required' , false);

            $('.petty_cash_title').hide();

            $('.expenses_account').hide();
            $('.expenses_account-field').attr('required' , false);

        }



        if(type == "employee_loan" || type == "petty_cash" || type == "petty_cash_settlement") {
            $('.employee').show();
            $('.employee-field').attr('required' , true);

        }else{
            $('.employee').hide();
            $('.employee-field').attr('required' , false);
        }





    }






        // add accounts
        var maxField = 50; //Input fields increment limitation
        var addButton = $('.add_expenses_account'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper

        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increment field counter

                const  accounts = $('.add_expenses_account').data('accounts');
                var locale = $('.add_expenses_account').data('locale');
                var text1 = locale == 'ar' ? 'حدد الحساب' : 'select account';
                var text2 = '';


                 accounts.forEach(function(element) {
                    text2 += '<option value="'+ element.id +'">'+ (locale == 'ar' ? element.name_ar : element.name_en) +'</option>';
                });






                var fieldHTML = `
                <div class="input-group mt-3">
                    <select
                        class="form-select from-account-select"
                        aria-label="" name="expenses_accounts[]"  data-level="1"
                        required>
                        <option value="">`+ text1  +`</option>`+ text2 +`
                    </select>
                    <input name="expenses_amounts[]" class="form-control"  type="number"
                    placeholder="`+ (locale == 'ar' ? 'المبلغ' : 'amount') +`" min="0" step="0.01" required />
                    <a href="javascript:void(0);" class="remove_button">
                        <span class="input-group-text" id="basic-addon1">
                            <span class="far fa-trash-alt text-danger fs-2"></span>
                        </span>
                    </a>
                </div>`; //New input field html

                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });


        $('.field_wrapper').on('change' , '.from-account-select' , function(e){
            e.preventDefault();
            var elem = $(this);
            getAccounts(elem , 'from');

        });


        function getAccounts(elem , dir){


            var url = $('.add_expenses_account').data('url');
            var locale = $('.add_expenses_account').data('locale');
            var account_id = elem.find(":selected").val();
            var account_name = elem.find(":selected").text();
            var level = elem.data('level');

            var formData = new FormData();
            formData.append('account_id' , account_id );
            $.ajax({
                url: url,
                data: formData,
                method: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {

                    if(data.status == 1){
                        for (var i = 20; i >= level; i--) {
                            $('.'+dir+'-account'+i).remove();
                          }

                        var array = data.elements;
                        if(array.length == 0){
                            return;
                        }
                        var options = '';

                        array.forEach(element => {
                            options += `<option value="`+element.id+`">
                                        `+element.name+`
                                        </option>`;
                        });

                        elem.parent().prepend(
                            `<select
                                class="form-select `+dir+`-account-select"
                                aria-label="" name="expenses_accounts[]" required>
                                    <option value="">`+(locale == 'ar' ? 'حدد الحساب' : 'select account')+`</option>`
                                +options+
                            `</select>
                            `
                        );

                        elem.closest('.form-select').remove();



                    }
                }
            });
        }



});



