$(function() {

    $('.filter-rbtn').change(function() {
        $(this).parent().parent().find('.filter-input').hide();
       if($(this).is(':checked')) {
           $(this).parent().find('.filter-input').show();
       }
    });

    $('.filter-rbtn').each(function() {
       if($(this).is(':checked')) {
           $(this).parent().find('.filter-input').show();
       }
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('#all-skills-chk-toggle').change(function() {
        if($(this).is(':checked')) {
            $('.skill-chk').prop('checked', true);
        } else {
            $('.skill-chk').prop('checked', false);
        }
    });

    $('.skill-chk').change(function() {
           var all_checked = true;
           $('.skill-chk').each(function() {
              if(!$(this).is(':checked')) {
                  all_checked = false;
              }
           });

           if(all_checked) {
               $('#all-skills-chk-toggle').prop('checked', true);
           }
           else {
               $('#all-skills-chk-toggle').prop('checked', false);
           }
    });

    $(document).on('click', '.view-details', function() {
        var json = $(this).parent().find(".item_json").text();

        $.post('App/Views/modal-details.php', { json:json }, function(html) {
            $('#modal-details').html(html);
            $('#modal-details .modal').modal('show');
            $('.view-details').show();
        });
        return false;
    });

    $('#hide-intro').click(function() {
       $('.jumbotron').hide();
    });

    $('#search-ajax-btn').click(function() {
        var form = $('#searchForm');
        var q = '';
        $.ajax({
            type: 'GET',
            url: form.attr('action'),
            data: form.serialize(),
            success: function(data)
            {
                q = data;
            }
        }).done(function() {
            if(q != '') {
                $.ajax({
                    type: 'POST',
                    url: 'App/app.php',
                    data: { q:q },
                    success: function(data)
                    {
                        $('#table-data').html(data);
                    }
                });
            }
        });
    });

});