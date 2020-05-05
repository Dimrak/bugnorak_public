$(document).ready(function () {

    // //In use variables
    // var url = $('.mainSearch').attr('action');
    // var app_url = 'http://bugnorak.local/';
    // //Triggering the search at loading the page
    // $("document").ready(function() {
    //     setTimeout(function() {
    //         $("#searchSelect").trigger('click');
    //     },10);
    // });
    // //AJAX LIVE SEARCH
    // $('#searchSelect').click(function(e){
    //     e.preventDefault();
    //     var url = app_url + "search/search";
    //     $.ajax({
    //         type: "GET",
    //         url: url,
    //         data: {genre: $('#genres').val(), media: $('#medias').val(), country: $('#countries').val(), meet: $('#meet:checked').val(), response: $('#response:checked').val()},
    //         success: function (response) {
    //             $('.search-wrapper').html(response);
    //         }
    //     })
    // });
    // //SEARCH - WITH DROP & SUBMIT IN AJAX
    // $('#submitSearch').click(function(e){
    //     e.preventDefault();
    //     console.log('iki cia veikia');
    //     var urlSearch = app_url + "contact/search2";
    //     $.ajax({
    //         type: "POST",
    //         url: urlSearch,
    //         data: {genres: $('#SelectGen').val(), categories: $('#SelectCat').val(), countries: $('#SelectCoun').val()},
    //         success: function(response){
    //             var obj = JSON.parse(response);
    //         }
    //     })
    // });
    // //REGISTER FORM EMAIL VALIDATION
    // $('#emailRegister').change(function () {
    //     var urlRegister = app_url + "account/uniqEmail";
    //     var emailInput = $('#emailRegister').serialize();
    //     $.ajax({
    //         type: "POST",
    //         url: urlRegister,
    //         data: {email: $(this).val()}, 
    //         success: function(response) {
    //             console.log(emailInput);
    //             if (response != 'true'){
    //                 $('.msg').hide();
    //                 $('#emailRegister').removeClass('red');
    //                 $('#submitRegister').removeAttr("disabled");
    //                 $('.msg').show('slow');
    //                 $('.msg').text('Free email');
    //                 $('.msg').delay(1000).slideUp('fast');
    //             } else{
    //                 $('#submitRegister').attr('disabled', 'true');
    //                 $('.msg').hide();
    //                 $('#emailRegister').addClass('red');
    //                 $('.msg').text('Email in use');
    //                 $('.msg').show('slow');
    //                 $('.msg').addClass('red');
    //                 // $(selector).hide(speed,easing,callback)
    //             }
    //         }
    //     })
    // });
    // //PASSWORD VALIDATION
    // $('#password2').change(function(){
    //     var pass1 = $('#password').val();
    //     var pass2 = $('#password2').val();
    //     console.log(pass1);
    //     if (pass1 != pass2){
    //         $('.msg').hide();
    //         $('#password').addClass('red');
    //         $('.msg').text('Password does not match');
    //         $('.msg').show('slow');
    //         $('.msg').addClass('red');
    //         $('#submitRegister').attr('disabled', 'true');
            
    //     }else{
    //         $('#password').removeClass('red');
    //         $('.msg').delay(1000).slideUp('fast');
    //         $('#submitRegister').removeAttr("disabled");
    //     }
    // });
    // //------
    // //AVOIDS REFRESHING WEB - SENDS REQUEST - HIDES FORM AND FORMAT THE MODAL
    // $('#submitRegister').click(function(e){
    //     e.preventDefault();
    //     console.log('prevented submit to refresh the page');
    //     let url = app_url + "account/create";
    //     $.ajax({
    //         type: "POST",
    //         url: url,
    //         data: {username: $('#Username').val(), email: $('#emailRegister').val(), password: $('#password').val()},
    //         success: function(response){
    //             // console.log(response);
    //             var obj = JSON.parse(response);
    //             console.log(obj);
    //             $('.registerForm').hide();
    //             $('.forEmail').text('Thank you for registering, activation email sent to: ' + obj.email);
    //         }
    //     })
    // });
    //------
    //DELAY IN SEARCH - DISABLED!!! not sure what it does
    // function delay(callback, ms) {
    //     var timer = 0;
    //     return function() {
    //         var context = this, args = arguments;
    //         clearTimeout(timer);
    //         timer = setTimeout(function () {
    //             callback.apply(context, args);
    //         }, ms || 0);
    //     };
    // }
    //------
    //Keyup search
    // $('#search').keyup(delay(function(){
    //     var url = app_url + "/search/search";
    //     $.ajax({
    //         type: "GET",
    //         url: url,
    //         data:{keyword: $(this).val()},
    //         success: function (response) {
    //             $('.search-wrapper').html(response);
    //         }
    //     })
    // },250));  
});

