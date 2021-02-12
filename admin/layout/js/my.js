$(function(){

    //confirmation for button
    //when click on delete button in presence of class confirm, function confirm() will be added

    $('.confirm').click(function(){

        return confirm('Are You Sure?');

    });

});