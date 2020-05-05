$(document).ready(function(){
    // Copy to clipboard
    $(document).on('click', '.address-copy', function (e) {
        var email = $(this);
        email.select();
        document.execCommand("copy");
        $('.message-copy').show();
        $('.message-copy').delay(1000).fadeOut();
    });
    $(document).on('click', '.email-td', function (e) {
            var temp = $("<input>");
            $("body").append(temp);
            temp.val($(this).text()).select();
            document.execCommand("copy");
            temp.remove();
            $('.message-copy').show();
            $('.message-copy').delay(1000).fadeOut();
    });
    
    //Only physical save on table
    $(document).on('click', '.store-physical', function (e) {
        var id = $(this).attr('id');
        var url = $('#physical-form-' + id).prop('action') + id;
        var data = $('#physical-form-' + id).serialize();
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (response) {
                var obj = JSON.parse(response);
                if(obj.yes){
                    $('#physi' + id).attr('checked', 'checked');
                    // $('.update' + id).css("font-size", "20");
                    $('.update' + id).show();
                    $('.update' + id).text('UPDATED')
                    $('.update' + id).delay(1000).fadeOut();
                }else if (obj.exists){
                    $('.update' + id).show();
                    // $('.update' + id).css("font-size", "20");
                    $('.update' + id).text(obj.exists)
                    $('.update' + id).delay(1000).fadeOut();
                }else{
                    $('#physi' + id).removeAttr('checked');
                    // $('.update' + id).css("font-size", "20");
                    $('.update' + id).show();
                    $('.update' + id).text('UPDATED')
                    $('.update' + id).delay(1000).fadeOut();
                } 
            }
        })
    }); 
    //Mouse over on Show
    // var history_disable = '';
    let history_disable = 'enabled';
    $(document).on("mouseover", ".contact-show", function (e) {
        history_disable = 'disabled';
        var id = $(this).attr("extra-id");
        var container_more = $('#container-hidden' + id);
        container_more.addClass("flex");
        show_hover(id);
        function show_hover(id)
        {
            $('.contact-show').mouseover(function(){
                container_more.removeClass('flex');
            })
            $(document).on('click', '.close', function (e){
                container_more.removeClass('flex');
                history_disable = 'enabled';       
            })   
            $(document).mouseup(function (e) { 
            if ($(e.target).closest(container_more).length === 0) {
                container_more.removeClass('flex'); 
                history_disable = 'enabled';
                } 
            });    
        }
    })
      //Mouse over on History
      $(document).on("mouseover", ".contact-history", function (e) {
      if (history_disable == 'disabled') {
      }else if(history_disable == 'enabled'){
            $(this).click();
            var id = $(this).attr("extra-id");
            $('#container-hidden-history' + id).css("display", "");
            $('.modal').css("height", 'auto');
            show_hover_history(id);
            function show_hover_history(id)
            {
                let container = $('#container-hidden-history' + id);
                $(document).one("mouseover", ".contact-history", function (e) {
                    container.css("display", "none");
                })
                $(document).on('click', '.close', function (e){
                    container.css("display", "none");
                })      
            }      
        }
    })
    //Nav menu mobile device
    function classToggle() {
        const navs = document.querySelectorAll('.Navbar__Items')
        navs.forEach(nav => nav.classList.toggle('Navbar__ToggleShow'));
    }
    document.querySelector('.Navbar__Link-toggle')
    .addEventListener('click', classToggle);
    // History details ajax form(the table submit action)
    $(document).on('click', '#history-submit', function (e) {
        e.preventDefault();
        var url = $('#history-form').prop('action');
        var data = $('#history-form').serialize();
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (response){
                var obj = JSON.parse(response);
                let html = [
                    '<span id="textID" class="card-title titles">' + obj.success + '</span>',
                ].join("\n");
                $("#notify").show();
                $("#notify__message").append(html);
                $("#notify").delay(1500).fadeOut(200);
                $(".jquery-modal").delay(1500).fadeOut('slow', function() {
                    $(this).removeClass("blocker");
                });
            }
        })
    })    
    //Contact delete
    $(document).on('click', '.modalBtnContact', function (e) {
        let modalContact = document.getElementById("myModalContact");
        let btnContact = document.getElementsByClassName("modalBtnContact");
        for (var i=0; i < btnContact.length; i++) {
            // Here we have the same onclick
            btnContact.item(i).onclick = modalShow;
        }
        function modalShow(){
            document.getElementById("delete-contact-form").reset();
            document.getElementById('container-modal__delete-contact').style.display = "inline";
            modalContact.style.display = "flex";
        }
        $(document).on('click', '.close', function (e){
            modalContact.style.display = "none";
        })
        var id = $(this).attr('data-delete');
        $(document).on('click', '.form-confirm', function (e) {
            response = null;
            var response = $(this).attr('name');
            var url = $('#delete-contact-form').prop('action') + id
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: url,
                data: {id: id, response: response},
                success: function (response){
                    var obj = JSON.parse(response);
                    if(!obj.length == 0){
                        location.reload(true);
                    }else{
                        id = null;
                        $(".container-modal__delete").attr("style", "display:none");
                    } 
                }
            })
        })
    })
    //History delete
    $(document).on('click', '.modalBtnHistory', function (e) {
        let modalHistory = document.getElementById("myModalHistory");
        // Get the button that opens the modal
        let btnHistory = document.getElementsByClassName("modalBtnHistory");
        for (var i=0; i < btnHistory.length; i++) {
            // Here we have the same onclick
            btnHistory.item(i).onclick = modalShow;
        }
        function modalShow(){
            document.getElementById("delete-history-form").reset();
            document.getElementById('container-modal__delete-history').style.display = "inline";
            modalHistory.style.display = "flex";
        }
        $(document).on('click', '.close', function (e){
            modalHistory.style.display = "none";
        })
        var id = $(this).attr('data-delete');
        $(document).on('click', '.form-confirm', function (e) {
            response = null;
            var response = $(this).attr('name');
            var url = $('#delete-history-form').prop('action') + id
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: url,
                data: {id: id, response: response},
                success: function (response){
                    var obj = JSON.parse(response);
                    if(!obj.length == 0){
                        location.reload(true);
                    }else{
                        id = null;
                        $(".container-modal__delete").attr("style", "display:none");
                    } 
                }
            })
        })
    })
    //Genere delete
    $(document).on('click', '.modalBtnGen', function (e) {
        // The modal
        let modalGen = document.getElementById("myModalGen");
        // Get the button that opens the modal
        let btnGen = document.getElementsByClassName("modalBtnGen");
        for (var i=0; i < btnGen.length; i++) {
            btnGen.item(i).onclick = modalShow;
        }
        function modalShow(){
            // document.getElementById("delete-genre-form").reset();
            document.getElementById("delete-genre-form").reset();
            document.getElementById('container-modal__delete-genre').style.display = "inline";
            modalGen.style.display = "flex";
        }
        $(document).on('click', '.close', function (e){
            modalGen.style.display = "none";
        })
        let id = $(this).attr('data-delete');  
        $(document).on('click', '.form-confirm', function (e) {
            response = null;
            var response = $(this).attr('name');
            var url = $('#delete-genre-form').prop('action') + id
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: url,
                data: {id: id, response: response},
                success: function (response){
                    var obj = JSON.parse(response);
                    if(obj !== 'Cancel'){
                        location.reload(true);
                    }else{
                        id = null;
                        $(".container-modal__delete").attr("style", "display:none");
                    } 
                }
            })
        })
    })
    
    //Category delete
    $(document).on('click', '.modalBtnCat', function (e) {
        // The modal
        let modalCategory = document.getElementById("myModalCat");
        // Get the button that opens the modal
        let btn = document.getElementsByClassName("modalBtnCat");
        for (var i=0; i < btn.length; i++) {
            // Here we have the same onclick
            btn.item(i).onclick = modalShow;
        }
        function modalShow(){
            document.getElementById("delete-cat-form").reset();
            document.getElementById('container-modal__delete-cat').style.display = "inline";
            modalCategory.style.display = "flex";
        }
        $(document).on('click', '.close', function (e){
            modalCategory.style.display = "none";
        })
        let id = $(this).attr('data-delete');  
        $(document).on('click', '.form-confirm', function (e) {
            response = null;
            var response = $(this).attr('name');
            var url = $('#delete-cat-form').prop('action') + id
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: url,
                data: {id: id, response: response},
                success: function (response){
                    var obj = JSON.parse(response);
                    if(obj !== 'Cancel'){
                        location.reload(true);
                    }else{
                        id = null;
                        $(".container-modal__delete").attr("style", "display:none");
                    } 
                }
            })
        })
    })
    
    //In use variables
    var url = $('.mainSearch').attr('action');
    var app_url = 'http://bugnorak.local/';
    //Triggering the search at loading the page
    $("document").ready(function() {
        setTimeout(function() {
            $("#searchSelect").trigger('click');
        },10);
    });
    //AJAX LIVE SEARCH
    $('#searchSelect').click(function(e){
        e.preventDefault();
        var url = app_url + "search/search";
        $.ajax({
            type: "GET",
            url: url,
            data: {genre: $('#genres').val(), media: $('#medias').val(), country: $('#countries').val(), meet: $('#meet:checked').val(), response: $('#response:checked').val()},
            success: function (response) {
                $('.search-wrapper').html(response);
            }
        })
    });
    //SEARCH - WITH DROP & SUBMIT IN AJAX
    $('#submitSearch').click(function(e){
        e.preventDefault();
        var urlSearch = app_url + "contact/search2";
        $.ajax({
            type: "POST",
            url: urlSearch,
            data: {genres: $('#SelectGen').val(), categories: $('#SelectCat').val(), countries: $('#SelectCoun').val()},
            success: function(response){
                var obj = JSON.parse(response);
            }
        })
    });
    //REGISTER FORM EMAIL VALIDATION
    $('#emailRegister').change(function () {
        var urlRegister = app_url + "account/uniqEmail";
        var emailInput = $('#emailRegister').serialize();
        $.ajax({
            type: "POST",
            url: urlRegister,
            data: {email: $(this).val()}, 
            success: function(response) {
                if (response != 'true'){
                    $('.msg').hide();
                    $('#emailRegister').removeClass('red');
                    $('#submitRegister').removeAttr("disabled");
                    $('.msg').show('slow');
                    $('.msg').text('Free email');
                    $('.msg').delay(1000).slideUp('fast');
                } else{
                    $('#submitRegister').attr('disabled', 'true');
                    $('.msg').hide();
                    $('#emailRegister').addClass('red');
                    $('.msg').text('Email in use');
                    $('.msg').show('slow');
                    $('.msg').addClass('red');
                    // $(selector).hide(speed,easing,callback)
                }
            }
        })
    });
    //PASSWORD VALIDATION
    $('#password2').change(function(){
        var pass1 = $('#password').val();
        var pass2 = $('#password2').val();
        if (pass1 != pass2){
            $('.msg').hide();
            $('#password').addClass('red');
            $('.msg').text('Password does not match');
            $('.msg').show('slow');
            $('.msg').addClass('red');
            $('#submitRegister').attr('disabled', 'true');
            
        }else{
            $('#password').removeClass('red');
            $('.msg').delay(1000).slideUp('fast');
            $('#submitRegister').removeAttr("disabled");
        }
    });
    //------
    //AVOIDS REFRESHING WEB - SENDS REQUEST - HIDES FORM AND FORMAT THE MODAL
    $('#submitRegister').click(function(e){
        e.preventDefault();
        let url = app_url + "account/create";
        $.ajax({
            type: "POST",
            url: url,
            data: {username: $('#Username').val(), email: $('#emailRegister').val(), password: $('#password').val()},
            success: function(response){
                var obj = JSON.parse(response);
                $('.registerForm').hide();
                $('.forEmail').text('Thank you for registering, activation email sent to: ' + obj.email);
            }
        })
    });
    
    function allowDrop(ev) {
        ev.preventDefault();
      }
      
      function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
      }
      
      function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        ev.target.appendChild(document.getElementById(data));
      }
    
});



